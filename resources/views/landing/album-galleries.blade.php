@extends('layouts.landing')

@section('title', $album->name . ' — Portfolio')

@section('content')
    {{-- Header --}}
    <div class="bg-gradient-to-b from-pink-soft/40 to-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-8" data-aos="fade-right">
                <a href="{{ route('landing.galleries') }}"
                   class="inline-flex items-center text-sm uppercase tracking-wider text-gray-500 hover:text-pink-luxury transition-colors duration-300 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Albums
                </a>
            </div>

            {{-- Album Title --}}
            <div class="text-center" data-aos="fade-up">
                <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-3">{{ $album->name }}</h1>
                @if($album->description)
                    <p class="text-gray-500 max-w-2xl mx-auto mt-4 leading-relaxed">{{ $album->description }}</p>
                @endif
                <div class="w-20 h-0.5 bg-pink-luxury mx-auto mt-6"></div>
            </div>
        </div>
    </div>

    {{-- Gallery Grid --}}
    <section class="py-20" style="background-color: #fdfbfb;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($galleries as $gallery)
                    <a href="{{ route('landing.gallery.detail', [$album, $gallery]) }}"
                       class="group block"
                       data-aos="fade-up"
                       data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                        <div class="relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-500">
                            {{-- Media --}}
                            <div class="aspect-[4/3] overflow-hidden relative">
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
                                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                                 loading="lazy">
                                        @endif
                                    @elseif($gallery->image)
                                        {{-- Local Video Preview --}}
                                        <video class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                            <source src="{{ Storage::url($gallery->image) }}#t=0.5" type="video/mp4">
                                        </video>
                                    @endif
                                    
                                    {{-- Play Icon Overlay for Videos --}}
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none group-hover:scale-110 transition-transform duration-500">
                                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/40 shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @elseif($gallery->image)
                                    <img src="{{ Storage::url($gallery->image) }}"
                                         alt="{{ $gallery->title }}"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background: linear-gradient(135deg, #fceeee 0%, #f9f5eb 100%);">
                                        <svg class="w-14 h-14 text-pink-luxury/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Hover Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                                <h3 class="text-white font-serif text-xl transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    {{ $gallery->title }}
                                </h3>
                                @if($gallery->description)
                                    <p class="text-gray-200 text-sm mt-2 max-w-xs transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75">
                                        {{ Str::limit($gallery->description, 60) }}
                                    </p>
                                @endif
                                <span class="inline-flex items-center text-pink-luxury text-xs uppercase tracking-widest mt-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                    View Detail
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="inline-block p-8 rounded-full mb-6" style="background-color: #fceeee;">
                            <svg class="w-12 h-12 text-pink-luxury/60 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-serif text-xl text-gray-900 mb-2">No Photos Yet</h3>
                        <p class="text-gray-500">This album is being curated. Check back soon.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($galleries->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
