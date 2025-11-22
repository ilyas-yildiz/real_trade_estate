<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BayiEarning;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EarningUploadedNotification;

class BayiEarningController extends Controller
{
    public function index()
    {
        // Tüm hakedişleri getir (En son yüklenen en üstte)
        $earnings = BayiEarning::with('bayi')->latest()->paginate(20);
        
        // Modal'daki select kutusu için sadece Bayileri (role=1) getir
        $bayiler = User::where('role', 1)->orderBy('name')->get();

        return view('admin.earnings.index', compact('earnings', 'bayiler'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bayi_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:xlsx,xls,csv,pdf|max:10240', // 10MB limit
            'admin_note' => 'nullable|string',
        ]);

        // Dosyayı güvenli klasöre (storage/app/earnings) kaydet
        $path = $request->file('file')->store('earnings', 'local');

        $earning = BayiEarning::create([
            'bayi_id' => $request->bayi_id,
            'title' => $request->title,
            'file_path' => $path,
            'status' => 'pending',
            'admin_note' => $request->admin_note,
        ]);

        // Bayiye bildirim gönder
        $bayi = User::find($request->bayi_id);
        if($bayi) {
             $bayi->notify(new EarningUploadedNotification($earning->id, $earning->title));
        }

        return back()->with('success', 'Hakediş dosyası yüklendi ve bayiye bildirim gönderildi.');
    }

    public function download(BayiEarning $earning)
    {
        // Dosya var mı kontrol et
        if (!Storage::disk('local')->exists($earning->file_path)) {
            return back()->with('error', 'Dosya sunucuda bulunamadı.');
        }
        return Storage::disk('local')->download($earning->file_path, $earning->title . '.' . pathinfo($earning->file_path, PATHINFO_EXTENSION));
    }

    public function destroy(BayiEarning $earning)
    {
        // Dosyayı diskten sil
        if (Storage::disk('local')->exists($earning->file_path)) {
            Storage::disk('local')->delete($earning->file_path);
        }
        
        $earning->delete();
        return back()->with('success', 'Hakediş kaydı silindi.');
    }
}