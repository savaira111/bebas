<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
             <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Search -->
                <div class="w-full md:w-1/3 relative">
                     <form method="GET">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Find an article..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm bg-white text-gray-700">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                     <a href="{{ route('articles.trashed') }}" 
                       class="px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm font-medium flex items-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Trash
                    </a>
                    <a href="{{ route('articles.create') }}" 
                       class="px-6 py-2.5 rounded-full text-white font-medium shadow-lg transform transition hover:-translate-y-0.5"
                       style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                        + Write Article
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold tracking-wide luxury-table-head bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Title</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Category</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Status</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Publish Date</th>
                                <th class="px-8 py-5 text-right uppercase text-xs text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($articles as $article)
                                <tr class="hover:bg-pink-50/30 transition duration-150">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            @if($article->image)
                                                <img src="{{ Storage::url($article->image) }}" class="h-10 w-10 rounded-lg object-cover border border-gray-100 shadow-sm">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs font-bold">PDF</div>
                                            @endif
                                            <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">
                                                {{ Str::limit($article->title, 40) }}
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        {{ $article->category->name ?? '-' }}
                                    </td>

                                    <td class="px-8 py-4">
                                        @if($article->status == 'publish' || $article->status == 'published')
                                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                Published
                                            </span>
                                        @else
                                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        @if($article->published_at)
                                            {{ $article->published_at->format('d F Y, H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-8 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            
                                            <!-- Publish Button -->
                                            @if($article->status != 'publish' && $article->status != 'published')
                                                 <form action="{{ route('articles.publish', $article->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-[#bfa05f] hover:text-[#a08040] transition font-medium flex items-center gap-1 text-xs uppercase tracking-wide border border-[#bfa05f] px-3 py-1 rounded-full hover:bg-[#bfa05f] hover:text-white">
                                                         Publish
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('articles.edit', $article->id) }}" class="text-gray-400 hover:text-yellow-600 transition" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <button onclick="confirmDelete({{ $article->id }})" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="delete-form-{{ $article->id }}" action="{{ route('articles.destroy', $article->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                        No articles found. Start writing one!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                    {{ $articles->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "The article will be moved to trash.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'text-white px-4 py-2 rounded-lg',
                    cancelButton: 'text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
</x-app-layout>
