<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900" style="font-family: 'Playfair Display', serif;">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-6">
            <!-- Current Password -->
            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" 
                    class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div x-data="{ show: false }" class="relative">
                <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700" />
                <div class="relative">
                     <x-text-input id="update_password_password" name="password" x-bind:type="show ? 'text' : 'password'" 
                        class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-10" 
                        autocomplete="new-password" />
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center pt-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-5 w-5" :class="{'hidden': !show, 'block': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg class="h-5 w-5" :class="{'block': !show, 'hidden': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.575-3.107m7.065 7.065L2 12m17.518-2.518A10.05 10.05 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7a10.05 10.05 0 01-3.107-1.575m0 0L3 3l18 18" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
             <div x-data="{ show: false }" class="relative">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                <div class="relative">
                     <x-text-input id="update_password_password_confirmation" name="password_confirmation" x-bind:type="show ? 'text' : 'password'" 
                        class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-10" 
                        autocomplete="new-password" />
                     <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center pt-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-5 w-5" :class="{'hidden': !show, 'block': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg class="h-5 w-5" :class="{'block': !show, 'hidden': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.575-3.107m7.065 7.065L2 12m17.518-2.518A10.05 10.05 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7a10.05 10.05 0 01-3.107-1.575m0 0L3 3l18 18" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4">
             <button type="submit" class="px-6 py-2 rounded-full text-white text-sm font-medium shadow-md hover:shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
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
