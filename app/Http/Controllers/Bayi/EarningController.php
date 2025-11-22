<?php

namespace App\Http\Controllers\Bayi;

use App\Http\Controllers\Controller;
use App\Models\BayiEarning;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EarningResponseNotification;

class EarningController extends Controller
{
    public function index()
    {
        // Sadece giriş yapan bayiye ait hakedişleri getir
        // GÜNCELLEME: View yolu senin klasör yapına göre düzeltildi
        $earnings = BayiEarning::where('bayi_id', Auth::id())->latest()->paginate(20);
        return view('admin.bayi.earnings.index', compact('earnings'));
    }

    public function download(BayiEarning $earning)
    {
        // Güvenlik: Başkasının dosyasını indiremesin
        if ($earning->bayi_id !== Auth::id()) {
            abort(403);
        }
        
        if (!Storage::disk('local')->exists($earning->file_path)) {
            return back()->with('error', 'Dosya bulunamadı.');
        }

        return Storage::disk('local')->download($earning->file_path);
    }

    public function response(Request $request, BayiEarning $earning)
    {
        // Güvenlik
        if ($earning->bayi_id !== Auth::id()) { abort(403); }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'bayi_note' => 'nullable|string|max:1000',
        ]);

        $earning->update([
            'status' => $request->status,
            'bayi_note' => $request->bayi_note,
            'responded_at' => now(),
        ]);

        // Adminlere Bildirim Gönder
        $admins = User::where('role', 2)->get();
        foreach ($admins as $admin) {
            $admin->notify(new EarningResponseNotification(Auth::user()->name, $earning->title, $request->status));
        }

        $msg = $request->status == 'approved' ? 'Hakedişi onayladınız.' : 'Hakedişi reddettiniz.';
        return back()->with('success', $msg);
    }
}