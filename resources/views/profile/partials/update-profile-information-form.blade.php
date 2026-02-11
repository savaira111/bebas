<section>
    @if (session('status') === 'username-verification-sent')
        <p class="text-sm text-green-300 mb-2">Link verifikasi username telah dikirim ke email Anda.</p>
    @endif
    @if (session('status') === 'username-verified')
        <p class="text-sm text-green-300 mb-2">Username berhasil diperbarui.</p>
    @endif
    @if (session('status') === 'verification-link-sent')
        <p class="text-sm text-green-300 mb-2">Link verifikasi telah dikirim ke email Anda.</p>
    @endif
    @if (session('error'))
        <p class="text-sm text-red-300 mb-2">{{ session('error') }}</p>
    @endif

    <form id="send-email-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form id="send-username-verification" method="post" action="{{ route('profile.send-username-verification') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" onsubmit="return checkVerificationBeforeSave()">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                style="background-color:#212844;color:white;text-align:center;" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" value="Username" class="text-white" />
            <x-text-input
                id="username"
                name="username"
                type="text"
                class="mt-1 block w-full"
                :value="old('username', $user->username)"
                required
                autocomplete="username"
                style="background-color:#212844;color:white;text-align:center;" />

            <p id="username-error" class="text-sm text-red-600 mt-1 hidden">
                Username tidak boleh mengandung spasi.
            </p>

            @if($user->hasPendingUsernameVerification())
            <p class="text-sm mt-2 text-yellow-300">
                Harus verifikasi username dulu sebelum menyimpan.
                <button type="submit" form="send-username-verification" class="underline ml-1">Kirim ulang link verifikasi</button>
            </p>
            @endif

            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="email"
                style="background-color:#212844;color:white;text-align:center;" />

            @if(!$user->hasVerifiedEmail())
            <p class="text-sm mt-2 text-yellow-300">
                Harus verifikasi email dulu sebelum menyimpan.
                <button type="submit" form="send-email-verification" class="underline ml-1">Kirim ulang link verifikasi</button>
            </p>
            @endif

            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" class="text-white" />
            <x-text-input
                id="phone"
                name="phone"
                type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)"
                autocomplete="tel"
                style="background-color:#212844;color:white;text-align:center;" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Address')" class="text-white" />
            <textarea
                id="address"
                name="address"
                rows="3"
                class="mt-1 block w-full rounded-md"
                style="background-color:#212844;color:white;text-align:center;">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Save -->
        <div class="flex items-center gap-4">
            <x-primary-button>Save</x-primary-button>
        </div>
    </form>

    <!-- POPUP: Harus verifikasi dulu -->
    <div id="verifyFirstModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-[#212844] text-white p-6 rounded-2xl w-full max-w-md mx-4 flex flex-col">
            <h3 class="text-lg font-semibold mb-2">Verifikasi diperlukan</h3>
            <p class="text-sm text-gray-300 mb-4">
                Anda mengubah username atau email. Harus verifikasi dulu sebelum data bisa disimpan dan diperbarui.
            </p>
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500 w-fit">Tutup</button>
        </div>
    </div>

    <script>
        const hasPendingUsername = @json($user->hasPendingUsernameVerification());
        const emailUnverified = @json(!$user->hasVerifiedEmail());

        function checkVerificationBeforeSave() {
            if (hasPendingUsername || emailUnverified) {
                document.getElementById('verifyFirstModal').classList.remove('hidden');
                document.getElementById('verifyFirstModal').classList.add('flex');
                return false;
            }
            return true;
        }

        function closeModal() {
            document.getElementById('verifyFirstModal').classList.add('hidden');
            document.getElementById('verifyFirstModal').classList.remove('flex');
        }
    </script>
</section>
