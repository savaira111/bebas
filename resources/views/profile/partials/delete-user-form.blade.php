@if(auth()->user()->role === 'superadmin')
<section class="space-y-6 text-white">
    <header>
        <p class="mt-1 text-sm text-white/80">
            Setelah akun Anda dihapus, semua data dan sumber daya yang terkait
            akan dihapus secara permanen. Sebelum melanjutkan, pastikan Anda telah
            menyimpan data penting yang ingin dipertahankan.
        </p>
    </header>

    <!-- BUTTON OPEN CONFIRM -->
    <x-danger-button onclick="openDeleteConfirm()">
        Hapus Akun
    </x-danger-button>

    <!-- ================= POPUP KONFIRMASI ================= -->
    <div id="deleteConfirmModal"
         class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-[#212844] text-white p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h2 class="text-lg font-medium mb-2">
                Apakah Anda yakin ingin menghapus akun?
            </h2>

            <p class="text-sm text-white/80 mb-4">
                Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
                Silakan masukkan password Anda untuk mengonfirmasi.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="mb-4">
                    <x-input-label for="password" value="Password" class="sr-only" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full bg-[#2a3155] text-white border-white/30"
                        placeholder="Masukkan password"
                    />
                    <x-input-error
                        :messages="$errors->userDeletion->get('password')"
                        class="mt-2 text-red-300"
                    />
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            onclick="closeDeleteConfirm()"
                            class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-700">
                        Batal
                    </button>

                    <x-danger-button>
                        Hapus Akun
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= POPUP BERHASIL ================= -->
    @if (session('status') === 'account-deleted')
        <div id="deleteSuccessModal"
             class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
            <div class="bg-[#212844] text-white p-6 rounded-2xl w-full max-w-md shadow-2xl text-center">
                <h3 class="text-lg font-semibold mb-2">
                    Akun Berhasil Dihapus
                </h3>
                <p class="text-sm text-white/80 mb-4">
                    Akun Anda telah dihapus secara permanen.
                </p>
                <button onclick="closeDeleteSuccess()"
                        class="px-4 py-2 bg-green-600 rounded hover:bg-green-700">
                    OK
                </button>
            </div>
        </div>
    @endif

    <script>
        function openDeleteConfirm() {
            const modal = document.getElementById('deleteConfirmModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteConfirm() {
            const modal = document.getElementById('deleteConfirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function closeDeleteSuccess() {
            const modal = document.getElementById('deleteSuccessModal');
            if (modal) modal.classList.add('hidden');
        }
    </script>
</section>
@endif
