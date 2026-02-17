<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form method="POST" action="{{ route('superadmin.users.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-600 font-medium mb-2 font-serif">Full Name</label>
                            <input id="name" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. Jane Doe" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-gray-600 font-medium mb-2 font-serif">Username</label>
                                <input id="username" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                    type="text" name="username" value="{{ old('username') }}" required placeholder="e.g. janedoe" />
                                <small id="usernameError" class="text-red-500 hidden text-sm mt-1 block">
                                    Username sudah digunakan
                                </small>
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-600 font-medium mb-2 font-serif">Email Address</label>
                                <input id="email" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                    type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. jane@example.com" />
                                <small id="emailError" class="text-red-500 hidden text-sm mt-1 block">
                                    Email sudah terdaftar
                                </small>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-gray-600 font-medium mb-2 font-serif">Role</label>
                            <select id="role" name="role" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 cursor-pointer" required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1 italic">Note: Superadmin role cannot be assigned here.</p>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div class="relative">
                                <label for="password" class="block text-gray-600 font-medium mb-2 font-serif">Password</label>
                                <input id="password" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-12" 
                                    type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />

                                <button type="button"
                                        onclick="togglePassword('password', this)"
                                        class="absolute right-3 top-10 text-gray-400">
                                    👁
                                </button>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                <div class="flex gap-2 mt-3">
                                    <div class="h-3 w-1/5 bg-gray-300 rounded" id="bar-length"></div>
                                    <div class="h-3 w-1/5 bg-gray-300 rounded" id="bar-uppercase"></div>
                                    <div class="h-3 w-1/5 bg-gray-300 rounded" id="bar-lowercase"></div>
                                    <div class="h-3 w-1/5 bg-gray-300 rounded" id="bar-number"></div>
                                    <div class="h-3 w-1/5 bg-gray-300 rounded" id="bar-symbol"></div>
                                </div>

                                <ul class="mt-2 text-xs space-y-1">
                                    <li data-rule="length" class="text-red-500 hidden">• Minimal 8 karakter</li>
                                    <li data-rule="uppercase" class="text-red-500 hidden">• Huruf besar</li>
                                    <li data-rule="lowercase" class="text-red-500 hidden">• Huruf kecil</li>
                                    <li data-rule="number" class="text-red-500 hidden">• Angka</li>
                                    <li data-rule="symbol" class="text-red-500 hidden">• Simbol</li>
                                </ul>
                            </div>

                            <!-- Confirm Password -->
                            <div class="relative">
                                <label for="password_confirmation" class="block text-gray-600 font-medium mb-2 font-serif">Confirm Password</label>
                                <input id="password_confirmation" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-12" 
                                    type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

                                <button type="button"
                                        onclick="togglePassword('password_confirmation', this)"
                                        class="absolute right-3 top-10 text-gray-400">
                                    👁
                                </button>

                                <!-- Indicator -->
                                <div class="absolute right-10 top-10 text-lg hidden" id="confirmIcon"></div>

                                <small id="confirmError" class="text-red-500 hidden text-sm mt-1 block">
                                    Password tidak sama
                                </small>

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-50">
                        <a href="{{ route('superadmin.users.index') }}" class="px-6 py-3 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 font-medium transition mr-4">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" id="submitBtn" class="px-8 py-3 rounded-full text-white font-medium shadow-lg transform transition hover:-translate-y-0.5 disabled:opacity-50" 
                            style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);" disabled>
                            {{ __('Create User') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.textContent = input.type === 'password' ? '👁' : '🙈';
}

const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const confirm = document.getElementById('password_confirmation');
const submitBtn = document.getElementById('submitBtn');

const usernameError = document.getElementById('usernameError');
const emailError = document.getElementById('emailError');
const confirmError = document.getElementById('confirmError');
const confirmIcon = document.getElementById('confirmIcon');

let usernameOk = false;
let emailOk = false;

async function check(field, value, url, errorEl) {
    const res = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ [field]: value })
    });
    const data = await res.json();
    errorEl.classList.toggle('hidden', !data.exists);
    return !data.exists;
}

username.addEventListener('input', async () => {
    if (!username.value) return;
    usernameOk = await check('username', username.value, '{{ route('superadmin.check.username') }}', usernameError);
    updateSubmit();
});

email.addEventListener('input', async () => {
    if (!email.value) return;
    emailOk = await check('email', email.value, '{{ route('superadmin.check.email') }}', emailError);
    updateSubmit();
});

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

function validatePassword() {
    const v = password.value;

    if (!v) {
        Object.values(rules).forEach(r => r.classList.add('hidden'));
        Object.values(bars).forEach(b => b.style.background = '#D1D5DB');
        return false;
    }

    Object.values(rules).forEach(r => r.classList.remove('hidden'));

    function checkRule(cond, bar, rule) {
        if (cond) {
            bar.style.background = 'lightgreen';
            rule.classList.add('hidden');
        } else {
            bar.style.background = '#D1D5DB';
            rule.classList.remove('hidden');
        }
    }

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
        confirmIcon.className = 'absolute right-10 top-10 text-green-600 text-lg';
        return true;
    } else {
        confirmError.classList.remove('hidden');
        confirmIcon.textContent = '✖';
        confirmIcon.className = 'absolute right-10 top-10 text-red-600 text-lg';
        return false;
    }
}

function updateSubmit() {
    submitBtn.disabled = !(usernameOk && emailOk && validatePassword() && validateConfirm());
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
</script>
</x-app-layout>
