@extends('layouts.landing')

@section('title', 'Welcome')

@section('content')
    <!-- Hero Section -->
    <div class="relative w-full h-screen min-h-[600px] flex items-center justify-center overflow-hidden">
        <!-- Background with Overlay -->
        <div class="absolute inset-0 z-0">
             <!-- Placeholder gradient - replace with actual hero image if available -->
            <div class="absolute inset-0 bg-gradient-to-r from-gray-100 to-pink-50 opacity-90"></div>
             <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?q=80&w=2574&auto=format&fit=crop')] bg-cover bg-center opacity-30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto" data-aos="fade-up">
            <p class="text-sm md:text-base uppercase tracking-[0.3em] text-gray-500 mb-4 animate-fade-in-down">Discover True Elegance</p>
            <h1 class="font-serif text-5xl md:text-7xl lg:text-8xl text-gray-900 mb-6 leading-tight">
                Luxury <span class="text-pink-luxury italic">Beauty</span>
            </h1>
            <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-2xl mx-auto font-light">
                Indulge in a collection designed to celebrate your unique radiance. Premium ingredients, timeless aesthetic, and undeniable allure.
            </p>
            <a href="{{ route('landing.about') }}" class="inline-block px-10 py-4 bg-gray-900 text-white font-medium uppercase tracking-widest hover:bg-pink-luxury transition-all duration-300 transform hover:-translate-y-1 shadow-xl rounded-sm">
                See More
            </a>
        </div>
    </div>

    <!-- Best Selling Products -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-pink-luxury uppercase tracking-widest text-sm font-bold">Shop Favorites</span>
                <h2 class="font-serif text-4xl text-gray-900 mt-2">Best Selling Products</h2>
                <div class="w-24 h-1 bg-pink-luxury mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @forelse($products as $product)
                    <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
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
                                <a href="{{ route('landing.products.show', $product) }}" class="px-6 py-2 bg-white text-gray-900 text-xs uppercase tracking-widest hover:bg-pink-luxury hover:text-white transition">View</a>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('landing.products.show', $product) }}">
                                <h3 class="font-serif text-lg text-gray-900 group-hover:text-pink-luxury transition">{{ $product->name }}</h3>
                            </a>
                            <p class="text-gray-500 mt-1">{{ optional($product->category)->name }}</p>
                            <p class="text-gray-900 font-medium mt-2">{{ $product->formatted_price }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-400 py-10">
                        <p>No products available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{ route('landing.products') }}" class="inline-block border-b border-gray-900 pb-1 text-gray-900 uppercase tracking-widest text-sm hover:text-pink-luxury hover:border-pink-luxury transition">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Most Viewed Gallery -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12" data-aos="fade-up">
                <div>
                     <span class="text-pink-luxury uppercase tracking-widest text-sm font-bold">Visual Stories</span>
                    <h2 class="font-serif text-4xl text-gray-900 mt-2">Most Viewed Gallery</h2>
                </div>
                <a href="{{ route('landing.galleries') }}" class="hidden md:inline-block border-b border-gray-900 pb-1 text-gray-900 uppercase tracking-widest text-sm hover:text-pink-luxury hover:border-pink-luxury transition">See More</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($galleries as $gallery)
                    <div class="relative group overflow-hidden h-80 rounded-sm" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}">
                        @if($gallery->type === 'video')
                            @if($gallery->video_url)
                                {{-- YouTube Thumbnail --}}
                                @php
                                    $videoId = '';
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $gallery->video_url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if($videoId)
                                    <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg"
                                         alt="{{ $gallery->title }}"
                                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                @endif
                            @elseif($gallery->image)
                                {{-- Local Video Preview --}}
                                <video class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                    <source src="{{ Storage::url($gallery->image) }}#t=0.5" type="video/mp4">
                                </video>
                            @endif

                            {{-- Play Icon Overlay for Videos --}}
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none group-hover:scale-110 transition-transform duration-500 z-10">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/40 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        @elseif($gallery->image)
                            <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                <span class="italic">No Cover</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6">
                            <span class="text-pink-luxury text-xs uppercase tracking-widest mb-2">{{ optional($gallery->category)->name }}</span>
                            <h3 class="text-white font-serif text-xl">{{ $gallery->title }}</h3>
                        </div>
                    </div>
                @empty
                     <div class="col-span-3 text-center text-gray-400 py-10">
                        <p>No gallery items found.</p>
                    </div>
                @endforelse
            </div>
             <div class="text-center mt-8 md:hidden">
                <a href="{{ route('landing.galleries') }}" class="inline-block border-b border-gray-900 pb-1 text-gray-900 uppercase tracking-widest text-sm hover:text-pink-luxury hover:border-pink-luxury transition">See More</a>
            </div>
        </div>
    </section>

    <!-- Most Read Articles -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-pink-luxury uppercase tracking-widest text-sm font-bold">Journal</span>
                <h2 class="font-serif text-4xl text-gray-900 mt-2">Most Read Articles</h2>
                <div class="w-24 h-1 bg-pink-luxury mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @forelse($articles as $article)
                    <article class="flex flex-col h-full" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="h-60 overflow-hidden rounded-sm mb-6">
                            @if($article->image)
                                <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition duration-500 hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">Image</div>
                            @endif
                        </div>
                        <div class="flex-1">
                             <div class="flex items-center text-xs text-gray-500 mb-3 space-x-2">
                                <span class="uppercase tracking-wide text-pink-luxury">{{ optional($article->category)->name }}</span>
                                <span>&bull;</span>
                                <span>{{ $article->created_at->format('M d, Y') }}</span>
                            </div>
                            <h3 class="font-serif text-xl text-gray-900 mb-3 hover:text-pink-luxury transition">
                                <a href="{{ route('landing.articles') }}">{{ $article->title }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                        </div>
                         <div class="mt-4">
                            <a href="{{ route('landing.articles') }}" class="text-sm font-medium uppercase tracking-wider text-gray-900 hover:text-pink-luxury transition">Read More</a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center text-gray-400 py-10">
                        <p>No articles published yet.</p>
                    </div>
                @endforelse
            </div>
             <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{ route('landing.articles') }}" class="inline-block border-b border-gray-900 pb-1 text-gray-900 uppercase tracking-widest text-sm hover:text-pink-luxury hover:border-pink-luxury transition">View All Articles</a>
            </div>
        </div>
    </section>

    <!-- Most Downloaded Ebooks -->
    <section class="py-20 bg-pink-soft/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-pink-luxury uppercase tracking-widest text-sm font-bold">Resources</span>
                <h2 class="font-serif text-4xl text-gray-900 mt-2">Most Downloaded Ebooks</h2>
                <div class="w-24 h-1 bg-pink-luxury mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($ebooks as $ebook)
                     <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-xl transition duration-300" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="flex items-start space-x-4">
                            <div class="w-20 h-28 bg-gray-200 flex-shrink-0 overflow-hidden shadow-md">
                                @if($ebook->cover)
                                    <img src="{{ Storage::url($ebook->cover) }}" alt="{{ $ebook->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400 text-center p-1">No Cover</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-serif text-lg text-gray-900 leading-tight mb-2">{{ $ebook->title }}</h3>
                                <div class="flex items-center text-xs text-gray-500 mb-3">
                                    <svg class="w-4 h-4 mr-1 text-pink-luxury" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    {{ $ebook->total_download }} Downloads
                                </div>
                                <a href="{{ route('landing.ebooks') }}" class="text-xs font-bold uppercase tracking-widest text-pink-luxury hover:text-gray-900 transition">Get It Now</a>
                            </div>
                        </div>
                    </div>
                @empty
                     <div class="col-span-3 text-center text-gray-400 py-10">
                        <p>No ebooks available.</p>
                    </div>
                @endforelse
            </div>
             <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{ route('landing.ebooks') }}" class="inline-block border-b border-gray-900 pb-1 text-gray-900 uppercase tracking-widest text-sm hover:text-pink-luxury hover:border-pink-luxury transition">See More Ebooks</a>
            </div>
        </div>
    </section>
@endsection
