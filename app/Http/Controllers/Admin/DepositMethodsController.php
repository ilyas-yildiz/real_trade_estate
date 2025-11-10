<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyBankAccount;
use App\Models\CompanyCryptoWallet;
use Illuminate\Http\Request;

class DepositMethodsController extends Controller
{
    /**
     * ADMİN: Hesapların yönetildiği ana CRUD sayfasını gösterir.
     */
    public function index()
    {
        $bankAccounts = CompanyBankAccount::all();
        $cryptoWallets = CompanyCryptoWallet::all();

        return view('admin.deposit_methods.index', compact('bankAccounts', 'cryptoWallets'));
    }

    /**
     * KULLANICI/BAYİ: Hesapların listelendiği "Nasıl Para Yollanır?" sayfasını gösterir.
     */
    public function showPage()
    {
        // Sadece 'is_active' = 1 olanları al
        $bankAccounts = CompanyBankAccount::where('is_active', 1)->get();
        $cryptoWallets = CompanyCryptoWallet::where('is_active', 1)->get();

        return view('admin.deposit_methods.show_page', compact('bankAccounts', 'cryptoWallets'));
    }

    // --- ADMİN CRUD İŞLEMLERİ ---

    public function storeBank(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active'); // Checkbox değeri
        CompanyBankAccount::create($validated);

        return back()->with('success', 'Banka hesabı başarıyla eklendi.');
    }

    public function storeCrypto(Request $request)
    {
        $validated = $request->validate([
            'wallet_type' => 'required|string|max:255',
            'network' => 'required|string|max:255',
            'wallet_address' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active'); // Checkbox değeri
        CompanyCryptoWallet::create($validated);

        return back()->with('success', 'Kripto cüzdanı başarıyla eklendi.');
    }

    public function destroyBank($id)
    {
        $account = CompanyBankAccount::findOrFail($id);
        $account->delete();
        return back()->with('success', 'Banka hesabı silindi.');
    }

    public function destroyCrypto($id)
    {
        $wallet = CompanyCryptoWallet::findOrFail($id);
        $wallet->delete();
        return back()->with('success', 'Kripto cüzdanı silindi.');
    }
}