<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('Album Management') }}
            </h2>
            <a href="{{ route('albums.create') }}" class="px-6 py-2.5 rounded-full text-white font-medium tracking-wide shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                + Create Album
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mb-8 relative max-w-4xl mx-auto md:mx-0 flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <form action="{{ route('albums.index') }}" method="GET" class="w-full">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search albums..." class="w-full pl-12 pr-4 py-3 rounded-full border-gray-200 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm bg-white" style="color: #666;">
                    <button type="submit" class="absolute left-4 top-3.5 text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('albums.trashed') }}" class="px-6 py-3 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Trash
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 px-6 py-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left font-bold tracking-wide luxury-table-head">
                            <th class="px-8 py-5 uppercase text-xs">No</th>
                            <th class="px-8 py-5 uppercase text-xs">Name</th>
                            <th class="px-8 py-5 uppercase text-xs">Description</th>
                            <th class="px-8 py-5 uppercase text-xs">Created At</th>
                            <th class="px-8 py-5 text-right uppercase text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($albums as $album)
                            <tr class="hover:bg-pink-50/30 transition duration-150">
                                <td class="px-8 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-8 py-4">
                                    <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">
                                        {{ $album->name }}
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $album->description ?? '-' }}
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-500">
                                    {{ $album->created_at ? $album->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('albums.show', $album->id) }}" class="text-gray-400 hover:text-blue-400 transition" title="View Photos">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('albums.edit', $album->id) }}" class="text-gray-400 hover:text-red-400 transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        <!-- DELETE BUTTON - PASTI BISA DI KLIK -->
                                        <a href="#" 
                                           onclick="event.preventDefault(); if(confirm('Move album \"{{ $album->name }}\" to trash?')) { document.getElementById('delete-form-{{ $album->id }}').submit(); }"
                                           class="text-gray-400 hover:text-red-600 transition"
                                           title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </a>

                                        <!-- DELETE FORM -->
                                        <form id="delete-form-{{ $album->id }}" 
                                              action="{{ route('albums.destroy', $album->id) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                    No albums found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                {{ $albums->appends(['keyword' => request('keyword')])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>