@extends('layouts.landing')

@section('title', 'Shop')

@section('content')
    <!-- Header -->
    <div class="bg-gray-50 py-16 text-center">
        <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-3" data-aos="fade-up">Our Collection</h1>
        <p class="text-gray-500 uppercase tracking-widest text-sm" data-aos="fade-up" data-aos-delay="100">Explore our premium range</p>
    </div>

    <!-- Products Grid -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                @forelse($products as $product)
                    <div class="group" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                        <div class="relative overflow-hidden aspect-[3/4] bg-gray-100 mb-4 rounded-sm">
                             @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                    <span class="text-xs uppercase tracking-widest">No Image</span>
                                </div>
                            @endif
                             <!-- Overlay Action -->
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <a href="{{ route('landing.products.show', $product) }}" class="px-6 py-2 bg-white text-gray-900 text-xs uppercase tracking-widest hover:bg-pink-luxury hover:text-white transition">Details</a>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('landing.products.show', $product) }}">
                                <h3 class="font-serif text-lg text-gray-900 group-hover:text-pink-luxury transition">{{ $product->name }}</h3>
                            </a>
                            <p class="text-gray-500 mt-1 text-sm">{{ optional($product->category)->name }}</p>
                            <p class="text-gray-900 font-medium mt-2">{{ $product->formatted_price }}</p>
                        </div>
                    </div>
                @empty
                     <div class="col-span-full text-center py-20">
                        <div class="inline-block p-6 rounded-full bg-gray-50 mb-4">
                            <svg class="w-8 h-8 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                        <p class="text-gray-500 mt-1">Check back later for our new collection.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection
