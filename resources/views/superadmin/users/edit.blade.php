<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form method="POST" action="{{ route('superadmin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-600 font-medium mb-2 font-serif">Full Name</label>
                            <input id="name" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-gray-600 font-medium mb-2 font-serif">Username</label>
                                <input id="username" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                    type="text" name="username" value="{{ old('username', $user->username) }}" required />
                                <small id="usernameError" class="text-red-500 hidden text-sm mt-1 block">
                                    Username sudah digunakan
                                </small>
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-600 font-medium mb-2 font-serif">Email Address</label>
                                <input id="email" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                    type="email" name="email" value="{{ old('email', $user->email) }}" required />
                                <small id="emailError" class="text-red-500 hidden text-sm mt-1 block">
                                    Email sudah terdaftar
                                </small>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-gray-600 font-medium mb-2 font-serif">Role</label>
                            <select id="role" name="role" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 cursor-pointer">
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1 italic">Note: Superadmin role cannot be assigned here.</p>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Password (Optional) -->
                        <div class="bg-yellow-50/50 border border-yellow-100 rounded-xl p-4 mb-2 flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-yellow-700">Leave the password fields blank if you do not want to change the password.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div class="relative">
                                <label for="password" class="block text-gray-600 font-medium mb-2 font-serif">New Password</label>
                                <input id="password" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-12" 
                                    type="password" name="password" autocomplete="new-password" placeholder="••••••••" />

                                <button type="button"
                                        onclick="togglePassword('password', this)"
                                        class="absolute right-3 top-10 text-gray-400">
                                    👁
                                </button>

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

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="relative">
                                <label for="password_confirmation" class="block text-gray-600 font-medium mb-2 font-serif">Confirm New Password</label>
                                <input id="password_confirmation" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-12" 
                                    type="password" name="password_confirmation" autocomplete="new-password" placeholder="••••••••" />

                                <button type="button"
                                        onclick="togglePassword('password_confirmation', this)"
                                        class="absolute right-3 top-10 text-gray-400">
                                    👁
                                </button>

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
                            style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                            {{ __('Update User') }}
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

const password = document.getElementById('password');
const confirm = document.getElementById('password_confirmation');
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

function validatePassword() {
    const v = password.value;

    if (!v) {
        Object.values(rules).forEach(r => r.classList.add('hidden'));
        Object.values(bars).forEach(b => b.style.background = '#D1D5DB');
        return true;
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
    if (!password.value && !confirm.value) {
        confirmError.classList.add('hidden');
        confirmIcon.classList.add('hidden');
        return true;
    }

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

password.addEventListener('input', () => {
    validatePassword();
    validateConfirm();
});

confirm.addEventListener('input', () => {
    validateConfirm();
});
</script>
</x-app-layout>
