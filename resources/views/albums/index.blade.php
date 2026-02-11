<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Manajemen Album
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#F0E8D5] to-[#E0D8C0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: "{{ session('success') }}",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    });
                </script>
            @endif

            <div class="flex justify-end mb-4">
                <a href="{{ route('albums.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
                    + Tambah Album
                </a>
            </div>

            <div class="bg-[#212844] shadow-lg sm:rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-600 text-sm">
                    <thead class="bg-[#2a3155]">
                        <tr>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">No</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Cover</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Nama Album</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Deskripsi</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Jumlah Foto</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Dibuat</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-600">
                        @forelse($albums as $album)
                            <tr class="hover:bg-[#1a1f33] transition">
                                <td class="px-3 py-2 text-white">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-3 py-2">
                                    @if($album->cover_image)
                                        <img src="{{ asset('storage/'.$album->cover_image) }}"
                                             class="h-12 w-12 rounded object-cover border border-white">
                                    @else
                                        <div class="h-12 w-12 flex items-center justify-center bg-gray-600 text-white rounded border border-white">
                                            —
                                        </div>
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-white font-semibold">
                                    {{ $album->name }}
                                </td>

                                <td class="px-3 py-2 text-gray-300">
                                    {{ \Illuminate\Support\Str::limit($album->description, 50) ?? '-' }}
                                </td>

                                <td class="px-3 py-2 text-white">
                                    {{ $album->photos->count() }}
                                </td>

                                <td class="px-3 py-2 text-gray-200">
                                    {{ $album->created_at ? $album->created_at->format('d M Y') : '-' }}
                                </td>

                                <td class="px-3 py-2 flex flex-wrap gap-2">
                                    <a href="{{ route('albums.show', $album) }}"
                                       class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                        Buka Album
                                    </a>

                                    {{-- ✅ TAMBAH GALLERY KE HALAMAN CREATE --}}
                                    <a href="{{ route('galleries.create', ['album_id' => $album->id]) }}"
                                       class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        + Tambah Gallery
                                    </a>

                                    <a href="{{ route('albums.edit', $album) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <button onclick="deleteAlbum({{ $album->id }})"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-300">
                                    Belum ada album.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function deleteAlbum(id) {
            Swal.fire({
                title: 'Hapus Album?',
                text: "Album dan semua fotonya akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = `/albums/${id}`;
                    form.method = 'POST';
                    form.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>
