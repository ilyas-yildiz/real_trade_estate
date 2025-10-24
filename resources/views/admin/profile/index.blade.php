@extends('admin.layouts.app')

@section('title', 'Profilim ve Ayarlar')

@push('izitoastcss')
    {{-- iziToast CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-xxl-12">
             {{-- DÜZELTME: mt-n5 sınıfı kaldırıldı --}}
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        {{-- Sekme 1: Kişisel Bilgiler --}}
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetailsTab" role="tab">
                                <i class="fas fa-home"></i> Kişisel Bilgiler
                            </a>
                        </li>
                        {{-- Sekme 2: Banka Hesapları --}}
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#bankAccountsTab" role="tab">
                                <i class="ri-bank-line"></i> Banka Hesapları
                            </a>
                        </li>
                        {{-- Sekme 3: Kripto Cüzdanları --}}
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#cryptoWalletsTab" role="tab">
                                <i class="ri-bit-coin-line"></i> Kripto Cüzdanları
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">

                    {{-- Başarı ve Hata Mesajları Alanı --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                     @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Hata!</strong> Lütfen formdaki eksik veya hatalı bilgileri kontrol edin.
                             <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Sekme İçerikleri --}}
                    <div class="tab-content">
                        {{-- ================= TAB 1: Kişisel Bilgiler ================= --}}
                        <div class="tab-pane active" id="personalDetailsTab" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                     <div class="card shadow-sm mb-4">
                                         <div class="card-header">
                                             <h5 class="mb-0">Profil Bilgilerini Güncelle</h5>
                                         </div>
                                         <div class="card-body">
                                            @include('profile.partials.update-profile-information-form')
                                         </div>
                                     </div>
                                </div>
                                <div class="col-lg-6">
                                     <div class="card shadow-sm mb-4">
                                         <div class="card-header">
                                              <h5 class="mb-0">Şifre Değiştir</h5>
                                         </div>
                                         <div class="card-body">
                                             @include('profile.partials.update-password-form')
                                         </div>
                                     </div>
                                     {{-- Hesap Silme Bölümü (İsteğe bağlı) --}}
                                     {{--
                                     <div class="card shadow-sm mb-4">
                                         <div class="card-header bg-danger text-white"><h5 class="mb-0 text-white">Hesabı Sil</h5></div>
                                         <div class="card-body">@include('profile.partials.delete-user-form')</div>
                                     </div>
                                     --}}
                                </div>
                            </div>
                        </div>
                        {{-- ================= END TAB 1 ================= --}}

                        {{-- ================= TAB 2: Banka Hesapları ================= --}}
                        <div class="tab-pane" id="bankAccountsTab" role="tabpanel">
                             <div class="row">
                                 <div class="col-lg-5">
                                      <div class="card shadow-sm mb-4">
                                          <div class="card-header"><h5 class="mb-0">Yeni Banka Hesabı Ekle</h5></div>
                                          <div class="card-body">
                                              <form action="{{ route('admin.profile.storeBankAccount') }}" method="POST">
                                                  @csrf
                                                  <div class="mb-3">
                                                      <label for="bank_name" class="form-label">Banka Adı <span class="text-danger">*</span></label>
                                                      <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required>
                                                      @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="account_holder_name" class="form-label">Hesap Sahibi Adı <span class="text-danger">*</span></label>
                                                      <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name') }}" required>
                                                      @error('account_holder_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="iban" class="form-label">IBAN <span class="text-danger">*</span></label>
                                                      <input type="text" class="form-control @error('iban') is-invalid @enderror" id="iban" name="iban" value="{{ old('iban') }}" required>
                                                      @error('iban') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="branch_name" class="form-label">Şube Adı (Opsiyonel)</label>
                                                      <input type="text" class="form-control @error('branch_name') is-invalid @enderror" id="branch_name" name="branch_name" value="{{ old('branch_name') }}">
                                                      @error('branch_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="account_number" class="form-label">Hesap Numarası (Opsiyonel)</label>
                                                      <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number') }}">
                                                      @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="text-end">
                                                      <button type="submit" class="btn btn-primary">Hesabı Kaydet</button>
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                 </div>
                                 <div class="col-lg-7">
                                      <div class="card shadow-sm mb-4">
                                          <div class="card-header"><h5 class="mb-0">Mevcut Banka Hesaplarım</h5></div>
                                          <div class="card-body">
                                               <div class="table-responsive">
                                                  <table class="table table-striped table-hover align-middle mb-0">
                                                      <thead>
                                                          <tr>
                                                              <th scope="col">Banka Adı</th>
                                                              <th scope="col">Hesap Sahibi</th>
                                                              <th scope="col">IBAN</th>
                                                              <th scope="col">İşlemler</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          @forelse ($bankAccounts as $bankAccount)
                                                              <tr>
                                                                  <td>{{ $bankAccount->bank_name }}</td>
                                                                  <td>{{ $bankAccount->account_holder_name }}</td>
                                                                  <td>{{ $bankAccount->iban }}</td>
                                                                  <td>
                                                                      <form action="{{ route('admin.profile.destroyBankAccount', $bankAccount->id) }}" method="POST" onsubmit="return confirm('Bu banka hesabını silmek istediğinizden emin misiniz?');">
                                                                          @csrf @method('DELETE')
                                                                          <button type="submit" class="btn btn-sm btn-danger shadow-none">Sil</button>
                                                                      </form>
                                                                  </td>
                                                              </tr>
                                                          @empty
                                                              <tr><td colspan="4" class="text-center text-muted">Henüz banka hesabı eklenmemiş.</td></tr>
                                                          @endforelse
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                 </div>
                             </div>
                        </div>
                        {{-- ================= END TAB 2 ================= --}}

                        {{-- ================= TAB 3: Kripto Cüzdanları ================= --}}
                        <div class="tab-pane" id="cryptoWalletsTab" role="tabpanel">
                             <div class="row">
                                 <div class="col-lg-5">
                                      <div class="card shadow-sm mb-4">
                                          <div class="card-header"><h5 class="mb-0">Yeni Kripto Cüzdanı Ekle</h5></div>
                                          <div class="card-body">
                                              <form action="{{ route('admin.profile.storeCryptoWallet') }}" method="POST">
                                                  @csrf
                                                  <div class="mb-3">
                                                      <label for="wallet_type" class="form-label">Cüzdan Tipi <span class="text-danger">*</span></label>
                                                      <input type="text" class="form-control @error('wallet_type') is-invalid @enderror" id="wallet_type" name="wallet_type" placeholder="Örn: USDT, Bitcoin, Ethereum" value="{{ old('wallet_type') }}" required>
                                                      @error('wallet_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="network" class="form-label">Ağ (Opsiyonel)</label>
                                                      <input type="text" class="form-control @error('network') is-invalid @enderror" id="network" name="network" placeholder="Örn: TRC-20, ERC-20, BEP-20" value="{{ old('network') }}">
                                                      @error('network') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="wallet_address" class="form-label">Cüzdan Adresi <span class="text-danger">*</span></label>
                                                      <textarea class="form-control @error('wallet_address') is-invalid @enderror" id="wallet_address" name="wallet_address" rows="3" required>{{ old('wallet_address') }}</textarea>
                                                      @error('wallet_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                  </div>
                                                  <div class="text-end">
                                                      <button type="submit" class="btn btn-primary">Cüzdanı Kaydet</button>
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                 </div>
                                 <div class="col-lg-7">
                                     <div class="card shadow-sm mb-4">
                                          <div class="card-header"><h5 class="mb-0">Mevcut Kripto Cüzdanlarım</h5></div>
                                          <div class="card-body">
                                               <div class="table-responsive">
                                                  <table class="table table-striped table-hover align-middle mb-0">
                                                      <thead>
                                                          <tr>
                                                              <th scope="col">Tip</th>
                                                              <th scope="col">Ağ</th>
                                                              <th scope="col">Adres</th>
                                                              <th scope="col">İşlemler</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          @forelse ($cryptoWallets as $cryptoWallet)
                                                              <tr>
                                                                  <td>{{ $cryptoWallet->wallet_type }}</td>
                                                                  <td>{{ $cryptoWallet->network ?? '-' }}</td>
                                                                  <td style="word-break: break-all;">{{ $cryptoWallet->wallet_address }}</td>
                                                                  <td>
                                                                       <form action="{{ route('admin.profile.destroyCryptoWallet', $cryptoWallet->id) }}" method="POST" onsubmit="return confirm('Bu kripto cüzdanını silmek istediğinizden emin misiniz?');">
                                                                          @csrf @method('DELETE')
                                                                          <button type="submit" class="btn btn-sm btn-danger shadow-none">Sil</button>
                                                                      </form>
                                                                  </td>
                                                              </tr>
                                                          @empty
                                                              <tr><td colspan="4" class="text-center text-muted">Henüz kripto cüzdanı eklenmemiş.</td></tr>
                                                          @endforelse
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                 </div>
                             </div>
                        </div>
                        {{-- ================= END TAB 3 ================= --}}
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection

@push('scripts')
    {{-- iziToast JS --}}
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    {{-- Başarı/Hata mesajları için scriptler --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                iziToast.success({ title: 'Başarılı!', message: '{{ session('success') }}', position: 'topRight' });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                iziToast.error({ title: 'Hata!', message: '{{ session('error') }}', position: 'topRight' });
            });
        </script>
    @endif
@endpush