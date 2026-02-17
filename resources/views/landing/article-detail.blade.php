@extends('layouts.landing')

@section('title', $article->title)

@section('content')
    {{-- Auth Modal for Guest Actions --}}
    <div x-data="{ open: false }" 
         x-on:login-required.window="open = true"
         x-show="open" 
         class="fixed inset-0 z-[100] flex items-center justify-center px-4" 
         style="display: none;">
        
        {{-- Backdrop --}}
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

        {{-- Modal Panel --}}
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full relative z-10 text-center transform transition-all">
            
            <div class="mb-4">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-pink-soft">
                    <svg class="h-6 w-6 text-pink-luxury" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            
            <h3 class="text-lg font-serif font-medium text-gray-900 mb-2">Login Required</h3>
            <p class="text-sm text-gray-500 mb-6">Please sign in to like or comment on this article.</p>
            
            <div class="flex flex-col space-y-3">
                <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition">
                    Sign In
                </a>
                <button @click="open = false" class="text-sm text-gray-500 hover:text-gray-900 transition">
                    Maybe later
                </button>
            </div>
        </div>
    </div>

    {{-- Article Header --}}
    <article class="pt-10 pb-20 bg-white">
        <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12">
            @if($article->category)
                <a href="{{ route('landing.articles', ['category' => $article->category->id]) }}" class="inline-block px-3 py-1 mb-6 text-xs font-bold tracking-widest text-pink-luxury uppercase bg-pink-soft rounded-full hover:bg-pink-200 transition">
                    {{ $article->category->name }}
                </a>
            @endif
            
            <h1 class="font-serif text-3xl md:text-5xl text-gray-900 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            <div class="flex items-center justify-center text-sm text-gray-500 space-x-6">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $article->created_at->format('M d, Y') }}
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

            {{-- Engagement Section --}}
            <div class="border-t border-b border-gray-100 py-8 mb-16 flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    {{-- Like Button --}}
                    <form action="{{ route('landing.articles.like', $article) }}" method="POST" 
                          @guest @submit.prevent="$dispatch('login-required')" @endguest>
                        @csrf
                        <button type="submit" class="group flex items-center space-x-2 focus:outline-none transition-colors {{ $article->isLikedBy(auth()->user()) ? 'text-pink-500' : 'text-gray-500 hover:text-pink-500' }}">
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

                {{-- Share / Back --}}
                <a href="{{ route('landing.articles') }}" class="text-sm uppercase tracking-wider font-medium text-gray-500 hover:text-gray-900 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Articles
                </a>
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
                            <p class="text-gray-500 mb-4">Join the conversation by signing in.</p>
                            <button @click="$dispatch('login-required')" class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-full hover:bg-white hover:border-gray-400 transition bg-white">
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
                                <div class="text-sm text-gray-600 leading-relaxed">
                                    {{ $comment->content }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-8 italic">
                            No comments yet. Be the first to share your thoughts!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </article>
@endsection
