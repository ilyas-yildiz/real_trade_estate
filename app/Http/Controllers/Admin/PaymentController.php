<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // JsonResponse için eklendi
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    // index(), create(), store() metotları aynı...
public function index(Request $request)
    {
        $user = Auth::user();
        $query = Payment::with('user', 'reviewer')->latest();

        if ($user->is_admin) {
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

    // create() metodu aynı kalıyor...
     public function create()
    {
        if (Auth::user()->is_admin) {
             return redirect()->route('admin.payments.index')->with('error', 'Adminler ödeme bildirimi oluşturamaz.');
        }
        return view('admin.payments.create');
    }

    /**
     * Kullanıcının gönderdiği yeni ödeme bildirimini kaydeder.
     * GÜNCELLEME: Dosya kaydetme storage/app/receipts altına yapıldı.
     */
    public function store(Request $request)
    {
        if (Auth::user()->is_admin) {
            abort(403, 'Adminler ödeme bildirimi oluşturamaz.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date_format:Y-m-d',
            'reference_number' => 'nullable|string|max:255',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
            'user_notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // GÜNCELLEME: Dosyayı storage/app/receipts/user_{id} içine kaydet
        // Storage::putFile() benzersiz isim üretir ve yolu döner.
        $directory = 'receipts/user_' . $user->id;
        // 'local' diskini (storage/app) kullanıyoruz, bu varsayılan ve güvenli olandır.
        $path = $request->file('receipt')->store($directory, 'local');

        if (!$path) {
             \Log::error('Dekont storage\'a kaydedilemedi.');
            return back()->with('error', 'Dekont yüklenirken bir hata oluştu. Lütfen tekrar deneyin.');
        }

        // Veritabanına kaydet (ilişki üzerinden)
        $user->payments()->create([
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'reference_number' => $validated['reference_number'],
            'receipt_path' => $path, // Storage içinde kaydedilen yolu yaz
            'user_notes' => $validated['user_notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Ödeme bildiriminiz başarıyla alındı ve incelemeye gönderildi.');
    }

    // GÜNCELLEME: Artık kullanılmayabilir ama silmiyoruz.
    public function show(Payment $payment)
    {
        if (!Auth::user()->is_admin) { abort(403); }
        $payment->load('user', 'reviewer');
        return view('admin.payments.show_admin', compact('payment'));
    }

    // YENİ EKLENDİ: Modal için JSON verisi döndüren metot
    /**
     * Modal'da düzenlenecek ödeme verisini JSON olarak döndürür.
     * Sadece Adminler erişebilir.
     *
     * @param Payment $payment
     * @return JsonResponse
     */
public function editJson($id): JsonResponse // DEĞİŞİKLİK: Type Hint'i kaldırdık
    {
        // Modeli kendimiz buluyoruz (Binding'i atladık)
        $payment = Payment::findOrFail($id);

        if (!Auth::user()->is_admin) {
            return response()->json(['error' => 'Yetkisiz erişim.'], 403);
        }
        
        $payment->load('user:id,name,email');

        // Geri kalan mantık aynı
        $data = [
            'id' => $payment->id,
            'amount_formatted' => number_format($payment->amount, 2, ',', '.'),
            'payment_date_formatted' => $payment->payment_date->format('d.m.Y'),
            'created_at_formatted' => $payment->created_at->format('d.m.Y H:i'),
            'reference_number' => $payment->reference_number ?? '-',
            'status' => $payment->status,
            'status_text' => match ($payment->status) {
                                'approved' => 'Onaylandı',
                                'rejected' => 'Reddedildi',
                                default => 'Beklemede',
                            },
            'status_class' => match ($payment->status) {
                                'approved' => 'bg-success-subtle text-success',
                                'rejected' => 'bg-danger-subtle text-danger',
                                default => 'bg-warning-subtle text-warning',
                            },
            'receipt_url' => $payment->receipt_url,
            'user_notes' => $payment->user_notes ?? '-',
            'admin_notes' => $payment->admin_notes ?? '',
            'user_info' => $payment->user ? $payment->user->name . ' (' . $payment->user->email . ')' : 'Kullanıcı Silinmiş',
        ];

        return response()->json(['item' => $data]);
    }


    // update(), destroy(), edit(), showReceipt() metotları aynı...
     public function update(Request $request, Payment $payment)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Bu işleme yetkiniz yok.');
        }
        $validated = $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
            'admin_notes' => 'nullable|string|max:2000',
        ]);
        $payment->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        // TODO: Kullanıcıya bildirim
        return redirect()->route('admin.payments.index')->with('success', 'Ödeme durumu başarıyla güncellendi.');
    }

    /**
     * Bir ödeme bildirimini siler.
     * GÜNCELLEME: Dosya silme storage/app klasöründen yapıldı.
     */
    public function destroy(Payment $payment)
    {
        $user = Auth::user();

        if (!($user->is_admin || ($payment->user_id === $user->id && $payment->status === 'pending'))) {
            abort(403, 'Bu işleme yetkiniz yok.');
        }

        // GÜNCELLEME: Dekont dosyasını storage/app içinden sil (varsa)
        // 'local' diskini kullanıyoruz.
        if ($payment->receipt_path && Storage::disk('local')->exists($payment->receipt_path)) {
            try {
                Storage::disk('local')->delete($payment->receipt_path);
                // Opsiyonel: Kullanıcıya ait klasör boşsa onu da silebiliriz
                $directory = dirname($payment->receipt_path);
                if (empty(Storage::disk('local')->files($directory)) && empty(Storage::disk('local')->directories($directory))) {
                     Storage::disk('local')->deleteDirectory($directory);
                }
            } catch (\Exception $e) {
                 \Log::error('Dekont (storage) silme hatası: ' . $e->getMessage());
            }
        }

        $payment->delete();
        $redirectRoute = 'admin.payments.index';
        return redirect()->route($redirectRoute)->with('success', 'Ödeme bildirimi başarıyla silindi.');
    }

    // edit() metodu aynı (kullanılmıyor)...
     public function edit(Payment $payment) { abort(404); }


    // YENİ EKLENDİ: Dekont Görüntüleme Metodu
    /**
     * Belirli bir ödemeye ait dekont dosyasını güvenli bir şekilde sunar.
     * Sadece adminler veya ödemenin sahibi erişebilir.
     *
     * @param Payment $payment
     * @return StreamedResponse|Response
     */
    public function showReceipt(Payment $payment)
    {
        $user = Auth::user();

        // Yetki Kontrolü: Admin mi VEYA ödemenin sahibi mi?
        if (!($user->is_admin || $payment->user_id === $user->id)) {
            abort(403, 'Bu dekontu görüntüleme yetkiniz yok.');
        }

        // Dosya Yolu Kontrolü: Kayıt var mı ve dosya storage/app içinde mevcut mu?
        if (!$payment->receipt_path || !Storage::disk('local')->exists($payment->receipt_path)) {
            abort(404, 'Dekont dosyası bulunamadı.');
        }

        // Dosyayı sun
        // response()->file() dosyanın içeriğini doğrudan tarayıcıda göstermeye çalışır (PDF/Resim için ideal)
        // response()->download() dosyayı indirmeye zorlar.
        // Biz görüntülemeyi tercih edelim.
        $path = Storage::disk('local')->path($payment->receipt_path); // Fiziksel yolu al
        $mimeType = Storage::disk('local')->mimeType($payment->receipt_path); // Mime tipini al (image/png, application/pdf vb.)

        // Tarayıcıya dosya içeriğini ve tipini gönder
        return response()->file($path, ['Content-Type' => $mimeType]);

        // Alternatif (İndirme):
        // return Storage::disk('local')->download($payment->receipt_path);
    }

}