<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Tambah User
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl p-8" style="background-color:#212844; color:white;">

                <h2 class="text-2xl font-bold text-center mb-6">
                    Buat Pengguna
                </h2>

                <form action="{{ route('superadmin.users.store') }}" method="POST">
                    @csrf

                    <!-- NAMA -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nama</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- USERNAME -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Username</label>
                        <input type="text" id="username" name="username" required
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Masukkan username">

                        <small id="usernameError" class="text-red-400 hidden">
                            Username sudah digunakan
                        </small>
                    </div>

                    <!-- EMAIL -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Masukkan email">

                        <small id="emailError" class="text-red-400 hidden">
                            Email sudah terdaftar
                        </small>
                    </div>

                    <!-- ROLE -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Peran</label>
                        <select name="role" required
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Password</label>
                        <input type="password" name="password" required minlength="8"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Minimal 8 karakter">
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="mb-6">
                        <label class="block font-semibold mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Ulangi password">
                    </div>

                    <!-- BUTTONS -->
                    <div class="flex gap-3">
                        <button type="submit" id="submitBtn"
                            class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg disabled:opacity-50"
                            disabled>
                            Simpan
                        </button>

                        <a href="{{ route('superadmin.users.index') }}"
                            class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 rounded-lg text-center">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- REALTIME CHECK USERNAME & EMAIL --}}
    <script>
        const username = document.getElementById('username');
        const email = document.getElementById('email');
        const submitBtn = document.getElementById('submitBtn');

        const usernameError = document.getElementById('usernameError');
        const emailError = document.getElementById('emailError');

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
            usernameOk = await check(
                'username',
                username.value,
                '{{ route('superadmin.check.username') }}',
                usernameError
            );
            submitBtn.disabled = !(usernameOk && emailOk);
        });

        email.addEventListener('input', async () => {
            if (!email.value) return;
            emailOk = await check(
                'email',
                email.value,
                '{{ route('superadmin.check.email') }}',
                emailError
            );
            submitBtn.disabled = !(usernameOk && emailOk);
        });
    </script>
</x-app-layout>
