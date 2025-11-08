@extends('admin.layouts.app')

@section('title', 'Yeni Çekim Talebi')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Yeni Çekim Talebi Oluştur</h4>
            </div>
            <div class="card-body">
                
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-3">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="text-muted mb-3">Lütfen çekmek istediğiniz tutarı ve paranın gönderileceği hesabı seçin. Minimum çekim tutarı 10.00'dır.</p>

                <form action="{{ route('admin.withdrawals.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Çekim Tutarı (USD, EUR, vb.) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="amount" name="amount" 
                               placeholder="100.00" value="{{ old('amount') }}" required step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Ödeme Yöntemi <span class="text-danger">*</span></label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">Lütfen bir hesap seçin...</option>
                            
                            {{-- Banka Hesapları --}}
                            @if($bankAccounts->isNotEmpty())
                                <optgroup label="Banka Hesaplarım (IBAN)">
                                    @foreach ($bankAccounts as $account)
                                        {{-- Değer: 'bank-ID' formatında --}}
                                        <option value="bank-{{ $account->id }}" {{ old('payment_method') == 'bank-'.$account->id ? 'selected' : '' }}>
                                            {{ $account->bank_name }} - {{ $account->iban }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif

                            {{-- Kripto Cüzdanları --}}
                            @if($cryptoWallets->isNotEmpty())
                                <optgroup label="Kripto Cüzdanlarım">
                                    @foreach ($cryptoWallets as $wallet)
                                        {{-- Değer: 'crypto-ID' formatında --}}
                                        <option value="crypto-{{ $wallet->id }}" {{ old('payment_method') == 'crypto-'.$wallet->id ? 'selected' : '' }}>
                                            {{ $wallet->network }} - {{ $wallet->wallet_address }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif

                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100">Çekim Talebini Gönder</button>
                    </div>
                    <div class="mt-2 text-center">
                        <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-link btn-sm">İptal et ve geri dön</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection