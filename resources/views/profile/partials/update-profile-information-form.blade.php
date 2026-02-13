<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900" style="font-family: 'Playfair Display', serif;">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" onsubmit="return checkVerificationBeforeSave()">
        @csrf
        @method('patch')

        <div class="space-y-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                <x-text-input id="name" name="name" type="text" 
                    class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <!-- Username -->
                <div>
                    <x-input-label for="username" value="Username" class="text-gray-700" />
                    <x-text-input id="username" name="username" type="text" 
                        class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                        :value="old('username', $user->username)" required autocomplete="username" />

                    @if($user->hasPendingUsernameVerification())
                        <p class="text-sm mt-2 text-yellow-600">
                            Harus verifikasi username dulu sebelum menyimpan.
                            <button type="submit" form="send-username-verification" class="underline ml-1 font-medium text-yellow-700">Kirim ulang link verifikasi</button>
                        </p>
                    @endif
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input id="email" name="email" type="email" 
                        class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                        :value="old('email', $user->email)" required autocomplete="email" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                     <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
            </div>

             <!-- Phone -->
             <div>
                <x-input-label for="phone" :value="__('Phone')" class="text-gray-700" />
                <x-text-input id="phone" name="phone" type="text" 
                    class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                    :value="old('phone', $user->phone)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- Address -->
            <div>
                <x-input-label for="address" :value="__('Address')" class="text-gray-700" />
                <textarea id="address" name="address" rows="3" 
                    class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4">{{ old('address', $user->address) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
             <button type="submit" class="px-6 py-2 rounded-full text-white text-sm font-medium shadow-md hover:shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
