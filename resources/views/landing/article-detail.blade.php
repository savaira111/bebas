@extends('layouts.landing')

@section('title', $article->title)

@section('content')
    <article class="pt-10 pb-20 bg-white">
        {{-- Top Navigation / Back Button --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-8" data-aos="fade-right">
             <a href="{{ route('landing.articles') }}" class="group inline-flex items-center text-gray-500 hover:text-pink-luxury transition-colors">
                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="text-xs uppercase tracking-widest font-medium">Back to Articles</span>
            </a>
        </div>

        <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12">
            @if($article->category)
                <a href="{{ route('landing.articles', ['category' => $article->category->id]) }}" class="inline-block px-3 py-1 mb-6 text-xs font-bold tracking-widest text-pink-luxury uppercase bg-pink-soft rounded-full hover:bg-pink-200 transition">
                    {{ $article->category->name }}
                </a>
            @endif
            
            <h1 class="font-serif text-3xl md:text-5xl text-gray-900 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            <div class="flex items-center justify-center text-sm text-gray-500 space-x-6" data-aos="fade-up">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $article->created_at->format('M d, Y') }}
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ $article->user->name ?? 'Author' }}
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    {{ number_format($article->views) }} Views
                </span>
            </div>
        </header>

        {{-- Featured Image --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-16" data-aos="fade-up">
            <div class="aspect-video rounded-2xl overflow-hidden shadow-lg bg-gray-100">
                @if($article->image)
                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                @endif
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Content --}}
            <div class="prose prose-lg prose-pink mx-auto text-gray-600 mb-16 leading-relaxed font-light">
                {!! $article->content !!}
            </div>

            {{-- Reviewer Note for Author --}}
            @auth
                @if($article->user_id == auth()->id() && $article->status != 'published' && $article->reviewer_note)
                    <div class="mb-16 bg-red-50 border-l-4 border-red-400 p-6 rounded-r-2xl shadow-sm animate-pulse-slow">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-red-700 uppercase tracking-widest mb-2">Feedback Peninjau:</h4>
                                <p class="text-red-600 italic leading-relaxed">"{{ $article->reviewer_note }}"</p>
                                <div class="mt-4">
                                    <a href="{{ route('user.articles.edit', $article) }}" class="text-xs font-bold text-red-700 hover:text-red-800 uppercase tracking-widest border-b border-red-200 pb-1">Revise Article →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Engagement Section --}}
            <div class="border-t border-b border-gray-100 py-8 mb-16 flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    {{-- Like Button --}}
                    <form id="likeform" action="{{ route('landing.articles.like', $article) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                @guest onclick="handleLike(event)" @endguest
                                class="group flex items-center space-x-2 focus:outline-none transition-colors {{ $article->isLikedBy(auth()->user()) ? 'text-pink-500' : 'text-gray-500 hover:text-pink-500' }}">
                            <div class="p-2 rounded-full group-hover:bg-pink-50 transition-colors {{ $article->isLikedBy(auth()->user()) ? 'bg-pink-50' : '' }}">
                                <svg class="w-6 h-6 {{ $article->isLikedBy(auth()->user()) ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <span class="font-medium text-lg">{{ $article->likes_count }}</span>
                        </button>
                    </form>

                    {{-- Comment Indicator --}}
                    <div class="flex items-center space-x-2 text-gray-500">
                        <div class="p-2">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <span class="font-medium text-lg">{{ $article->comments_count }}</span>
                    </div>
                </div>

                {{-- Share --}}
                <div class="flex items-center space-x-4">
                    {{-- Could add share buttons here if needed --}}
                </div>
            </div>

            {{-- Comments Section --}}
            <div id="comments" class="scroll-mt-24">
                <h3 class="font-serif text-2xl text-gray-900 mb-8">Comments ({{ $article->comments_count }})</h3>

                {{-- Comment Form --}}
                <div class="mb-12 bg-gray-50 p-6 rounded-2xl">
                    @auth
                        <form action="{{ route('landing.articles.comment', $article) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="sr-only">Leave a comment</label>
                                <textarea name="content" id="content" rows="3" class="w-full border-gray-200 rounded-xl focus:ring-pink-luxury focus:border-pink-luxury bg-white placeholder-gray-400 resize-none" placeholder="Share your thoughts..."></textarea>
                                @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-gray-900 text-white text-sm font-medium rounded-full hover:bg-pink-luxury transition shadow-lg transform hover:-translate-y-0.5">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500 mb-4 font-light">Join the conversation by signing in.</p>
                            <button onclick="handleComment()" class="px-8 py-2 border border-gray-300 text-gray-700 text-xs font-bold uppercase tracking-widest rounded-full hover:bg-white hover:border-gray-400 transition bg-white shadow-sm">
                                Sign In to Comment
                            </button>
                        </div>
                    @endauth
                </div>

                {{-- Comment List --}}
                <div class="space-y-8">
                    @forelse($article->comments as $comment)
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                @if($comment->user->avatar)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($comment->user->avatar) }}" alt="{{ $comment->user->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-pink-soft flex items-center justify-center text-pink-luxury font-bold text-sm">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-sm font-bold text-gray-900">{{ $comment->user->name }}</h4>
                                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-sm text-gray-600 leading-relaxed font-light">
                                    {{ $comment->content }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-8 italic font-light">
                            No comments yet. Be the first to share your thoughts!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </article>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function handleLike(e) {
            e.preventDefault();
            Swal.fire({
                title: '<span class="font-serif text-2xl text-gray-900">Login Required</span>',
                html: '<p class="text-gray-500 font-light mt-2">Sila log masuk terlebih dahulu untuk menyukai artikel ini.</p>',
                confirmButtonText: 'LOGIN SEKARANG',
                confirmButtonColor: '#111827',
                background: '#ffffff',
                color: '#374151',
                showCancelButton: true,
                cancelButtonText: 'BATAL',
                cancelButtonColor: '#9ca3af',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'px-6 py-3 bg-gray-900 text-white text-xs uppercase tracking-widest font-bold rounded-sm hover:bg-pink-luxury transition-colors mr-2',
                    cancelButton: 'px-6 py-3 bg-gray-200 text-gray-600 text-xs uppercase tracking-widest font-bold rounded-sm hover:bg-gray-300 transition-colors',
                    popup: 'rounded-lg shadow-xl border-t-4 border-pink-luxury'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const currentUrl = window.location.href;
                    window.location.href = "{{ route('login') }}?return_url=" + encodeURIComponent(currentUrl);
                }
            });
        }

        function handleComment() {
             Swal.fire({
                title: '<span class="font-serif text-2xl text-gray-900">Login Required</span>',
                html: '<p class="text-gray-500 font-light mt-2">Sila log masuk terlebih dahulu untuk memberikan komen.</p>',
                confirmButtonText: 'LOGIN SEKARANG',
                confirmButtonColor: '#111827',
                background: '#ffffff',
                color: '#374151',
                showCancelButton: true,
                cancelButtonText: 'BATAL',
                cancelButtonColor: '#9ca3af',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'px-6 py-3 bg-gray-900 text-white text-xs uppercase tracking-widest font-bold rounded-sm hover:bg-pink-luxury transition-colors mr-2',
                    cancelButton: 'px-6 py-3 bg-gray-200 text-gray-600 text-xs uppercase tracking-widest font-bold rounded-sm hover:bg-gray-300 transition-colors',
                    popup: 'rounded-lg shadow-xl border-t-4 border-pink-luxury'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const currentUrl = window.location.href;
                    window.location.href = "{{ route('login') }}?return_url=" + encodeURIComponent(currentUrl);
                }
            });
        }
    </script>
@endsection
