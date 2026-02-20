<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('Gallery Management') }}
            </h2>
            <a href="{{ route('galleries.create') }}" class="px-6 py-2.5 rounded-full text-white font-medium tracking-wide shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                + Add Image
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mb-8 relative max-w-4xl mx-auto md:mx-0 flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                 <form action="{{ route('galleries.index') }}" method="GET" class="w-full">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search gallery..." class="w-full pl-12 pr-4 py-3 rounded-full border-gray-200 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm bg-white" style="color: #666;">
                    <button type="submit" class="absolute left-4 top-3.5 text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
            
             <div class="flex gap-2">
                 <a href="{{ route('galleries.trashed') }}" class="px-6 py-3 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Trash
                </a>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left font-bold tracking-wide luxury-table-head">
                            <th class="px-8 py-5 uppercase text-xs">No</th>
                            <th class="px-8 py-5 uppercase text-xs">Image</th>
                            <th class="px-8 py-5 uppercase text-xs">Title</th>
                            <th class="px-8 py-5 uppercase text-xs">Category</th>
                            <th class="px-8 py-5 uppercase text-xs">Created At</th>
                            <th class="px-8 py-5 text-right uppercase text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($galleries as $gallery)
                            <tr class="hover:bg-pink-50/30 transition duration-150">
                                <td class="px-8 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-8 py-4">
                                    <div class="relative inline-block">
                                        @if($gallery->image)
                                            <img class="h-16 w-16 rounded-lg object-cover shadow-sm transition hover:scale-105" src="{{ asset('storage/' . $gallery->image) }}" alt="">
                                        @elseif($gallery->video_url)
                                            <div class="h-16 w-16 rounded-lg bg-gray-900 flex items-center justify-center text-white">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                            </div>
                                        @else
                                            <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        
                                        @if($gallery->type === 'video')
                                            <div class="absolute -bottom-1 -right-1 bg-red-500 text-white rounded-full p-1 shadow-sm">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                     <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">{{ $gallery->title }}</div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-50 text-red-400">
                                        {{ $gallery->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-500">
                                    {{ $gallery->created_at ? $gallery->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('galleries.edit', $gallery->id) }}" class="text-gray-400 hover:text-red-400 transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button onclick="confirmDelete('{{ $gallery->id }}')" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <form id="delete-form-{{ $gallery->id }}" action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-10 text-center text-gray-400 italic">
                                    No images found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                {{ $galleries->appends(['keyword' => request('keyword')])->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Gambar akan dipindahkan ke sampah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'text-white px-4 py-2 rounded-lg',
                    cancelButton: 'text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100'
                },
                background: '#fff',
                color: '#555'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    <style>
        .swal2-title { font-family: 'Playfair Display', serif !important; }
        .swal2-popup { border-radius: 20px !important; }
    </style>
    @endpush
</x-app-layout>
