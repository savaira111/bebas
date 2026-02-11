<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Lupa kata sandi? Tidak masalah. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan reset kata sandi agar Anda dapat membuat kata sandi baru.') }}
    </div>

    <!-- Status Sesi -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <!-- Error Validasi -->
    @if ($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600 dark:text-red-400">
                {{ __('Ups! Terjadi kesalahan.') }}
            </div>

            <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Alamat Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                {{ __('Kembali ke login') }}
            </a>
            <x-primary-button>
                {{ __('Kirim Tautan Reset Kata Sandi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
