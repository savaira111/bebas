<x-guest-layout>
    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 px-8 py-10 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#d4a5a5] to-[#c29595]"></div>
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('Welcome Back') }}
            </h1>
            <p class="text-gray-400 text-sm mt-2 font-light">Please sign in to your account</p>
        </div>

        <!-- Status Sesi -->
        <x-auth-session-status class="mb-4 text-green-600 bg-green-50 p-3 rounded-xl text-center text-sm" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" id="login-form" class="space-y-6">
            @csrf

            <!-- Login -->
            <div>
                <x-input-label for="login" value="Email / Username" class="luxury-gold-text font-serif" />

                <x-text-input
                    id="login"
                    class="block mt-2 w-full rounded-2xl border-gray-100 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-gray-700 placeholder-gray-400"
                    type="text"
                    name="login"
                    :value="old('login')"
                    placeholder="Enter your email or username"
                    required
                    autofocus
                    autocomplete="username" />

                <x-input-error :messages="$errors->get('login')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- Kata Sandi -->
            <div x-data="{ show: false }" class="relative">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block font-medium text-sm luxury-gold-text font-serif">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-gray-400 hover:text-[#d4a5a5] transition">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <div class="relative">
                    <input
                        :type="show ? 'text' : 'password'"
                        name="password"
                        id="password"
                        class="block w-full rounded-2xl border-gray-100 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-gray-700 placeholder-gray-400 pr-10"
                        placeholder="Enter your password"
                        required>

                    <!-- Toggle Eye -->
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-5 w-5" :class="{'hidden': !show, 'block': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg class="h-5 w-5" :class="{'block': !show, 'hidden': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.575-3.107m7.065 7.065L2 12m17.518-2.518A10.05 10.05 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7a10.05 10.05 0 01-3.107-1.575m0 0L3 3l18 18" /></svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- CAPTCHA -->
            <div id="captcha-wrapper" class="flex justify-center p-4 bg-gray-50 rounded-2xl border border-gray-100 transition">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
            </div>
            <div id="captcha-error" class="text-red-500 text-xs text-center hidden">
                Please verify that you are not a robot.
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" class="w-full py-3.5 rounded-full text-white font-medium shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 10px 20px rgba(212, 165, 165, 0.3);">
                {{ __('Sign In') }}
            </button>
            
            <div class="text-center mt-6">
                 <p class="text-sm text-gray-500">Don't have an account? <a href="{{ route('register') }}" class="text-[#c29595] hover:text-[#a87d7d] font-medium transition">Register here</a></p>
            </div>
        </form>
    </div>

    <!-- reCAPTCHA BAHASA INDONESIA -->
    <script src="https://www.google.com/recaptcha/api.js?hl=id" async defer></script>

    <script>
        const form = document.getElementById('login-form');
        const captchaError = document.getElementById('captcha-error');
        const captchaWrapper = document.getElementById('captcha-wrapper');

        // CEGAH SUBMIT KALAU CAPTCHA BELUM DICENTANG
        form.addEventListener('submit', function(e) {
            const captchaResponse = grecaptcha.getResponse();

            if (!captchaResponse) {
                e.preventDefault(); // ⛔ STOP SUBMIT
                captchaError.classList.remove('hidden');
                captchaWrapper.classList.remove('border-gray-100');
                captchaWrapper.classList.add('border-red-300', 'bg-red-50');

                captchaWrapper.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>
</x-guest-layout>
