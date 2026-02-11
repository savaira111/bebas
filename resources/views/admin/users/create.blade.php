<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Tambah Pengguna Baru
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-md mx-auto p-8 rounded-2xl shadow-2xl bg-[#212844] text-white">

            <h2 class="text-2xl font-bold text-center mb-6">
                Buat Pengguna
            </h2>

            @if($errors->any())
                <div class="mb-3 p-2 bg-red-600 text-white rounded">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                <!-- NAME -->
                <div>
                    <label class="block font-semibold mb-1">Nama</label>
                    <input type="text" name="name" required
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">
                </div>

                <!-- USERNAME -->
                <div>
                    <label class="block font-semibold mb-1">Username</label>
                    <input type="text" name="username" id="username" required
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">

                    <small id="username-live" class="text-red-400 mt-1 hidden"></small>

                    @error('username')
                        <small class="text-red-400 mt-1 block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" required
                        value="{{ old('email') }}"
                        placeholder="Masukkan alamat email"
                        class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">

                    <small id="email-live" class="text-red-400 mt-1 hidden"></small>

                    @error('email')
                        <small class="text-red-400 mt-1 block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="relative">
                    <label class="block font-semibold mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        placeholder="Buat password yang kuat"
                        class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">

                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-9 text-gray-300">👁</button>

                    <ul id="rules" class="mt-2 text-xs space-y-1 text-white hidden">
                        <li data-rule="length">• Minimal 8 karakter</li>
                        <li data-rule="uppercase">• Huruf besar</li>
                        <li data-rule="lowercase">• Huruf kecil</li>
                        <li data-rule="number">• Angka</li>
                        <li data-rule="symbol">• Simbol</li>
                    </ul>

                    <div id="bars" class="flex gap-1 mt-2 hidden">
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                    </div>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="relative">
                    <label class="block font-semibold mb-1">Konfirmasi Password</label>
                    <input id="confirmPassword" type="password" name="password_confirmation" required
                        placeholder="Ulangi password"
                        class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">

                    <button type="button" id="toggleConfirmPassword"
                        class="absolute right-3 top-9 text-gray-300">👁</button>

                    <small id="confirmError" class="text-red-400 hidden">
                        Password tidak sama
                    </small>
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Buat Pengguna
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex-1 py-2 bg-gray-500 hover:bg-gray-600 text-white text-center rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

<script>
/* ================= PASSWORD SCRIPT (TIDAK DIUBAH) ================= */
const pass = document.getElementById('password');
const confirm = document.getElementById('confirmPassword');
const rules = document.getElementById('rules');
const barsWrap = document.getElementById('bars');
const bars = barsWrap.querySelectorAll('.bar');
const confirmError = document.getElementById('confirmError');

const ruleCheck = {
    length: v => v.length >= 8,
    uppercase: v => /[A-Z]/.test(v),
    lowercase: v => /[a-z]/.test(v),
    number: v => /[0-9]/.test(v),
    symbol: v => /[^A-Za-z0-9]/.test(v),
};

function updatePasswordUI() {
    const v = pass.value;

    if (!v) {
        rules.classList.add('hidden');
        barsWrap.classList.add('hidden');
        bars.forEach(b => b.style.background = '#4B5563');
        rules.querySelectorAll('li').forEach(li => li.classList.remove('hidden'));
        return;
    }

    rules.classList.remove('hidden');
    barsWrap.classList.remove('hidden');

    let score = 0;
    for (const key in ruleCheck) {
        const ok = ruleCheck[key](v);
        rules.querySelector(`[data-rule="${key}"]`).classList.toggle('hidden', ok);
        if (ok) score++;
    }

    bars.forEach((bar, i) => {
        bar.style.background = i < score ? 'lightgreen' : '#4B5563';
    });

    matchConfirm();
}

function matchConfirm() {
    if (!confirm.value) {
        confirm.style.borderColor = '';
        confirmError.classList.add('hidden');
        return;
    }

    if (confirm.value === pass.value) {
        confirm.style.borderColor = 'lightgreen';
        confirmError.classList.add('hidden');
    } else {
        confirm.style.borderColor = 'red';
        confirmError.classList.remove('hidden');
    }
}

togglePassword.onclick = () => pass.type = pass.type === 'password' ? 'text' : 'password';
toggleConfirmPassword.onclick = () => confirm.type = confirm.type === 'password' ? 'text' : 'password';

pass.addEventListener('input', updatePasswordUI);
confirm.addEventListener('input', matchConfirm);

/* ================= REALTIME USERNAME & EMAIL ================= */
function checkField(field, value, el, message) {
    if (!value) {
        el.classList.add('hidden');
        return;
    }

    fetch(`{{ route('check.user.field') }}?field=${field}&value=${value}`)
        .then(res => res.json())
        .then(data => {
            if (data.exists) {
                el.textContent = message;
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
}

document.getElementById('username').addEventListener('input', function () {
    checkField('username', this.value, document.getElementById('username-live'), 'Username sudah digunakan');
});

document.getElementById('email').addEventListener('input', function () {
    checkField('email', this.value, document.getElementById('email-live'), 'Email sudah terdaftar');
});
</script>
</x-app-layout>
