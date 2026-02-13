<x-guest-layout>
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 px-8 py-10 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#d4a5a5] to-[#c29595]"></div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('Create Account') }}
            </h1>
            <p class="text-gray-400 text-sm mt-2 font-light">Join us for a premium experience</p>
        </div>

        <x-auth-session-status class="mb-4 text-green-600 bg-green-50 p-3 rounded-xl text-center text-sm" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-5">
            @csrf

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" class="luxury-gold-text font-serif" />
                <x-text-input
                    id="username"
                    class="block mt-1 w-full rounded-2xl border-gray-100 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-gray-700 placeholder-gray-400"
                    type="text"
                    name="username"
                    :value="old('username')"
                    placeholder="Enter username"
                    required
                    autofocus />
                <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="luxury-gold-text font-serif" />
                <x-text-input
                    id="name"
                    class="block mt-1 w-full rounded-2xl border-gray-100 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-gray-700 placeholder-gray-400"
                    type="text"
                    name="name"
                    :value="old('name')"
                    placeholder="Enter Name"
                    required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="luxury-gold-text font-serif" />
                <x-text-input
                    id="email"
                    class="block mt-1 w-full rounded-2xl border-gray-100 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-gray-700 placeholder-gray-400"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="Enter Email"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- Password -->
            <div x-data="{ show: false }" class="relative">
                <x-input-label for="password" :value="__('Password')" class="luxury-gold-text font-serif" />
                
                <div class="relative mt-1">
                    <input
                        :type="show ? 'text' : 'password'"
                        name="password"
                        id="password"
                        class="block w-full rounded-2xl border-gray-100 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-gray-700 placeholder-gray-400 pr-10"
                        placeholder="Enter password"
                        required>

                    <!-- Toggle Eye -->
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-5 w-5" :class="{'hidden': !show, 'block': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg class="h-5 w-5" :class="{'block': !show, 'hidden': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.575-3.107m7.065 7.065L2 12m17.518-2.518A10.05 10.05 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7a10.05 10.05 0 01-3.107-1.575m0 0L3 3l18 18" /></svg>
                    </button>
                </div>

                <!-- Password Rules -->
                <div id="pw-rules" class="mt-3 hidden bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <div class="flex gap-1 mb-2">
                        <div class="h-1.5 flex-1 bg-gray-200 rounded-full transition-all duration-300" id="bar-length"></div>
                        <div class="h-1.5 flex-1 bg-gray-200 rounded-full transition-all duration-300" id="bar-uppercase"></div>
                        <div class="h-1.5 flex-1 bg-gray-200 rounded-full transition-all duration-300" id="bar-lowercase"></div>
                        <div class="h-1.5 flex-1 bg-gray-200 rounded-full transition-all duration-300" id="bar-number"></div>
                        <div class="h-1.5 flex-1 bg-gray-200 rounded-full transition-all duration-300" id="bar-symbol"></div>
                    </div>

                    <ul class="text-[10px] space-y-1 text-gray-500 font-medium tracking-wide">
                        <li id="rule-length" class="flex items-center gap-1 transition-colors duration-200"><span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Minimal 8 karakter</li>
                        <li id="rule-uppercase" class="flex items-center gap-1 transition-colors duration-200"><span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Huruf besar</li>
                        <li id="rule-lowercase" class="flex items-center gap-1 transition-colors duration-200"><span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Huruf kecil</li>
                        <li id="rule-number" class="flex items-center gap-1 transition-colors duration-200"><span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Angka</li>
                        <li id="rule-symbol" class="flex items-center gap-1 transition-colors duration-200"><span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Simbol</li>
                    </ul>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- Confirm Password -->
            <div x-data="{ show: false }" class="relative">
                <x-input-label for="confirmPassword" :value="__('Confirm Password')" class="luxury-gold-text font-serif" />
                
                <div class="relative mt-1">
                    <input
                        :type="show ? 'text' : 'password'"
                        id="confirmPassword"
                        name="password_confirmation"
                        class="block w-full rounded-2xl border-gray-100 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-gray-700 placeholder-gray-400 pr-10"
                        placeholder="Confirm password"
                        oninput="validateConfirm()"
                        required>

                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-5 w-5" :class="{'hidden': !show, 'block': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg class="h-5 w-5" :class="{'block': !show, 'hidden': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.575-3.107m7.065 7.065L2 12m17.518-2.518A10.05 10.05 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7a10.05 10.05 0 01-3.107-1.575m0 0L3 3l18 18" /></svg>
                    </button>
                </div>
                 <p id="confirmMsg" class="text-xs mt-1 transition-all duration-300"></p>
            </div>

            <!-- reCAPTCHA -->
            <div id="captcha-wrapper" class="flex justify-center p-4 bg-gray-50 rounded-2xl border border-gray-100 transition">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
            </div>
            <div id="captcha-error" class="text-red-500 text-xs text-center hidden">
                Please verify that you are not a robot.
            </div>

            <div class="flex flex-col gap-4 mt-8">
                <button type="submit" class="w-full py-3.5 rounded-full text-white font-medium shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 10px 20px rgba(212, 165, 165, 0.3);">
                    {{ __('Register') }}
                </button>

                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-800 text-center block mt-2">
                    Already have an account? <span class="text-[#c29595] font-semibold">Login</span>
                </a>
                @endif

                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink-0 mx-4 text-gray-400 text-xs uppercase tracking-widest">Or Register With</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <div class="flex justify-center">
                    <a href="{{ route('social.redirect', 'google') }}" class="flex items-center justify-center w-full px-4 py-3 border border-gray-200 rounded-full shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <svg class="h-5 w-5 mr-2" aria-hidden="true" viewBox="0 0 24 24"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .533 5.333.533 12S5.867 24 12.48 24c3.44 0 6.04-1.133 8.16-3.293 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.133H12.48z" fill="#EA4335"/></svg>
                        Google
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        // Password rules
        const pw = document.getElementById('password');
        const rulesBox = document.getElementById('pw-rules');
        
        pw.addEventListener('input', () => {
            const val = pw.value;
            rulesBox.classList.toggle('hidden', val.length === 0);

            function check(cond, bar, rule) {
                const barEl = document.getElementById(bar);
                const ruleEl = document.getElementById(rule);
                const dot = ruleEl.querySelector('span'); // The dot span

                if (cond) {
                    barEl.classList.remove('bg-gray-200');
                    barEl.classList.add('bg-[#d4a5a5]'); // Rose gold
                    ruleEl.classList.remove('text-gray-500');
                    ruleEl.classList.add('text-green-600', 'font-semibold');
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-green-600');
                } else {
                    barEl.classList.add('bg-gray-200');
                    barEl.classList.remove('bg-[#d4a5a5]');
                    ruleEl.classList.add('text-gray-500');
                    ruleEl.classList.remove('text-green-600', 'font-semibold');
                    dot.classList.add('bg-gray-300');
                    dot.classList.remove('bg-green-600');
                }
            }

            check(val.length >= 8, 'bar-length', 'rule-length');
            check(/[A-Z]/.test(val), 'bar-uppercase', 'rule-uppercase');
            check(/[a-z]/.test(val), 'bar-lowercase', 'rule-lowercase');
            check(/[0-9]/.test(val), 'bar-number', 'rule-number');
            check(/[^A-Za-z0-9]/.test(val), 'bar-symbol', 'rule-symbol');
        });

        // Confirm password
        const confirm = document.getElementById('confirmPassword');
        const confirmMsg = document.getElementById('confirmMsg');
        
        function validateConfirm() {
            if(confirm.value===""){ 
                confirm.classList.remove('border-green-300', 'border-red-300', 'focus:border-green-300', 'focus:border-red-300');
                confirmMsg.innerHTML=""; 
                return;
            }
            if(confirm.value===pw.value){
                confirm.classList.remove('border-gray-100', 'border-red-300', 'focus:border-red-300');
                confirm.classList.add('border-green-300', 'focus:border-green-300');
                confirmMsg.innerHTML = '<span class="text-green-600 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Passwords match</span>';
            } else{
                confirm.classList.remove('border-gray-100', 'border-green-300', 'focus:border-green-300');
                confirm.classList.add('border-red-300', 'focus:border-red-300');
                confirmMsg.innerHTML = '<span class="text-red-500">Passwords do not match</span>';
            }
        }

        // reCAPTCHA check sebelum submit
        const form = document.getElementById('register-form');
        const captchaError = document.getElementById('captcha-error');
        const captchaWrapper = document.getElementById('captcha-wrapper');
        form.addEventListener('submit', function(e) {
            if(!grecaptcha.getResponse()){
                e.preventDefault();
                captchaError.classList.remove('hidden');
                captchaWrapper.classList.remove('border-gray-100');
                captchaWrapper.classList.add('border-red-300', 'bg-red-50');
                captchaWrapper.scrollIntoView({behavior:'smooth',block:'center'});
            }
        });
    </script>
</x-guest-layout>
