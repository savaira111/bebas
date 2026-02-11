<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white text-center leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F0E8D5] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <!-- Avatar Card -->
            <div class="p-8 bg-[#212844] text-white shadow-xl rounded-2xl">
                <div class="flex flex-col items-center space-y-6">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('default-avatar.png') }}"
                         alt="Avatar"
                         class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-md">

                    <form method="POST"
                          action="{{ route('profile.avatar.update') }}"
                          enctype="multipart/form-data"
                          class="flex flex-col items-center w-full max-w-sm space-y-3">
                        @csrf
                        @method('PATCH')

                        <input type="file"
                               name="avatar"
                               accept="image/*"
                               class="w-full text-sm rounded-lg bg-[#2b3260] px-3 py-2 focus:outline-none"
                               required>

                        <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 rounded-lg font-semibold hover:bg-green-700 transition">
                            Update Avatar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="p-8 bg-[#212844] text-white shadow-xl rounded-2xl">
                <div class="max-w-2xl mx-auto space-y-6">
                    <h3 class="text-xl font-semibold text-center">
                        Perbarui Informasi Profil
                    </h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-8 bg-[#212844] text-white shadow-xl rounded-2xl">
                <div class="max-w-2xl mx-auto space-y-6">
                    <h3 class="text-xl font-semibold text-center">
                        Perbarui Kata Sandi
                    </h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="p-8 bg-[#212844] text-white shadow-xl rounded-2xl">
                <div class="max-w-2xl mx-auto space-y-6 text-center">
                    <h3 class="text-xl font-semibold">
                        Hapus Akun
                    </h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
