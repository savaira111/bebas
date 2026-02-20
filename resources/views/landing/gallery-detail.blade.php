@extends('layouts.landing')

@section('title', $gallery->title . ' — ' . $album->name)

@section('content')
    {{-- Header --}}
    <div class="bg-gradient-to-b from-pink-soft/40 to-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div data-aos="fade-right">
                <a href="{{ route('landing.album.galleries', $album) }}"
                   class="inline-flex items-center text-sm uppercase tracking-wider text-gray-500 hover:text-pink-luxury transition-colors duration-300 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to {{ $album->name }}
                </a>
            </div>
        </div>
    </div>

    {{-- Detail Content --}}
    <section class="py-12 md:py-20" style="background-color: #fdfbfb;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">

                {{-- Media Column --}}
                <div data-aos="fade-right">
                    <div class="overflow-hidden rounded-2xl shadow-xl bg-black aspect-video flex items-center justify-center">
                        @if($gallery->type === 'video')
                            @if($gallery->video_url)
                                @php
                                    $videoId = '';
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $gallery->video_url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if($videoId)
                                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                @else
                                    <div class="text-white text-center p-4">
                                        <p class="mb-2">Invalid YouTube URL</p>
                                        <a href="{{ $gallery->video_url }}" target="_blank" class="text-pink-300 underline">{{ $gallery->video_url }}</a>
                                    </div>
                                @endif
                            @elseif($gallery->image)
                                <video class="w-full h-full object-contain" controls>
                                    <source src="{{ Storage::url($gallery->image) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @elseif($gallery->image)
                            <img src="{{ Storage::url($gallery->image) }}"
                                 alt="{{ $gallery->title }}"
                                 class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105"
                                 loading="lazy">
                        @else
                            <div class="aspect-[4/3] flex items-center justify-center w-full"
                                 style="background: linear-gradient(135deg, #fceeee 0%, #f9f5eb 100%);">
                                <svg class="w-20 h-20 text-pink-luxury/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Text Column --}}
                <div data-aos="fade-left" data-aos-delay="100">
                    <div class="lg:sticky lg:top-28">
                        {{-- Category Badge --}}
                        @if($gallery->category)
                            <span class="inline-block px-4 py-1.5 rounded-full text-xs uppercase tracking-widest font-medium mb-4"
                                  style="background-color: #fceeee; color: #d4a5a5;">
                                {{ $gallery->category->name }}
                            </span>
                        @endif

                        {{-- Title --}}
                        <h1 class="font-serif text-3xl md:text-4xl text-gray-900 mb-4 leading-tight">
                            {{ $gallery->title }}
                        </h1>

                        {{-- Gold Divider --}}
                        <div class="w-16 h-0.5 mb-6" style="background-color: #d4af37;"></div>

                        {{-- Description / Vision --}}
                        @if($gallery->description)
                            <div class="prose prose-lg text-gray-600 leading-relaxed mb-8">
                                <p>{{ $gallery->description }}</p>
                            </div>
                        @endif

                        {{-- Meta Info --}}
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-8">
                            {{-- Album --}}
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-pink-luxury" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>{{ $album->name }}</span>
                            </div>

                            {{-- Date --}}
                            @if($gallery->created_at)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-pink-luxury" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $gallery->created_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('landing.galleries') }}"
                               class="inline-flex items-center px-6 py-3 rounded-full text-sm font-medium uppercase tracking-wider border transition-all duration-300 hover:-translate-y-0.5"
                               style="border-color: #d4a5a5; color: #d4a5a5;">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                All Albums
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
