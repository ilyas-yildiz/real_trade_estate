<section>
    <header>
        {{-- Bootstrap başlık ve metin sınıfları eklendi --}}
        <h2 class="fs-5 fw-medium mb-1">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- E-posta doğrulama linki için ayrı form --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Ana profil güncelleme formu --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        {{-- Ad Alanı --}}
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            {{-- Hata mesajı Bootstrap stiliyle --}}
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- E-posta Alanı --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
             @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- E-posta Doğrulama Durumu --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small text-muted">
                        {{ __('Your email address is unverified.') }}
                        {{-- Doğrulama linkini tekrar gönderme butonu --}}
                        <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-underline text-muted">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    {{-- Doğrulama linki gönderildi mesajı --}}
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 small text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Kaydet Butonu ve Başarı Mesajı --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                {{-- Alpine.js yerine basit Bootstrap mesajı --}}
                <span class="text-success small">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>