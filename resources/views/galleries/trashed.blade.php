<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('Trashed Galleries') }}
            </h2>
            <a href="{{ route('galleries.index') }}" class="px-6 py-2.5 rounded-full text-gray-600 font-medium tracking-wide border border-gray-300 hover:bg-gray-50 transition">
                &larr; Back to Galleries
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left font-bold tracking-wide bg-gray-50 border-b border-gray-100">
                            <th class="px-8 py-5 uppercase text-xs text-gray-500">No</th>
                            <th class="px-8 py-5 uppercase text-xs text-gray-500">Image</th>
                            <th class="px-8 py-5 uppercase text-xs text-gray-500">Title</th>
                            <th class="px-8 py-5 uppercase text-xs text-gray-500">Deleted At</th>
                            <th class="px-8 py-5 text-right uppercase text-xs text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($galleries as $gallery)
                            <tr class="hover:bg-pink-50/30 transition duration-150">
                                <td class="px-8 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-8 py-4">
                                     @if($gallery->image)
                                        <img class="h-16 w-16 rounded-lg object-cover shadow-sm grayscale opacity-70" src="{{ asset('storage/' . $gallery->image) }}" alt="">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-4">
                                     <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">{{ $gallery->title }}</div>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-500">
                                    {{ $gallery->deleted_at ? $gallery->deleted_at->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-8 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button onclick="confirmRestore('{{ $gallery->id }}')" class="text-yellow-600 hover:text-yellow-700 transition font-medium flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Restore
                                        </button>
                                        <form id="restore-form-{{ $gallery->id }}" action="{{ route('galleries.restore', $gallery->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('POST')
                                        </form>

                                        <button onclick="confirmForceDelete('{{ $gallery->id }}')" class="text-red-400 hover:text-red-600 transition font-medium flex items-center gap-1 ml-4">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Delete Permanently
                                        </button>
                                        <form id="force-delete-form-{{ $gallery->id }}" action="{{ route('galleries.forceDelete', $gallery->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                    No deleted galleries found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmRestore(id) {
            Swal.fire({
                title: 'Pulihkan Gambar?',
                text: "Gambar akan dikembalikan ke galeri.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#bfa05f',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, pulihkan!',
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
                    document.getElementById('restore-form-' + id).submit();
                }
            })
        }

        function confirmForceDelete(id) {
             Swal.fire({
                title: 'Hapus Permanen?',
                text: "Tindakan ini TIDAK DAPAT dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, hapus selamanya!',
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
                    document.getElementById('force-delete-form-' + id).submit();
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
