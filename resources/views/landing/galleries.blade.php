@extends('layouts.landing')

@section('title', 'Portfolio')

@section('content')
    <!-- Header -->
    <div class="bg-gray-50 py-16 text-center">
        <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-3" data-aos="fade-up">Visual Diary</h1>
        <p class="text-gray-500 uppercase tracking-widest text-sm" data-aos="fade-up" data-aos-delay="100">Moments of beauty captured</p>
    </div>

    <!-- Gallery Grid -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($galleries as $gallery)
                    <div class="relative group overflow-hidden h-96 rounded-sm cursor-pointer" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                         @php
                            $coverPhoto = $gallery->photos->first()?->file_path ?? null;
                        @endphp
                        
                        @if($coverPhoto)
                             <img src="{{ Storage::url($coverPhoto) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                             <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                <span class="italic">No Images</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-pink-luxury text-xs uppercase tracking-widest mb-2 transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-75">{{ optional($gallery->category)->name }}</span>
                            <h3 class="text-white font-serif text-2xl transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-100">{{ $gallery->title }}</h3>
                            @if($gallery->description)
                                <p class="text-gray-200 text-sm mt-3 max-w-xs transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-150">{{ Str::limit($gallery->description, 80) }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                     <div class="col-span-full text-center py-20">
                        <div class="inline-block p-6 rounded-full bg-gray-50 mb-4">
                            <svg class="w-8 h-8 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Gallery is empty</h3>
                        <p class="text-gray-500 mt-1">We are curating new content for you.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $galleries->links() }}
            </div>
        </div>
    </section>
@endsection
