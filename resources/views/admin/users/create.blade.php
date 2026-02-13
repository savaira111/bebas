<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   required placeholder="e.g. Jane Doe">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   required placeholder="e.g. jane@example.com">
                            <small id="emailError" class="text-red-500 text-xs hidden">Email sudah terdaftar</small>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div class="relative">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password"
                                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 pr-12"
                                       required>
                                <button type="button"
                                        onclick="togglePassword('password', this)"
                                        class="absolute right-3 top-9 text-gray-500">
                                    👁
                                </button>

                                <div class="flex gap-2 mt-3">
                                    <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-length"></div>
                                    <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-uppercase"></div>
                                    <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-lowercase"></div>
                                    <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-number"></div>
                                    <div class="h-2 w-1/5 bg-gray-300 rounded" id="bar-symbol"></div>
                                </div>

                                <ul class="mt-2 text-xs space-y-1">
                                    <li data-rule="length" class="text-red-500 hidden">• Minimal 8 karakter</li>
                                    <li data-rule="uppercase" class="text-red-500 hidden">• Huruf besar</li>
                                    <li data-rule="lowercase" class="text-red-500 hidden">• Huruf kecil</li>
                                    <li data-rule="number" class="text-red-500 hidden">• Angka</li>
                                    <li data-rule="symbol" class="text-red-500 hidden">• Simbol</li>
                                </ul>

                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="relative">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 pr-12"
                                       required>
                                <button type="button"
                                        onclick="togglePassword('password_confirmation', this)"
                                        class="absolute right-3 top-9 text-gray-500">
                                    👁
                                </button>
                                <small id="confirmError" class="text-red-500 text-xs hidden">Password tidak sama</small>
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role"
                                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                    required>
                                <option value="">Select Role</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                            @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.users.index') }}"
                           class="px-6 py-3 rounded-xl text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" id="submitBtn"
                                class="px-8 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5 disabled:opacity-50"
                                style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);"
                                disabled>
                            Create User
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

const email = document.getElementById('email');
const password = document.getElementById('password');
const confirm = document.getElementById('password_confirmation');
const submitBtn = document.getElementById('submitBtn');
const emailError = document.getElementById('emailError');
const confirmError = document.getElementById('confirmError');

let emailOk = false;

async function checkEmail(value) {
    const res = await fetch('{{ route('superadmin.check.email') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ email: value })
    });
    const data = await res.json();
    emailError.classList.toggle('hidden', !data.exists);
    return !data.exists;
}

email.addEventListener('input', async () => {
    if (!email.value) return;
    emailOk = await checkEmail(email.value);
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
    if (!v) return false;

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
    if (!confirm.value) return false;
    if (confirm.value === password.value) {
        confirmError.classList.add('hidden');
        return true;
    } else {
        confirmError.classList.remove('hidden');
        return false;
    }
}

function updateSubmit() {
    submitBtn.disabled = !(emailOk && validatePassword() && validateConfirm());
}

password.addEventListener('input', () => {
    validatePassword();
    updateSubmit();
});

confirm.addEventListener('input', () => {
    validateConfirm();
    updateSubmit();
});
</script>
</x-app-layout>
