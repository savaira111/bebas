<section class="text-white">

    <form method="post"
          action="{{ route('password.update') }}"
          class="mt-6 space-y-6"
          onsubmit="return openPasswordVerify(event)">
        @csrf
        @method('put')

        <!-- Password Lama -->
        <div>
            <x-input-label
                for="update_password_current_password"
                value="Password Saat Ini"
                class="!text-white"
            />

            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white"
                placeholder="Masukkan password saat ini"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2 text-red-300"
            />
        </div>

        <!-- Password Baru -->
        <div class="relative">
            <x-input-label
                for="update_password_password"
                value="Password Baru"
                class="!text-white"
            />

            <div class="relative">
                <x-text-input
                    id="update_password_password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white pr-12"
                    placeholder="Masukkan password baru"
                />
                <button type="button"
                        onclick="togglePassword('update_password_password', this)"
                        class="absolute inset-y-0 right-3 text-sm text-gray-300">
                    👁
                </button>
            </div>

            <!-- Strength Bars -->
            <div class="flex gap-2 mt-3">
                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-length"></div>
                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-uppercase"></div>
                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-lowercase"></div>
                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-number"></div>
                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-symbol"></div>
            </div>

            <!-- Rules -->
            <ul class="mt-2 text-xs space-y-1" id="rules">
                <li data-rule="length" class="text-red-400 hidden">• Minimal 8 karakter</li>
                <li data-rule="uppercase" class="text-red-400 hidden">• Huruf besar</li>
                <li data-rule="lowercase" class="text-red-400 hidden">• Huruf kecil</li>
                <li data-rule="number" class="text-red-400 hidden">• Angka</li>
                <li data-rule="symbol" class="text-red-400 hidden">• Simbol</li>
            </ul>

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2 text-red-300"
            />
        </div>

        <!-- Konfirmasi Password -->
        <div class="relative">
            <x-input-label
                for="update_password_password_confirmation"
                value="Konfirmasi Password Baru"
                class="!text-white"
            />

            <div class="relative">
                <x-text-input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white pr-12"
                    placeholder="Ulangi password baru"
                />
                <button type="button"
                        onclick="togglePassword('update_password_password_confirmation', this)"
                        class="absolute inset-y-0 right-3 text-sm text-gray-300">
                    👁
                </button>
            </div>

            <small id="confirmError" class="text-red-400 hidden">
                Password tidak sama
            </small>

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2 text-red-300"
            />
        </div>

        <!-- Button -->
        <div class="flex items-center gap-4">
            <x-primary-button
                id="submitBtn"
                class="bg-gray text-[#212844] hover:bg-gray/90"
                disabled>
                Simpan
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-300">
                    Password berhasil diperbarui.
                </p>
            @endif
        </div>

        <!-- PERINGATAN PASSWORD LAMA SALAH -->
        @if ($errors->updatePassword->has('current_password'))
            <p class="mt-4 text-sm text-red-400">
                ❌ Password lama yang Anda masukkan tidak benar. Silakan coba lagi.
            </p>
        @endif
    </form>

    <!-- ================= POPUP VERIFIKASI ================= -->
    <div id="passwordVerifyModal"
         class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-[#212844] text-white p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-lg font-semibold mb-2">Verifikasi Keamanan</h3>
            <p class="text-sm text-gray-300 mb-4">
                Konfirmasi perubahan password Anda.
            </p>

            <div class="flex justify-end gap-3">
                <button onclick="closePasswordVerify()"
                        class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-700">
                    Batal
                </button>
                <button onclick="confirmPasswordVerify()"
                        class="px-4 py-2 bg-green-600 rounded hover:bg-green-700">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.textContent = input.type === 'password' ? '👁' : '🙈';
        }

        const password = document.getElementById('update_password_password');
        const confirm = document.getElementById('update_password_password_confirmation');
        const submitBtn = document.getElementById('submitBtn');
        const confirmError = document.getElementById('confirmError');

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
                Object.values(bars).forEach(b => b.style.background = '#4B5563');
                submitBtn.disabled = true;
                return;
            }

            Object.values(rules).forEach(r => r.classList.remove('hidden'));

            function check(cond, bar, rule) {
                if (cond) {
                    bar.style.background = 'lightgreen';
                    rule.classList.add('hidden');
                } else {
                    bar.style.background = '#4B5563';
                    rule.classList.remove('hidden');
                }
            }

            check(v.length >= 8, bars.length, rules.length);
            check(/[A-Z]/.test(v), bars.uppercase, rules.uppercase);
            check(/[a-z]/.test(v), bars.lowercase, rules.lowercase);
            check(/[0-9]/.test(v), bars.number, rules.number);
            check(/[^A-Za-z0-9]/.test(v), bars.symbol, rules.symbol);

            validateConfirm();
            updateSubmit();
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
            const allValid = Object.keys(bars)
                .every(k => bars[k].style.background === 'lightgreen');

            submitBtn.disabled = !(allValid && validateConfirm());
        }

        password.addEventListener('input', validatePassword);
        confirm.addEventListener('input', () => {
            validateConfirm();
            updateSubmit();
        });

        let passwordForm = null;

        function openPasswordVerify(e) {
            if (submitBtn.disabled) return false;

            e.preventDefault();
            passwordForm = e.target;

            const modal = document.getElementById('passwordVerifyModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            return false;
        }

        function closePasswordVerify() {
            const modal = document.getElementById('passwordVerifyModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            passwordForm = null;
        }

        function confirmPasswordVerify() {
            if (passwordForm) passwordForm.submit();
        }
    </script>

</section>
