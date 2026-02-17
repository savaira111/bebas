@extends('layouts.landing')

@section('title', 'Portfolio')

@section('content')
    {{-- Header --}}
    <div class="bg-gradient-to-b from-pink-soft/40 to-white py-16 text-center">
        <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-3" data-aos="fade-up">Our Portfolio</h1>
        <p class="text-gray-500 uppercase tracking-widest text-sm" data-aos="fade-up" data-aos-delay="100">Explore our curated album collections</p>
        <div class="w-20 h-0.5 bg-pink-luxury mx-auto mt-6" data-aos="fade-up" data-aos-delay="150"></div>
    </div>

    {{-- Albums Grid --}}
    <section class="py-20" style="background-color: #fdfbfb;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($albums as $album)
                    <a href="{{ route('landing.album.galleries', $album) }}"
                       class="group block"
                       data-aos="fade-up"
                       data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                        <div class="relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-500">
                            {{-- Cover Image --}}
                            <div class="aspect-[4/3] overflow-hidden">
                                @if($album->cover_image)
                                    <img src="{{ Storage::url($album->cover_image) }}"
                                         alt="{{ $album->name }}"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background: linear-gradient(135deg, #fceeee 0%, #f9f5eb 100%);">
                                        <svg class="w-16 h-16 text-pink-luxury/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                            {{-- Album Info --}}
                            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                <div class="bg-white/95 backdrop-blur-sm rounded-xl p-4 shadow-lg">
                                    <h3 class="font-serif text-lg text-gray-900 group-hover:text-pink-luxury transition-colors duration-300">
                                        {{ $album->name }}
                                    </h3>
                                    <div class="flex items-center mt-2 text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1.5 text-pink-luxury" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $album->galleries_count }} {{ Str::plural('Photo', $album->galleries_count) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="inline-block p-8 rounded-full mb-6" style="background-color: #fceeee;">
                            <svg class="w-12 h-12 text-pink-luxury/60 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="font-serif text-xl text-gray-900 mb-2">No Albums Yet</h3>
                        <p class="text-gray-500">We are curating new collections for you.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($albums->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $albums->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
