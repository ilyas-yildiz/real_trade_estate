<x-guest-layout>
    {{-- Form --}}
    <form method="POST" action="{{ route('register') }}" id="registerForm" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Ad Soyad')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                          :value="old('name')" required autofocus autocomplete="name" 
                          minlength="3" 
                          title="Lütfen geçerli bir isim giriniz (en az 3 karakter)" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            {{-- GÜNCELLEME: type="email" kalsa da, pattern ile .com gibi nokta zorunluluğu getirdik --}}
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                          :value="old('email')" required autocomplete="username" 
                          placeholder="ornek@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            {{-- Hata mesajı için gizli alan --}}
            <p id="emailError" class="text-sm text-red-600 mt-1" style="display:none;">Lütfen geçerli bir e-posta adresi giriniz (örn: isim@site.com).</p>
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="__('Telefon Numarası')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" 
                          :value="old('phone')" required 
                          minlength="10" 
                          maxlength="15"
                          placeholder="0532xxxxxxx"
                          oninput="this.value = this.value.replace(/[^0-9+]/g, '').slice(0, 15);"
                          title="Lütfen sadece rakam giriniz (Min 10 karakter)" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="id_card" :value="__('Kimlik Ön Yüzü (Fotoğraf)')" />
            <input id="id_card" class="block mt-1 w-full border rounded p-2" type="file" name="id_card" 
                   accept="image/png, image/jpeg, image/jpg" required />
            <x-input-error :messages="$errors->get('id_card')" class="mt-2" />
            <p class="text-sm text-gray-500 mt-1">Lütfen kimliğinizin okunabilir bir fotoğrafını yükleyin (JPG, PNG).</p>
        </div>

        <div class="mt-4">
            <div class="alert alert-info text-sm text-blue-600 bg-blue-50 p-3 rounded">
                Güvenliğiniz için şifreniz ve Giriş ID'niz sistem tarafından otomatik oluşturulacaktır. Kayıt olduktan sonra onay süreci başlayacaktır.
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Zaten üye misiniz?') }}
            </a>

            <x-primary-button class="ms-4" id="btn-register">
                {{ __('Kayıt Ol') }}
            </x-primary-button>
        </div>
    </form>

    {{-- VALIDATION & SUBMIT SCRIPT --}}
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const form = this;
            const btn = document.getElementById('btn-register');
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            
            // 1. ÖZEL EMAIL KONTROLÜ (REGEX)
            // Mantık: @ olacak, @'den sonra en az bir karakter olacak, sonra nokta olacak, sonra en az 2 harf olacak.
            // aaaa@gmail -> GEÇERSİZ
            // aaaa@gmail.c -> GEÇERSİZ
            // aaaa@gmail.com -> GEÇERLİ
            const emailRegex = /^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/;

            if (!emailRegex.test(emailInput.value)) {
                e.preventDefault(); // Göndermeyi durdur
                emailError.style.display = 'block'; // Hata mesajını göster
                emailInput.focus(); // İmleci oraya taşı
                // Tarayıcının kendi baloncuk uyarısını da tetikle
                emailInput.setCustomValidity("Lütfen tam bir e-posta adresi girin (örn: .com ile biten)");
                emailInput.reportValidity();
                return false;
            } else {
                emailError.style.display = 'none';
                emailInput.setCustomValidity(""); // Hatayı temizle
            }

            // 2. Diğer HTML5 Validasyonları
            if (!form.checkValidity()) {
                e.preventDefault();
                form.reportValidity();
                return false;
            }

            // 3. Çift Tıklama Koruması
            if (btn.disabled) {
                e.preventDefault();
                return false;
            }

            // 4. Her şey yolundaysa kilitle ve gönder
            btn.disabled = true;
            btn.innerText = 'İşleniyor...';
            return true;
        });

        // Email alanına yazarken hataları temizle
        document.getElementById('email').addEventListener('input', function() {
            this.setCustomValidity("");
            document.getElementById('emailError').style.display = 'none';
            this.value = this.value.toLowerCase(); // Küçük harfe zorla
        });
    </script>
</x-guest-layout>