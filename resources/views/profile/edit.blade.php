<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Avatar Card -->
            <div class="p-4 sm:p-8 bg-white shadow-xl rounded-3xl border border-gray-50 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#d4a5a5] to-[#c29595]"></div>
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900" style="font-family: 'Playfair Display', serif;">
                                {{ __('Avatar') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your profile picture.") }}
                            </p>
                        </header>
                        
                        <div class="mt-6 flex items-center gap-6">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('default-avatar.png') }}"
                                 alt="Avatar"
                                 class="w-24 h-24 rounded-full border-4 border-gray-100 object-cover shadow-sm">

                            <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label class="block">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-red-50 file:text-red-700
                                          hover:file:bg-red-100
                                          transition cursor-pointer
                                        "/>
                                    </label>
                                </div>

                                <button type="submit" class="px-6 py-2 rounded-full text-white text-sm font-medium shadow-md hover:shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                                    {{ __('Save Avatar') }}
                                </button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="p-4 sm:p-8 bg-white shadow-xl rounded-3xl border border-gray-50 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#d4a5a5] to-[#c29595]"></div>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-4 sm:p-8 bg-white shadow-xl rounded-3xl border border-gray-50 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#d4a5a5] to-[#c29595]"></div>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="p-4 sm:p-8 bg-white shadow-xl rounded-3xl border border-gray-50 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#d4a5a5] to-[#c29595]"></div>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
