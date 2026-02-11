<x-guest-layout>
    <div class="bg-[#212844] text-white rounded-lg shadow-md px-6 py-6">

        <x-auth-session-status class="mb-4 text-green-300" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}" id="register-form">
            @csrf

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" class="!text-white" />
                <x-text-input
                    id="username"
                    class="block mt-1 w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
                    type="text"
                    name="username"
                    :value="old('username')"
                    placeholder="Enter username"
                    required
                    autofocus />
                <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-300" />
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" class="!text-white" />
                <x-text-input
                    id="name"
                    class="block mt-1 w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
                    type="text"
                    name="name"
                    :value="old('name')"
                    placeholder="Enter Name"
                    required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="!text-white" />
                <x-text-input
                    id="email"
                    class="block mt-1 w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="Enter Email"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
            </div>

            <!-- Password -->
            <div class="relative mt-4">
                <label for="password" class="block font-semibold mb-1 text-white">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full px-4 py-2 rounded-lg bg-[#212844] text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 border border-white"
                    placeholder="Enter password"
                    required>

                <!-- Toggle Eye -->
                <button type="button" id="toggle-password" class="absolute right-3 top-9 text-gray-400 hover:text-gray-200">
                    <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-5-10-5s1.5-2.5 5-4.5m0 0a3 3 0 114 4M3 3l18 18" />
                    </svg>
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>

                <!-- Password Rules -->
                <div id="pw-rules" class="mt-3 hidden">
                    <div class="flex gap-2">
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-length"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-uppercase"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-lowercase"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-number"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-symbol"></div>
                    </div>

                    <ul class="mt-2 text-xs space-y-1">
                        <li id="rule-length" class="text-red-400">• Minimal 8 karakter</li>
                        <li id="rule-uppercase" class="text-red-400">• Huruf besar</li>
                        <li id="rule-lowercase" class="text-red-400">• Huruf kecil</li>
                        <li id="rule-number" class="text-red-400">• Angka</li>
                        <li id="rule-symbol" class="text-red-400">• Simbol</li>
                    </ul>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="relative mt-4">
                <label for="confirmPassword" class="block font-semibold mb-1 text-white">Confirm Password</label>
                <input
                    type="password"
                    id="confirmPassword"
                    name="password_confirmation"
                    class="w-full px-4 py-2 rounded-lg bg-[#212844] text-white placeholder-gray-300 border border-white focus:outline-none"
                    placeholder="Confirm password"
                    oninput="validateConfirm()"
                    required>

                <span id="confirmIcon" class="absolute right-3 top-9 opacity-0 transition-all duration-200"></span>

                <button type="button" id="toggle-confirm" class="absolute right-9 top-9 text-gray-400 hover:text-gray-200">
                    <svg id="eye-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <!-- reCAPTCHA -->
            <div class="mt-4 p-3 rounded border border-gray-500 flex flex-col items-center" id="captcha-wrapper">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                <span id="captcha-error" class="text-red-400 text-sm mt-2 hidden text-center">
                    ⚠️ Harap verifikasi bahwa Anda bukan robot.
                </span>
            </div>

            <div class="flex flex-col gap-4 mt-6">
                <x-primary-button class="w-full justify-center bg-gray text-[#212844] hover:bg-white-200">
                    {{ __('Register') }}
                </x-primary-button>

                @if (Route::has('login'))
                <a href="{{ route('login') }}"
                    class="text-sm text-gray-300 hover:text-white underline text-center block mt-2">
                    Already have an account? Login
                </a>
                @endif

                <div class="relative flex py-5 items-center">
                    <div class="flex-grow border-t border-gray-500"></div>
                    <span class="flex-shrink-0 mx-4 text-gray-300">Or Register With</span>
                    <div class="flex-grow border-t border-gray-500"></div>
                </div>

                <div class="flex justify-center">
                    <a href="{{ route('social.redirect', 'google') }}"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
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
                barEl.classList.toggle('bg-green-500', cond);
                barEl.classList.toggle('bg-gray-600', !cond);
                ruleEl.classList.toggle('text-green-400', cond);
                ruleEl.classList.toggle('text-red-400', !cond);
            }

            check(val.length >= 8, 'bar-length', 'rule-length');
            check(/[A-Z]/.test(val), 'bar-uppercase', 'rule-uppercase');
            check(/[a-z]/.test(val), 'bar-lowercase', 'rule-lowercase');
            check(/[0-9]/.test(val), 'bar-number', 'rule-number');
            check(/[^A-Za-z0-9]/.test(val), 'bar-symbol', 'rule-symbol');
        });

        // Toggle password
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');
        document.getElementById('toggle-password').onclick = () => {
            if (pw.type === "password") {
                pw.type = "text"; eyeOpen.classList.remove("hidden"); eyeClosed.classList.add("hidden");
            } else {
                pw.type = "password"; eyeOpen.classList.add("hidden"); eyeClosed.classList.remove("hidden");
            }
        }

        // Confirm password
        const confirm = document.getElementById('confirmPassword');
        const icon = document.getElementById('confirmIcon');
        document.getElementById('toggle-confirm').onclick = () => {
            confirm.type = confirm.type === "password" ? "text" : "password";
        }
        function validateConfirm() {
            if(confirm.value===""){ confirm.style.borderColor="white"; icon.style.opacity="0"; icon.innerHTML=""; return;}
            if(confirm.value===pw.value){
                confirm.style.borderColor="#22c55e";
                icon.innerHTML=`<svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>`;
            } else{
                confirm.style.borderColor="#ef4444";
                icon.innerHTML=`<svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`;
            }
            icon.style.opacity="1";
        }

        // reCAPTCHA check sebelum submit (sama kayak login)
        const form = document.getElementById('register-form');
        const captchaError = document.getElementById('captcha-error');
        const captchaWrapper = document.getElementById('captcha-wrapper');
        form.addEventListener('submit', function(e) {
            if(!grecaptcha.getResponse()){
                e.preventDefault();
                captchaError.classList.remove('hidden');
                captchaWrapper.classList.add('border-red-500');
                captchaWrapper.classList.remove('border-gray-500');
                captchaWrapper.scrollIntoView({behavior:'smooth',block:'center'});
            }
        });
    </script>
</x-guest-layout>
