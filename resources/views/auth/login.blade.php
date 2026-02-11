<x-guest-layout>
    <!-- Card -->
    <div class="bg-[#212844] text-white rounded-lg shadow-md px-6 py-6">
        <h1 class="text-xl font-semibold text-center">
                       
        Login
                    </h1>

        <!-- Status Sesi -->
        <x-auth-session-status class="mb-4 text-green-300" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Login -->
            <div>
                <x-input-label for="login" value="Email / Usarename" class="!text-white" />

                <x-text-input
                    id="login"
                    class="block mt-1 w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
                    type="text"
                    name="login"
                    :value="old('login')"
                    placeholder="Masukkan Email / Usarename"
                    required
                    autofocus
                    autocomplete="username" />

                <x-input-error :messages="$errors->get('login')" class="mt-2 text-red-300" />
            </div>

            <!-- Kata Sandi -->
            <div class="relative mt-4">
                <label for="password" class="block font-semibold mb-1 text-white">Kata Sandi</label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full px-4 py-2 rounded-lg bg-[#212844] text-white border border-gray-500 focus:outline-none"
                    placeholder="Masukkan kata sandi"
                    required>

                <!-- Toggle Eye -->
                <button type="button" id="toggle-password"
                    class="absolute right-3 top-9 text-gray-400 hover:text-gray-200">
                    <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-5-10-5s1.5-2.5 5-4.5m0 0a3 3 0 114 4M3 3l18 18" />
                    </svg>
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>

                @error('password')
                <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Aksi -->
            <div class="flex flex-col gap-4 mt-6">

                <!-- Lupa Kata Sandi -->
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm text-gray-300 hover:text-white underline">
                    Lupa kata sandi?
                </a>
                @endif

                <!-- CAPTCHA -->
                <div id="captcha-wrapper" class="p-3 rounded border border-gray-500 transition flex flex-col items-center">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>

                    <span id="captcha-error"
                        class="text-red-400 text-sm mt-2 hidden text-center">
                        ⚠️ Harap verifikasi bahwa Anda bukan robot.
                    </span>
                </div>

                <!-- Tombol Masuk -->
                <x-primary-button class="w-full justify-center bg-gray text-[#212844]">
                    Masuk
                </x-primary-button>

               

               


            </div>
        </form>
    </div>

    <!-- reCAPTCHA BAHASA INDONESIA -->
    <script src="https://www.google.com/recaptcha/api.js?hl=id" async defer></script>

    <script>
        const form = document.getElementById('login-form');
        const password = document.getElementById('password');
        const captchaError = document.getElementById('captcha-error');
        const captchaWrapper = document.getElementById('captcha-wrapper');

        // toggle eye
        document.getElementById('toggle-password').addEventListener('click', () => {
            const open = document.getElementById('eye-open');
            const closed = document.getElementById('eye-closed');

            if (password.type === 'password') {
                password.type = 'text';
                open.classList.remove('hidden');
                closed.classList.add('hidden');
            } else {
                password.type = 'password';
                open.classList.add('hidden');
                closed.classList.remove('hidden');
            }
        });

        // CEGAH SUBMIT KALAU CAPTCHA BELUM DICENTANG
        form.addEventListener('submit', function(e) {
            const captchaResponse = grecaptcha.getResponse();

            if (!captchaResponse) {
                e.preventDefault(); // ⛔ STOP SUBMIT
                captchaError.classList.remove('hidden');
                captchaWrapper.classList.remove('border-gray-500');
                captchaWrapper.classList.add('border-red-500');

                captchaWrapper.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>
</x-guest-layout>
