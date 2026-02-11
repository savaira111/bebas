{{-- resources/views/galleries/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Manajemen Galleries
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
                <a href="{{ route('galleries.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
                    + Tambah Gallery
                </a>
            </div>

            <div class="bg-[#212844] shadow-lg sm:rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-600 text-sm">
                    <thead class="bg-[#2a3155]">
                        <tr>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">No</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Judul Gallery</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Jumlah Foto</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Dibuat</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-600">
                        @forelse($galleries as $gallery)
                            <tr class="hover:bg-[#1a1f33] transition">
                                <td class="px-3 py-2 text-white">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-3 py-2 text-white font-semibold">
                                    {{ $gallery->title }}
                                </td>

                                <td class="px-3 py-2 text-white">
                                    {{ $gallery->photos->count() }}
                                </td>

                                <td class="px-3 py-2 text-gray-200">
                                    {{ $gallery->created_at ? $gallery->created_at->format('d M Y') : '-' }}
                                </td>

                                <td class="px-3 py-2 flex flex-wrap gap-2">
                                    <a href="{{ route('galleries.show', $gallery) }}"
                                       class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                        Buka Gallery
                                    </a>

                                    <a href="{{ route('galleries.edit', $gallery) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <button onclick="deleteGallery({{ $gallery->id }})"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-300">
                                    Belum ada gallery.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function deleteGallery(id) {
            Swal.fire({
                title: 'Hapus Gallery?',
                text: "Gallery dan semua fotonya akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = `/galleries/${id}`;
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
