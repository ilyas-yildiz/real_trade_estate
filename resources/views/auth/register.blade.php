<x-guest-layout>
<form method="POST" action="{{ route('register') }}" id="registerForm" enctype="multipart/form-data">
@csrf
@if(isset($bayi_id))
        <input type="hidden" name="bayi_id" value="{{ $bayi_id }}">
        
        <div class="alert alert-info" role="alert">
            Bir bayi referansıyla kaydoluyorsunuz.
        </div>
    @endif
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
        <x-input-label for="phone" :value="__('Telefon Numarası')" />
        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="id_card" :value="__('Kimlik Ön Yüzü (Fotoğraf)')" />
        <input id="id_card" class="block mt-1 w-full border rounded p-2" type="file" name="id_card" accept="image/*" required />
        <x-input-error :messages="$errors->get('id_card')" class="mt-2" />
        <p class="text-sm text-gray-500 mt-1">Lütfen kimliğinizin okunabilir bir fotoğrafını yükleyin.</p>
    </div>

       <div class="alert alert-info text-sm">
        Güvenliğiniz için şifreniz ve Giriş ID'niz sistem tarafından otomatik oluşturulacaktır. Kayıt olduktan sonra panelinizde görebilirsiniz.
    </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4" id="btn-register">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        // Butonu bul
        const btn = document.getElementById('btn-register');
        
        // Eğer buton zaten kilitliyse (yani ikinci kez basıldıysa), formu gönderme!
        if (btn.disabled) {
            e.preventDefault();
            return false;
        }

        // İlk basışta butonu kilitle ve yazısını değiştir
        btn.disabled = true;
        btn.innerText = 'İşleniyor... Lütfen Bekleyin';
        
        // Formun gönderilmesine izin ver
        return true;
    });
</script>
</x-guest-layout>
