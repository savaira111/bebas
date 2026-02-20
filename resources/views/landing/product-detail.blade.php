@extends('layouts.landing')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb (Optional but good for UX) -->
    <div class="bg-gray-50 py-4 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('landing.products') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-pink-luxury transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Shop
            </a>
        </div>
    </div>

    <!-- Product Details -->
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-12 lg:gap-20">
                
                <!-- Product Image -->
                <div class="w-full md:w-1/2" data-aos="fade-right">
                    <div class="relative aspect-square bg-gray-50 rounded-2xl overflow-hidden shadow-sm border border-gray-100 p-8 flex items-center justify-center group">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain transition duration-700 group-hover:scale-105">
                        @else
                            <div class="text-gray-300 flex flex-col items-center">
                                <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs uppercase tracking-widest font-medium">No Image Available</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="w-full md:w-1/2 flex flex-col justify-center" data-aos="fade-left">
                    <span class="text-pink-luxury text-sm font-bold uppercase tracking-widest mb-2">{{ optional($product->category)->name ?? 'Collection' }}</span>
                    <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-4 leading-tight">{{ $product->name }}</h1>
                    
                    <div class="text-2xl font-medium text-gold-600 mb-8 font-serif">
                       {{ "Rp " . number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="prose prose-sm text-gray-500 mb-10 leading-relaxed">
                        <p>{!! nl2br(e($product->description)) !!}</p>
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-gray-100 pt-8" x-data="{ qty: 1 }">
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            
                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-gray-200 rounded-full px-4 py-2 space-x-4">
                                <button @click="if(qty > 1) qty--" class="text-gray-400 hover:text-pink-luxury focus:outline-none transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                <span class="text-gray-900 font-medium w-4 text-center" x-text="qty">1</span>
                                <button @click="qty++" class="text-gray-400 hover:text-pink-luxury focus:outline-none transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>

                            <!-- Buy Button -->
                            <button @click="buyNow(qty)" class="w-full sm:w-auto px-10 py-3 bg-gradient-to-r from-[#d4a5a5] to-[#c29595] text-white font-medium uppercase tracking-widest rounded-full shadow-lg hover:shadow-pink-200 hover:-translate-y-1 transition duration-300 flex-grow text-center">
                                Buy Now
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-4 text-center sm:text-left">
                            <span class="inline-block w-2 h-2 rounded-full bg-green-400 mr-2"></span> In stock and ready to ship
                        </p>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-24 pt-16 border-t border-gray-100">
                    <h3 class="font-serif text-2xl text-gray-900 mb-8 text-center">You May Also Like</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                         @foreach($relatedProducts as $related)
                            <div class="group">
                                <a href="{{ route('landing.products.show', $related) }}" class="block">
                                    <div class="relative overflow-hidden aspect-[3/4] bg-gray-50 mb-3 rounded-sm">
                                        @if($related->image)
                                            <img src="{{ Storage::url($related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">No Image</div>
                                        @endif
                                    </div>
                                    <h4 class="font-serif text-base text-gray-900 group-hover:text-pink-luxury transition">{{ $related->name }}</h4>
                                    <p class="text-sm font-medium text-gray-500 mt-1">{{ "Rp " . number_format($related->price, 0, ',', '.') }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function buyNow(qty) {
            Swal.fire({
                title: 'Informasi Pemesanan',
                text: "Pemesanan produk dilakukan melalui DM Instagram kami.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjut ke Instagram',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'font-sans rounded-2xl',
                    title: 'font-serif text-gray-800',
                    confirmButton: 'rounded-full px-6',
                    cancelButton: 'rounded-full px-6'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("https://www.instagram.com/luxbe512?igsh=ajljbjdrZHQzbWt3", "_blank");
                }
            })
        }
    </script>
@endsection
