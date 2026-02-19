<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('Trashed E-Books') }}
            </h2>
            <a href="{{ route('ebooks.index') }}" class="px-6 py-2.5 rounded-full text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 font-medium transition shadow-sm">
                &larr; Back to E-Books
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold tracking-wide" style="color: #a08080; background-color: #faf9f9;">
                                <th class="px-8 py-5 uppercase text-xs">No</th>
                                <th class="px-8 py-5 uppercase text-xs">Cover</th>
                                <th class="px-8 py-5 uppercase text-xs">Title</th>
                                <th class="px-8 py-5 uppercase text-xs">Category</th>
                                <th class="px-8 py-5 uppercase text-xs">Deleted At</th>
                                <th class="px-8 py-5 text-right uppercase text-xs">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($ebooks as $ebook)
                                <tr class="hover:bg-pink-50/30 transition duration-150">
                                    <td class="px-8 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-8 py-4">
                                        @if($ebook->cover)
                                            <img src="{{ Storage::url($ebook->cover) }}" class="h-16 w-12 rounded-md object-cover shadow-sm bg-gray-100">
                                        @else
                                            <div class="h-16 w-12 rounded-md bg-gray-100 flex items-center justify-center text-gray-300 text-xs text-center p-1">
                                                No Cover
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4">
                                        <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">{{ $ebook->title }}</div>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-50 text-indigo-400">
                                            {{ $ebook->category }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        {{ $ebook->deleted_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-8 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            <form action="{{ route('ebooks.restore', $ebook->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-500 hover:text-green-700 transition" title="Restore">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </button>
                                            </form>
                                            
                                            <button onclick="confirmForceDelete({{ $ebook->id }})" class="text-red-400 hover:text-red-700 transition" title="Delete Permanently">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="force-delete-form-{{ $ebook->id }}" action="{{ route('ebooks.forceDelete', $ebook->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-10 text-center text-gray-400 italic">
                                        No trashed ebooks found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                    {{ $ebooks->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmForceDelete(id) {
            Swal.fire({
                title: 'Hapus Permanen?',
                text: "Tindakan ini TIDAK DAPAT dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'text-white px-4 py-2 rounded-lg',
                    cancelButton: 'text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('force-delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
</x-app-layout>
