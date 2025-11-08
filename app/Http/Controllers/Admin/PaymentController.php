<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    /**
     * Ödeme bildirimlerini listeler.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Payment::with('user', 'reviewer')->latest();

        if ($user->isAdmin()) {
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $payments = $query->paginate(15);
            $users = User::orderBy('name')->get();
            return view('admin.payments.index_admin', compact('payments', 'users'));
        } else {
            $payments = $query->where('user_id', $user->id)->paginate(10);
            return view('admin.payments.index_user', compact('payments'));
        }
    }

    /**
     * Kullanıcının yeni ödeme bildirimi (dekont yükleme) formunu gösterir.
     */
    public function create()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.payments.index')->with('error', 'Adminler ödeme bildirimi oluşturamaz.');
        }
        return view('admin.payments.create');
    }

    /**
     * Kullanıcının gönderdiği yeni ödeme bildirimini kaydeder.
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            abort(403, 'Adminler ödeme bildirimi oluşturamaz.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date_format:Y-m-d',
            'reference_number' => 'nullable|string|max:255',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'user_notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $directory = 'receipts/user_' . $user->id;
        $path = $request->file('receipt')->store($directory, 'local'); // 'local' (storage/app) diskine kaydet

        if (!$path) {
            return back()->with('error', 'Dekont yüklenirken bir hata oluştu.');
        }

        $user->payments()->create([
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'reference_number' => $validated['reference_number'],
            'receipt_path' => $path,
            'user_notes' => $validated['user_notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Ödeme bildiriminiz başarıyla alındı.');
    }

    /**
     * show() metodu kullanılmıyor, edit() JSON döndürüyor.
     */
    public function show(Payment $payment)
    {
        return redirect()->route('admin.payments.index');
    }

    /**
     * Modal'da düzenlenecek ödeme verisini JSON olarak döndürür.
     * Blog modülüyle %100 uyumlu.
     */
    public function edit(Payment $payment): JsonResponse
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Yetkisiz erişim.'], 403);
        }

        $payment->load('user:id,name,email');

        // *** DÜZELTME BAŞLANGICI ***
        // $payment modelini doğrudan döndürmek, dinamik eklenen
        // (örn: amount_formatted) alanları JSON'a dahil etmez.
        // Bu yüzden manuel bir dizi (array) oluşturuyoruz.

        $data = [
            // Formdaki 'name' nitelikleriyle eşleşen veritabanı sütunları
            'status' => $payment->status,
            'reference_number' => $payment->reference_number,
            'user_notes' => $payment->user_notes,
            'admin_notes' => $payment->admin_notes,

            // Formdaki 'name' nitelikleriyle eşleşen, özel oluşturduğumuz alanlar
            'user_info' => $payment->user ? $payment->user->name . ' (' . $payment->user->email . ')' : 'Kullanıcı Silinmiş',
            'receipt_url' => $payment->receipt_url, // Accessor'dan gelen veri
            'payment_date_formatted' => $payment->payment_date->format('d.m.Y'),
            'amount_formatted' => number_format($payment->amount, 2, ',', '.'),
        ];

        // resource-handler.js'in beklediği format { item: { ... } }
        return response()->json(['item' => $data]);
        // *** DÜZELTME SONU ***
    }


  /**
     * Adminin ödeme bildirimini onaylama/reddetme işlemini yapar.
     */
    public function update(Request $request, Payment $payment) // YENİ: Otomatik Model Binding
    {
        if (!Auth::user()->isAdmin()) { // is_admin -> isAdmin()
            return response()->json(['success' => false, 'message' => 'Bu işleme yetkiniz yok.'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        // --- YENİ BAKIYE MANTIĞI BAŞLANGIÇ ---
        $originalStatus = $payment->getOriginal('status');
        $newStatus = $validated['status'];
        $user = $payment->user;
        $amount = $payment->amount;

        // 1. Durum "Onaylandı" olarak DEĞİŞTİYSE (ve daha önce Onaylı değilse)
        if ($newStatus === 'approved' && $originalStatus !== 'approved') {
            // Kullanıcının bakiyesine bu tutarı ekle
            $user->increment('balance', $amount);
        }
        // 2. Durum "Onaylandı"dan başka bir şeye DEĞİŞTİYSE (İptal/Reversal)
        elseif ($newStatus !== 'approved' && $originalStatus === 'approved') {
            // Kullanıcının bakiyesinden bu tutarı geri düş
            $user->decrement('balance', $amount);
        }
        // --- YENİ BAKIYE MANTIĞI SON ---

        $payment->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Ödeme durumu başarıyla güncellendi.']);
    }

    /**
     * Bir ödeme bildirimini siler.
     */
    public function destroy(Payment $payment)
    {
        $user = Auth::user();

        if (!($user->isAdmin() || ($payment->user_id === $user->id && $payment->status === 'pending'))) {
            abort(403, 'Bu işleme yetkiniz yok.');
        }

        if ($payment->receipt_path && Storage::disk('local')->exists($payment->receipt_path)) {
            Storage::disk('local')->delete($payment->receipt_path);
            $directory = dirname($payment->receipt_path);
            if (empty(Storage::disk('local')->files($directory)) && empty(Storage::disk('local')->directories($directory))) {
                Storage::disk('local')->deleteDirectory($directory);
            }
        }

        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Ödeme bildirimi başarıyla silindi.');
    }

    /**
     * Dekontu güvenli sunar.
     */
    public function showReceipt(Payment $payment)
    {
        $user = Auth::user();
        if (!($user->isAdmin() || $payment->user_id === $user->id)) {
            abort(403, 'Bu dekontu görüntüleme yetkiniz yok.');
        }
        if (!$payment->receipt_path || !Storage::disk('local')->exists($payment->receipt_path)) {
            abort(404, 'Dekont dosyası bulunamadı.');
        }
        $path = Storage::disk('local')->path($payment->receipt_path);
        $mimeType = Storage::disk('local')->mimeType($payment->receipt_path);
        return response()->file($path, ['Content-Type' => $mimeType]);
    }
}