<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Edit Pengguna</h2>
    </x-slot>

            <h2 class="text-2xl font-bold text-center mb-6">
                edit Pengguna
            </h2>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#212844] text-white shadow-2xl sm:rounded-lg p-6 space-y-6">

                <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="name" class="block font-semibold">Nama</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155]"
                               required>
                    </div>

                    <!-- Username -->
                    <div class="mb-4">
                        <label for="username" class="block font-semibold">Username</label>
                        <input type="text" name="username" id="username"
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155]">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block font-semibold">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155]"
                               required>
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="role" class="block font-semibold">Role</label>
                        <select name="role" id="role"
                                class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155]">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="relative mb-4">
                        <label class="block font-semibold">Password (opsional)</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155]"
                               placeholder="Masukkan password baru jika ingin mengubah">

                        <button type="button" id="toggle-password"
                                class="absolute right-3 top-9 text-gray-300">
                            <svg id="eye-open" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                                      c4.477 0 8.268 2.943 9.542 7
                                      -1.274 4.057-5.065 7-9.542 7
                                      -4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3l18 18M13.875 18.825
                                      A10.05 10.05 0 0112 19c-5.523 0-10-5-10-5"/>
                            </svg>
                        </button>

                        <!-- RULES -->
                        <div id="password-rules-wrapper" class="hidden mt-3">
                            <ul class="text-xs space-y-1 text-white">
                                <li data-rule="length">• Minimal 8 karakter</li>
                                <li data-rule="uppercase">• Huruf besar</li>
                                <li data-rule="lowercase">• Huruf kecil</li>
                                <li data-rule="number">• Angka</li>
                                <li data-rule="symbol">• Simbol</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button class="flex-1 bg-green-600 py-2 rounded-lg font-semibold">
                            Perbarui User
                        </button>
                        <a href="{{ route('superadmin.users.index') }}"
                           class="flex-1 bg-gray-500 py-2 rounded-lg text-center">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

<script>
const pw = document.getElementById('password');
const wrapper = document.getElementById('password-rules-wrapper');
const rules = document.querySelectorAll('[data-rule]');
const toggle = document.getElementById('toggle-password');
const eyeOpen = document.getElementById('eye-open');
const eyeClosed = document.getElementById('eye-closed');

const checks = {
    length: v => v.length >= 8,
    uppercase: v => /[A-Z]/.test(v),
    lowercase: v => /[a-z]/.test(v),
    number: v => /[0-9]/.test(v),
    symbol: v => /[\W_]/.test(v)
};

pw.addEventListener('focus', () => wrapper.classList.remove('hidden'));

pw.addEventListener('input', () => {
    const v = pw.value;

    rules.forEach(rule => {
        const key = rule.dataset.rule;
        rule.classList.toggle('hidden', checks[key](v));
    });

    if (!v) wrapper.classList.add('hidden');
});

toggle.onclick = () => {
    const show = pw.type === 'password';
    pw.type = show ? 'text' : 'password';
    eyeOpen.classList.toggle('hidden', !show);
    eyeClosed.classList.toggle('hidden', show);
};
</script>
</x-app-layout>
