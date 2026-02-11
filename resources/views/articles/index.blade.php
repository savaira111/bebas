<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Manajemen Artikel
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
                <a href="{{ route('articles.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
                    + Tambah Artikel
                </a>
            </div>

            <div class="bg-[#212844] shadow-lg sm:rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-600 text-sm">
                    <thead class="bg-[#2a3155]">
                        <tr>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">No</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Image</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Judul</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Status</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Published At</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Views</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Likes</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Dibuat</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-600">
                        @forelse($articles as $article)
                            <tr class="hover:bg-[#1a1f33] transition">
                                <td class="px-3 py-2 text-white">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-3 py-2">
                                    @if($article->image)
                                        <img src="{{ asset('storage/'.$article->image) }}"
                                             class="h-12 w-12 rounded object-cover border border-white">
                                    @else
                                        <div class="h-12 w-12 flex items-center justify-center bg-gray-600 text-white rounded border border-white">
                                            —
                                        </div>
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-white font-semibold">
                                    {{ $article->title }}
                                </td>

                                <td class="px-3 py-2">
                                    @if($article->status === 'publish')
                                        <span class="px-2 py-1 rounded text-xs font-semibold bg-green-600 text-white">
                                            PUBLISH
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs font-semibold bg-yellow-500 text-white">
                                            DRAFT
                                        </span>
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-gray-200 text-xs">
                                    @if($article->status === 'publish')
                                        {{ $article->updated_at?->format('d M Y H:i:s') }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-white">
                                    {{ $article->views ?? 0 }}
                                </td>

                                <td class="px-3 py-2 text-white">
                                    {{ $article->likes ?? 0 }}
                                </td>

                                <td class="px-3 py-2 text-gray-200">
                                    {{ $article->created_at?->format('d M Y H:i:s') }}
                                </td>

                                <td class="px-3 py-2 flex flex-wrap gap-2">
                                    <a href="{{ route('articles.edit', $article) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    @if($article->status !== 'publish')
                                        <form method="POST" action="{{ route('articles.publish', $article->id) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                Publish
                                            </button>
                                        </form>
                                    @endif

                                    <button onclick="deleteArticle({{ $article->id }})"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-gray-300">
                                    Belum ada artikel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function deleteArticle(id) {
            Swal.fire({
                title: 'Hapus Artikel?',
                text: "Artikel akan masuk ke sampah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = `/articles/${id}`;
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
