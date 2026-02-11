<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#212844] leading-tight">
            User Dashboard
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Greeting -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-[#212844] mb-2">Hello, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-[#212844] text-lg">Selamat datang di dashboard Anda</p>
            </div>

            

            <!-- Info / Statistik sederhana (optional) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-lg bg-[#212844] text-white shadow-lg text-center hover:scale-105 hover:shadow-2xl transition transform">
                    <div class="text-4xl mb-2">📧</div>
                    <h3 class="text-lg font-semibold mb-1">Email</h3>
                    <p class="text-xl font-bold">{{ Auth::user()->email }}</p>
                </div>

                <div class="p-6 rounded-lg bg-[#212844] text-white shadow-lg text-center hover:scale-105 hover:shadow-2xl transition transform">
                    <div class="text-4xl mb-2">👤</div>
                    <h3 class="text-lg font-semibold mb-1">Role</h3>
                    <p class="text-xl font-bold">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
