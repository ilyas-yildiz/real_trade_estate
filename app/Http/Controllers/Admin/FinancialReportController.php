<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\WithdrawalRequest;
use App\Models\BayiCommission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    public function index()
    {
        // ===================================
        // 1. İSTATİSTİK KARTLARI (STATS)
        // ===================================
        
        // --- Pozitif (Giriş) ---
        $stats['total_deposits_approved'] = Payment::where('status', 'approved')->sum('amount');
        
        // --- Negatif (Çıkış) ---
        $stats['total_withdrawals_approved'] = WithdrawalRequest::where('status', 'approved')->sum('amount');
        $stats['total_commissions_paid'] = BayiCommission::sum('commission_amount');
        
        // --- Net Bakiye (Kasa) ---
        // (Yatırılan Toplam - Çekilen Toplam - Ödenen Komisyon Toplamı)
        $stats['net_balance'] = $stats['total_deposits_approved'] - $stats['total_withdrawals_approved'] - $stats['total_commissions_paid'];
        
        // --- Beklemedeki İşlemler (Firmanın Borcu) ---
        $stats['total_pending_deposits'] = Payment::where('status', 'pending')->sum('amount');
        $stats['total_pending_withdrawals'] = WithdrawalRequest::where('status', 'pending')->sum('amount');
        $stats['total_processing_withdrawals'] = WithdrawalRequest::where('status', 'processing')->sum('amount');
        
        // --- Reddedilenler (İptal) ---
        $stats['total_rejected_transactions'] = 
            Payment::where('status', 'rejected')->sum('amount') + 
            WithdrawalRequest::where('status', 'rejected')->sum('amount');

        // --- Ekstra İstatistikler (Benim önerim) ---
        // Platformun müşterilere olan toplam borcu (Tüm kullanıcı bakiyelerinin toplamı)
        $stats['total_user_balance_liability'] = User::where('role', '!=', 2)->sum('balance'); 
        
        
        // ===================================
        // 2. BİRLEŞİK İŞLEM LİSTESİ (LEDGER)
        // ===================================
        // Bu sorgu, firmanın kasasının bakış açısınadır.

        // 1. Para Girişleri (Pozitif)
        $deposits = DB::table('payments')
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->where('payments.status', 'approved')
            ->select(
                'payments.reviewed_at as date',
                DB::raw("'Ödeme (Giriş)' as type"),
                DB::raw("CONCAT(users.name, ' (ID: ', users.id, ') ödeme bildirimi #', payments.id) as description"),
                'payments.amount as amount' // Pozitif
            );

        // 2. Para Çıkışları (Negatif)
        $withdrawals = DB::table('withdrawal_requests')
            ->join('users', 'withdrawal_requests.user_id', '=', 'users.id')
            ->where('withdrawal_requests.status', 'approved')
            ->select(
                'withdrawal_requests.reviewed_at as date',
                DB::raw("'Çekim (Çıkış)' as type"),
                DB::raw("CONCAT(users.name, ' (ID: ', users.id, ') çekim talebi #', withdrawal_requests.id) as description"),
                DB::raw("-withdrawal_requests.amount as amount") // Negatif
            );
            
        // 3. Komisyon Giderleri (Negatif)
        $commissions = DB::table('bayi_commissions')
            ->join('users', 'bayi_commissions.bayi_id', '=', 'users.id')
            ->select(
                'bayi_commissions.created_at as date',
                DB::raw("'Komisyon (Gider)' as type"),
                DB::raw("CONCAT(users.name, ' (Bayi ID: ', users.id, ') için komisyon ödemesi (İşlem #', bayi_commissions.withdrawal_request_id, ')') as description"),
                DB::raw("-bayi_commissions.commission_amount as amount") // Negatif
            );

        // Hepsini birleştir, tarihe göre sırala ve sayfala
        $transactions = $deposits
            ->unionAll($withdrawals)
            ->unionAll($commissions)
            ->orderBy('date', 'desc')
            ->paginate(25); // Admin daha çok veri görsün

        return view('admin.reports.index', compact('stats', 'transactions'));
    }
}