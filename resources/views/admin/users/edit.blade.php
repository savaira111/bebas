<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">Edit Pengguna</h2>
    </x-slot>

            <h2 class="text-2xl font-bold text-center mb-6">
                Edit pengguna
            </h2>

    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #212844 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            border: 1px solid #ffffff !important;
            transition: background-color 9999s ease-in-out 0s;
        }
    </style>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#212844] text-white shadow-2xl rounded-2xl p-8">

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div>
                        <label class="block font-semibold mb-1">Nama</label>
                        <input type="text" name="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white"
                            placeholder="Masukkan nama lengkap" required>
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block font-semibold mb-1">Username</label>
                        <input type="text" name="username"
                            value="{{ old('username', $user->username) }}"
                            class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white"
                            placeholder="Masukkan username">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block font-semibold mb-1">Email</label>
                        <input type="email" name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white"
                            placeholder="Masukkan email" required>
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label class="block font-semibold mb-1">
                            Password <span class="text-gray-300 text-sm">(Kosongkan jika tidak ingin mengubah)</span>
                        </label>

                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white"
                            placeholder="Masukkan password baru">

                        <button type="button" id="toggle-password"
                            class="absolute right-3 top-9 text-gray-300">👁</button>

                        <!-- RULES -->
                        <div id="password-rules-wrapper" class="hidden mt-3">
                            <ul class="text-xs space-y-1 text-white">
                                <li data-rule="length">• Minimal 8 karakter</li>
                                <li data-rule="uppercase">• Mengandung huruf besar</li>
                                <li data-rule="lowercase">• Mengandung huruf kecil</li>
                                <li data-rule="number">• Mengandung angka</li>
                                <li data-rule="symbol">• Mengandung simbol</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex gap-4 justify-center">
                        <button class="px-6 py-2 bg-green-600 rounded-xl text-white font-semibold">
                            Perbarui Pengguna
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="px-6 py-2 bg-gray-500 rounded-xl text-white font-semibold">
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

const checks = {
    length: v => v.length >= 8,
    uppercase: v => /[A-Z]/.test(v),
    lowercase: v => /[a-z]/.test(v),
    number: v => /[0-9]/.test(v),
    symbol: v => /[\W_]/.test(v)
};

pw.addEventListener('focus', () => {
    if (pw.value) wrapper.classList.remove('hidden');
});

pw.addEventListener('input', () => {
    const v = pw.value;

    if (!v) {
        wrapper.classList.add('hidden');
        rules.forEach(r => r.classList.remove('hidden'));
        return;
    }

    wrapper.classList.remove('hidden');

    rules.forEach(rule => {
        const key = rule.dataset.rule;
        rule.classList.toggle('hidden', checks[key](v));
    });
});

toggle.onclick = () => {
    pw.type = pw.type === 'password' ? 'text' : 'password';
};
</script>
</x-app-layout>
