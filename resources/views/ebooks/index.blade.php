<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('E-Book Management') }}
            </h2>
            <div class="flex gap-2">
                 <a href="{{ route('ebooks.trashed') }}" class="px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Trash
                </a>
                <a href="{{ route('ebooks.create') }}" class="px-6 py-2.5 rounded-full text-white font-medium tracking-wide shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                    + Add E-Book
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- Search -->
        <div class="mb-8 relative max-w-md mx-auto md:mx-0">
             <form action="{{ route('ebooks.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search e-books..." class="w-full pl-12 pr-4 py-3 rounded-full border-gray-200 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm bg-white" style="color: #666;">
                    <button type="submit" class="absolute left-4 top-3.5 text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left font-bold tracking-wide luxury-table-head">
                            <th class="px-8 py-5 uppercase text-xs">No</th>
                            <th class="px-8 py-5 uppercase text-xs">Title</th>
                            <th class="px-8 py-5 uppercase text-xs">Author</th>
                            <th class="px-8 py-5 uppercase text-xs">Cover</th>
                            <th class="px-8 py-5 uppercase text-xs">File</th>
                            <th class="px-8 py-5 uppercase text-xs">Created At</th>
                            <th class="px-8 py-5 text-right uppercase text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($ebooks as $ebook)
                            <tr class="hover:bg-pink-50/30 transition duration-150">
                                <td class="px-8 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-8 py-4">
                                     <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">{{ $ebook->title }}</div>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-500">
                                    {{ $ebook->author }}
                                </td>
                                <td class="px-8 py-4">
                                    @if($ebook->cover)
                                        <img class="h-16 w-12 rounded shadow-sm object-cover" src="{{ asset('storage/' . $ebook->cover) }}" alt="">
                                    @else
                                        <div class="h-16 w-12 rounded bg-gray-100 flex items-center justify-center text-gray-300 text-xs">
                                            No Cover
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-4">
                                    <a href="{{ asset('storage/' . $ebook->file) }}" target="_blank" class="text-red-400 hover:text-red-600 underline text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Download
                                    </a>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-500">
                                    {{ $ebook->created_at ? $ebook->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('ebooks.edit', $ebook->id) }}" class="text-gray-400 hover:text-red-400 transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button onclick="confirmDelete('{{ $ebook->id }}')" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <form id="delete-form-{{ $ebook->id }}" action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-10 text-center text-gray-400 italic">
                                    No e-books found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                {{ $ebooks->appends(['keyword' => request('keyword')])->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "The e-book will be deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No',
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
