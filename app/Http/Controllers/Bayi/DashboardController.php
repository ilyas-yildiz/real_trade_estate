<?php

namespace App\Http\Controllers\Bayi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Bayi dashboard anasayfası
     */
    public function index()
    {
        $user = Auth::user();
        
        // Bayiye ait müşterilerin sayısı
        $customerCount = $user->customers()->count();
        
        // Bayiye ait müşterilerin onaylanmış çekim taleplerinin toplamı
        $totalWithdrawals = $user->customerWithdrawals()->where('status', 'approved')->sum('amount');
        
        // GÜNCELLEME: 'bayi.dashboard' -> 'admin.bayi.dashboard'
        return view('admin.bayi.dashboard', compact('customerCount', 'totalWithdrawals'));
    }

    /**
     * Bayinin müşterilerini listeler
     */
    public function customers()
    {
        $customers = Auth::user()->customers()->latest()->paginate(20);
        
        // GÜNCELLEME: 'bayi.customers' -> 'admin.bayi.customers'
        return view('admin.bayi.customers', compact('customers'));
    }

    /**
     * Bayinin müşterilerinin ONAYLANMIŞ çekim taleplerini listeler
     */
    public function withdrawals()
    {
        $withdrawals = Auth::user()
                        ->customerWithdrawals() // User modelindeki HasManyThrough
                        ->where('status', 'approved') // Sadece onaylananlar
                        ->with('user') // Müşteri bilgisini de al
                        ->latest()
                        ->paginate(20);
                        
        // GÜNCELLEME: 'bayi.withdrawals' -> 'admin.bayi.withdrawals'
        return view('admin.bayi.withdrawals', compact('withdrawals'));
    }
}