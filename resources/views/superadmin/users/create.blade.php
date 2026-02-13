<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form method="POST" action="{{ route('superadmin.users.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-600 font-medium mb-2 font-serif">Full Name</label>
                            <input id="name" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. Jane Doe" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-gray-600 font-medium mb-2 font-serif">Username</label>
                                <input id="username" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                    type="text" name="username" value="{{ old('username') }}" required placeholder="e.g. janedoe" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-600 font-medium mb-2 font-serif">Email Address</label>
                                <input id="email" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4" 
                                    type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. jane@example.com" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-gray-600 font-medium mb-2 font-serif">Role</label>
                            <select id="role" name="role" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 cursor-pointer">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1 italic">Note: Superadmin role cannot be assigned here.</p>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ show: false }">
                            <!-- Password -->
                            <div class="relative">
                                <label for="password" class="block text-gray-600 font-medium mb-2 font-serif">Password</label>
                                <input id="password" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-10" 
                                    :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="••••••••" />
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center pt-8 text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg class="h-5 w-5" :class="{'hidden': !show, 'block': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg class="h-5 w-5" :class="{'block': !show, 'hidden': show}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.575-3.107m7.065 7.065L2 12m17.518-2.518A10.05 10.05 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7a10.05 10.05 0 01-3.107-1.575m0 0L3 3l18 18" /></svg>
                                </button>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="relative">
                                <label for="password_confirmation" class="block text-gray-600 font-medium mb-2 font-serif">Confirm Password</label>
                                <input id="password_confirmation" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 pr-10" 
                                    :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-50">
                        <a href="{{ route('superadmin.users.index') }}" class="px-6 py-3 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 font-medium transition mr-4">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-full text-white font-medium shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                            {{ __('Create User') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
