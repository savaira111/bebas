<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 font-serif">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <div class="relative">
                <x-text-input id="current_password" name="current_password" type="password"
                    class="mt-1 block w-full pr-12"
                    autocomplete="current-password" />
                <button type="button"
                        onclick="togglePassword('current_password', this)"
                        class="absolute right-3 top-3 text-gray-400">
                    👁
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <div class="relative">
                <x-text-input id="password" name="password" type="password"
                    class="mt-1 block w-full pr-12"
                    autocomplete="new-password" />
                <button type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute right-3 top-3 text-gray-400">
                    👁
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

            <!-- Strength Bars -->
            <div class="flex gap-2 mt-3">
                <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-length"></div>
                <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-uppercase"></div>
                <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-lowercase"></div>
                <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-number"></div>
                <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-symbol"></div>
            </div>

            <!-- Rules -->
            <ul class="mt-2 text-xs space-y-1">
                <li data-rule="length" class="text-red-500 hidden">• Minimal 8 karakter</li>
                <li data-rule="uppercase" class="text-red-500 hidden">• Huruf besar</li>
                <li data-rule="lowercase" class="text-red-500 hidden">• Huruf kecil</li>
                <li data-rule="number" class="text-red-500 hidden">• Angka</li>
                <li data-rule="symbol" class="text-red-500 hidden">• Simbol</li>
            </ul>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full pr-12"
                    autocomplete="new-password" />
                <button type="button"
                        onclick="togglePassword('password_confirmation', this)"
                        class="absolute right-3 top-3 text-gray-400">
                    👁
                </button>

                <div class="absolute right-10 top-3 text-lg hidden" id="confirmIcon"></div>
            </div>

            <small id="confirmError" class="text-red-500 hidden text-sm mt-1 block">
                Password tidak sama
            </small>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button id="submitBtn" disabled>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.textContent = input.type === 'password' ? '👁' : '🙈';
}

document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    const confirmError = document.getElementById('confirmError');
    const confirmIcon = document.getElementById('confirmIcon');

    const bars = {
        length: document.getElementById('bar-length'),
        uppercase: document.getElementById('bar-uppercase'),
        lowercase: document.getElementById('bar-lowercase'),
        number: document.getElementById('bar-number'),
        symbol: document.getElementById('bar-symbol'),
    };

    const rules = {
        length: document.querySelector('[data-rule="length"]'),
        uppercase: document.querySelector('[data-rule="uppercase"]'),
        lowercase: document.querySelector('[data-rule="lowercase"]'),
        number: document.querySelector('[data-rule="number"]'),
        symbol: document.querySelector('[data-rule="symbol"]'),
    };

    function checkRule(cond, bar, rule) {
        if (cond) {
            bar.style.background = 'lightgreen';
            rule.classList.add('hidden');
        } else {
            bar.style.background = '#D1D5DB';
            rule.classList.remove('hidden');
        }
    }

    function validatePassword() {
        const v = password.value;

        if (!v) {
            Object.values(bars).forEach(b => b.style.background = '#D1D5DB');
            Object.values(rules).forEach(r => r.classList.add('hidden'));
            return false;
        }

        Object.values(rules).forEach(r => r.classList.remove('hidden'));

        checkRule(v.length >= 8, bars.length, rules.length);
        checkRule(/[A-Z]/.test(v), bars.uppercase, rules.uppercase);
        checkRule(/[a-z]/.test(v), bars.lowercase, rules.lowercase);
        checkRule(/[0-9]/.test(v), bars.number, rules.number);
        checkRule(/[^A-Za-z0-9]/.test(v), bars.symbol, rules.symbol);

        return Object.values(bars).every(b => b.style.background === 'lightgreen');
    }

    function validateConfirm() {
        if (!confirm.value) {
            confirmError.classList.add('hidden');
            confirmIcon.classList.add('hidden');
            return false;
        }

        confirmIcon.classList.remove('hidden');

        if (confirm.value === password.value) {
            confirmError.classList.add('hidden');
            confirmIcon.textContent = '✔';
            confirmIcon.className = 'absolute right-10 top-3 text-green-600 text-lg';
            return true;
        } else {
            confirmError.classList.remove('hidden');
            confirmIcon.textContent = '✖';
            confirmIcon.className = 'absolute right-10 top-3 text-red-600 text-lg';
            return false;
        }
    }

    function updateSubmit() {
        submitBtn.disabled = !(validatePassword() && validateConfirm());
    }

    password.addEventListener('input', () => {
        validatePassword();
        validateConfirm();
        updateSubmit();
    });

    confirm.addEventListener('input', () => {
        validateConfirm();
        updateSubmit();
    });

});
</script>
