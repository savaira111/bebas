<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#212844] leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Sambutan / Intro -->
            <div class="mb-6 p-6 bg-[#212844] text-white rounded-2xl shadow-lg text-center transition transform hover:scale-105">
                <h3 class="text-2xl font-bold">Selamat datang, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-300 mt-2">
                    Ini adalah dashboard admin. Kamu dapat melihat dan mengelola semua pengguna biasa di sini.
                </p>
            </div>

            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-[#212844] text-white shadow-xl rounded-2xl p-6 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-2">👥</div>
                    <h3 class="text-lg font-semibold mb-2">Total Pengguna</h3>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                </div>

                <div class="bg-[#212844] text-white shadow-xl rounded-2xl p-6 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-2">🆕</div>
                    <h3 class="text-lg font-semibold mb-2">Pendaftaran Terbaru</h3>
                    <p class="text-2xl font-bold">{{ $recentUsers }}</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
