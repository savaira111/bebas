{{-- resources/views/user/landing.blade.php --}}

<x-app-layout>
    <div class="bg-[#FFF5F8] min-h-screen">

        {{-- HERO --}}
        <section class="bg-gradient-to-r from-[#FDE7EF] to-[#FFF5F8] py-24">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
                
                <div>
                    <h1 class="text-5xl font-extrabold text-[#E91E63] leading-tight mb-6">
                        Discover Your Beauty Routine
                    </h1>
                    <p class="text-gray-600 text-lg mb-8">
                        Jelajahi koleksi skincare & makeup pilihan yang sudah dikurasi khusus untuk kamu.
                    </p>
                    <a href="#produk"
                       class="bg-[#E91E63] hover:bg-pink-600 text-white px-8 py-3 rounded-full font-semibold transition">
                        Explore Now
                    </a>
                </div>

                <div>
                    <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348"
                         class="rounded-3xl shadow-xl"
                         alt="Beauty">
                </div>

            </div>
        </section>


        {{-- FITUR --}}
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-[#E91E63] mb-14">Kenapa Pilih Kami?</h2>

                <div class="grid md:grid-cols-3 gap-10">

                    <div class="bg-[#FFF0F5] p-8 rounded-2xl shadow hover:scale-105 transition">
                        <div class="text-4xl mb-4">💖</div>
                        <h3 class="font-semibold text-lg mb-2">Produk Terverifikasi</h3>
                        <p class="text-gray-600 text-sm">
                            Semua produk disediakan langsung oleh Super Admin dan terjamin kualitasnya.
                        </p>
                    </div>

                    <div class="bg-[#FFF0F5] p-8 rounded-2xl shadow hover:scale-105 transition">
                        <div class="text-4xl mb-4">✨</div>
                        <h3 class="font-semibold text-lg mb-2">Artikel Beauty</h3>
                        <p class="text-gray-600 text-sm">
                            Dapatkan tips skincare & makeup terbaru setiap minggu.
                        </p>
                    </div>

                    <div class="bg-[#FFF0F5] p-8 rounded-2xl shadow hover:scale-105 transition">
                        <div class="text-4xl mb-4">🌸</div>
                        <h3 class="font-semibold text-lg mb-2">Soft & Elegant</h3>
                        <p class="text-gray-600 text-sm">
                            Tampilan website dirancang nyaman dan aesthetic ala beauty brand.
                        </p>
                    </div>

                </div>
            </div>
        </section>


        {{-- PRODUK PREVIEW --}}
        <section id="produk" class="py-20 bg-[#FFF5F8]">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-bold text-center text-[#E91E63] mb-12">
                    Produk Pilihan
                </h2>

                <div class="grid md:grid-cols-4 gap-8">

                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition p-4">
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="rounded-xl mb-4 h-48 w-full object-cover">

                            <h3 class="font-semibold text-lg mb-1">
                                {{ $product->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mb-2">
                                {{ Str::limit($product->description, 60) }}
                            </p>

                            <a href="{{ route('user.products.show',$product->id) }}"
                               class="text-[#E91E63] text-sm font-semibold hover:underline">
                                Lihat Detail →
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>


        {{-- CTA --}}
        <section class="py-20 bg-gradient-to-r from-[#FDE7EF] to-[#FFF5F8] text-center">
            <h2 class="text-4xl font-bold text-[#E91E63] mb-6">
                Ready to Glow?
            </h2>
            <p class="text-gray-600 mb-8">
                Temukan produk dan tips terbaik untuk tampil lebih percaya diri.
            </p>
            <a href="{{ route('login') }}"
               class="bg-[#E91E63] hover:bg-pink-600 text-white px-8 py-3 rounded-full font-semibold transition">
                Masuk Sekarang
            </a>
        </section>


        {{-- FOOTER --}}
        <footer class="bg-white py-8 text-center text-gray-400 text-sm">
            © 2026 Beauty Hub. All Rights Reserved.
        </footer>

    </div>
</x-app-layout>
