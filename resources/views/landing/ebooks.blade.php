@extends('layouts.landing')

@section('title', 'Library')

@section('content')
    {{-- Hero Section --}}
    <div class="relative w-full h-[350px] flex items-center justify-center bg-[#fdfbfb] overflow-hidden">
        <div class="absolute inset-0 bg-[#fceeee] opacity-50"></div>
        <div class="relative z-10 text-center px-4" data-aos="fade-up">
            <span class="text-pink-luxury uppercase tracking-widest text-sm font-bold block mb-2">Knowledge & Resources</span>
            <h1 class="font-serif text-5xl md:text-6xl text-gray-900 mb-4">
                E-Book <span class="text-pink-luxury italic">Library</span>
            </h1>
            <div class="w-24 h-1 bg-pink-luxury mx-auto mt-6"></div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="bg-white min-h-screen py-16 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            
            {{-- Filter Section --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 space-y-4 md:space-y-0" data-aos="fade-up">
                <div class="text-gray-900 font-serif text-2xl tracking-wide">
                    Browse Collection
                </div>
                
                {{-- Filter Buttons --}}
                <div class="flex space-x-2 bg-gray-50 p-1.5 rounded-full border border-gray-100">
                    @php
                        $currentFilter = request('filter', 'latest');
                        $filters = [
                            'latest' => 'Terbaru',
                            'oldest' => 'Terlama',
                            'popular' => 'Terpopuler'
                        ];
                    @endphp

                    @foreach($filters as $key => $label)
                        <a href="{{ route('landing.ebooks', ['filter' => $key]) }}" 
                           class="px-6 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ $currentFilter === $key ? 'bg-pink-luxury text-white shadow-md' : 'text-gray-500 hover:text-pink-luxury hover:bg-white' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Ebook Grid --}}
            @if($ebooks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($ebooks as $ebook)
                        <div class="group relative bg-white rounded-sm overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            
                            {{-- Image Container --}}
                            <div class="aspect-[3/4] overflow-hidden relative bg-gray-50">
                                @if($ebook->cover)
                                    <img src="{{ asset('storage/' . $ebook->cover) }}" 
                                         alt="{{ $ebook->title }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <span class="font-serif text-lg italic">No Cover</span>
                                    </div>
                                @endif
                                
                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                
                                {{-- Access Badge --}}
                                <div class="absolute top-4 left-4 z-20">
                                    @if($ebook->is_auth_required)
                                        <span class="bg-red-500/90 backdrop-blur-sm text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                            Member Only
                                        </span>
                                    @else
                                        <span class="bg-[#d4a5a5]/90 backdrop-blur-sm text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                            Public
                                        </span>
                                    @endif
                                </div>

                                {{-- Download Badge --}}
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-sm text-xs text-gray-600 shadow-sm flex items-center gap-2 z-20">
                                    <svg class="w-3 h-3 text-pink-luxury" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    {{ number_format($ebook->total_download) }}
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-8 text-center">
                                <h3 class="font-serif text-xl text-gray-900 mb-3 group-hover:text-pink-luxury transition-colors leading-tight min-h-[3.5rem] flex items-center justify-center">
                                    {{ $ebook->title }}
                                </h3>
                                
                                <div class="w-10 h-0.5 bg-pink-luxury/30 mx-auto mb-4"></div>

                                <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed font-light">
                                    {{ Str::limit($ebook->description ?? 'No description available.', 80) }}
                                </p>
                                
                                <a href="{{ route('landing.ebooks.show', $ebook->id) }}" 
                                   class="inline-block text-xs font-bold uppercase tracking-widest text-gray-900 hover:text-pink-luxury transition-colors border-b border-gray-900 hover:border-pink-luxury pb-1">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-16 flex justify-center">
                    {{ $ebooks->links() }} 
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-center bg-gray-50 rounded-lg border border-gray-100">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 text-pink-luxury shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl text-gray-900 font-serif mb-2">Collection Coming Soon</h3>
                    <p class="text-gray-500 max-w-md">Our curated library is being updated. Please check back later.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
