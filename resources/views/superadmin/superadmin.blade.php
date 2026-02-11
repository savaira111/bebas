<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Superadmin Dashboard
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Greeting -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Hello, {{ Auth::user()->name }}! 🌿</h1>
                <p class="text-gray-600 text-lg">Kelola toko skincare & makeup Anda dengan mudah</p>
            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Total Users -->
                <div class="shadow-lg rounded-2xl p-6 text-center bg-gradient-to-tr from-[#212844] to-[#3b4470] text-white transition transform hover:scale-105 hover:shadow-xl">
                    <div class="text-5xl mb-2">👥</div>
                    <h3 class="text-xl font-semibold mb-1">Total Users</h3>
                    <p class="text-3xl font-bold">{{ $totalUsers ?? 0 }}</p>
                    <p class="text-sm mt-2 text-gray-300">Semua pelanggan aktif di sistem</p>
                </div>

                <!-- Artikel -->
                <div class="shadow-lg rounded-2xl p-6 text-center bg-gradient-to-tr from-[#374151] to-[#6b7280] text-white transition transform hover:scale-105 hover:shadow-xl">
                    <div class="text-5xl mb-2">📝</div>
                    <h3 class="text-xl font-semibold mb-1">Artikel</h3>
                    <p class="text-3xl font-bold">{{ $totalArticles ?? 0 }}</p>
                    <p class="text-sm mt-2 text-gray-300">Tips & info skincare dan makeup</p>
                </div>

                <!-- Album & Galleries -->
                <div class="shadow-lg rounded-2xl p-6 text-center bg-gradient-to-tr from-[#1f2937] to-[#4b5563] text-white transition transform hover:scale-105 hover:shadow-xl">
                    <div class="text-5xl mb-2">🖼️</div>
                    <h3 class="text-xl font-semibold mb-1">Album & Galleries</h3>
                    <p class="text-3xl font-bold">{{ $totalAlbums ?? 0 }}</p>
                    <p class="text-sm mt-2 text-gray-300">Koleksi produk & tutorial makeup</p>
                </div>

            </div>

        
                  <!-- Highlight Hari Ini -->
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Highlight Hari Ini ✨</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredArticles as $article)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition">
                        <img src="{{ $article->image }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $article->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($article->excerpt, 100) }}</p>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Views: {{ $article->views }}</span>
                                <span>Likes: {{ $article->likes_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
