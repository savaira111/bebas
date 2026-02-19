@extends('layouts.landing')

@section('title', 'Artikel')

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-b from-pink-soft/40 to-white py-16 text-center">
        <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-3" data-aos="fade-up">Artikel</h1>
        <p class="text-gray-500 uppercase tracking-widest text-sm" data-aos="fade-up" data-aos-delay="100">Beauty tips, trends, and news</p>
        
        {{-- Add Article Button --}}
        <div class="mt-8" data-aos="fade-up" data-aos-delay="200">
            @auth
                <a href="{{ route('user.articles.create') }}" class="inline-flex items-center px-8 py-3 rounded-full text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Tulis Artikel
                </a>
            @else
                <button onclick="promptLoginForArticle()" class="inline-flex items-center px-8 py-3 rounded-full text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tulis Artikel
                </button>
            @endauth
        </div>

        <div class="w-20 h-0.5 bg-pink-luxury mx-auto mt-6" data-aos="fade-up" data-aos-delay="150"></div>
    </div>

    <!-- Filters & Sorting -->
    <section class="py-8 bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0" data-aos="fade-up">
                
                {{-- Category Filters --}}
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="{{ route('landing.articles', ['filter' => request('filter')]) }}" 
                       class="px-4 py-2 rounded-full text-xs uppercase tracking-wider font-medium transition-all {{ !request('category') ? 'bg-gray-900 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('landing.articles', ['category' => $category->id, 'filter' => request('filter')]) }}" 
                           class="px-4 py-2 rounded-full text-xs uppercase tracking-wider font-medium transition-all {{ request('category') == $category->id ? 'bg-gray-900 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                {{-- Sort Dropdown --}}
                <div class="flex items-center space-x-2">
                    <span class="text-xs uppercase tracking-wider text-gray-500">Sort by:</span>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 flex items-center space-x-2 hover:border-pink-luxury transition min-w-[140px] justify-between">
                            <span>
                                @switch(request('filter'))
                                    @case('popular') Popular @break
                                    @case('views') Most Viewed @break
                                    @default Latest
                                @endswitch
                            </span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-xl border border-gray-100 z-10 py-1" x-transition.origin.top.right>
                            <a href="{{ route('landing.articles', ['filter' => 'latest', 'category' => request('category')]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-soft hover:text-gray-900">Latest</a>
                            <a href="{{ route('landing.articles', ['filter' => 'popular', 'category' => request('category')]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-soft hover:text-gray-900">Popular</a>
                            <a href="{{ route('landing.articles', ['filter' => 'views', 'category' => request('category')]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-soft hover:text-gray-900">Most Viewed</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Articles List -->
    <section class="py-16 bg-white min-h-[600px]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-12">
                @forelse($articles as $article)
                     <article class="flex flex-col md:flex-row gap-8 items-start group" data-aos="fade-up">
                        <a href="{{ route('landing.articles.show', $article) }}" class="w-full md:w-5/12 aspect-[4/3] overflow-hidden rounded-2xl shadow-md block relative">
                            @if($article->image)
                                <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                    <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            {{-- Overlay on hover --}}
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-all duration-500"></div>
                        </a>
                        
                        <div class="flex-1 pt-2">
                             <div class="flex items-center text-xs text-gray-500 mb-3 space-x-3">
                                @if($article->category)
                                    <span class="px-2 py-1 rounded-md bg-pink-soft text-pink-luxury uppercase tracking-wide font-bold text-[10px]">{{ $article->category->name }}</span>
                                @endif
                                <div class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $article->created_at->format('M d, Y') }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $article->user->name ?? 'Author' }}
                                </div>
                            </div>

                            <h2 class="font-serif text-2xl text-gray-900 mb-3 leading-tight group-hover:text-pink-luxury transition-colors duration-300">
                                <a href="{{ route('landing.articles.show', $article) }}">{{ $article->title }}</a>
                            </h2>

                            <p class="text-gray-500 leading-relaxed mb-5 line-clamp-3 text-sm md:text-base">
                                {{ Str::limit(strip_tags($article->content), 180) }}
                            </p>

                            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                <div class="flex items-center space-x-4 text-xs text-gray-400 font-medium uppercase tracking-wider">
                                    <div class="flex items-center" title="Views">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        {{ number_format($article->views) }}
                                    </div>
                                    <div class="flex items-center" title="Likes">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        {{ number_format($article->likes_count) }}
                                    </div>
                                </div>

                                <a href="{{ route('landing.articles.show', $article) }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-gray-900 group-hover:text-pink-luxury transition">
                                    Read More
                                    <svg class="w-3.5 h-3.5 ml-1 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                     <div class="text-center py-20 col-span-full">
                         <div class="inline-block p-6 rounded-full bg-gray-50 mb-4">
                            <svg class="w-10 h-10 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No articles found</h3>
                        <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
                        <a href="{{ route('landing.articles') }}" class="inline-block mt-4 text-pink-luxury text-sm hover:underline">Clear all filters</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
    <script>
        function promptLoginForArticle() {
            Swal.fire({
                title: 'Ingin Menulis Artikel?',
                text: "Silakan login terlebih dahulu untuk mulai berkontribusi.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Login Sekarang',
                cancelButtonText: 'Nanti Saja',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'text-white px-6 py-2 rounded-full font-bold text-xs uppercase tracking-wider',
                    cancelButton: 'text-gray-600 px-6 py-2 rounded-full font-bold text-xs uppercase tracking-wider hover:bg-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}?return_url=" + encodeURIComponent(window.location.href);
                }
            })
        }
    </script>
    @endpush
@endsection
