<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white">Tempat Sampah</h2>
    </x-slot>

    <div class="py-10 bg-[#F0E8D5] min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">

            <form method="GET" class="flex gap-2">
                <select name="type" class="px-3 py-2 rounded bg-[#2a3155] text-white">
                    <option value="">Semua</option>
                    <option value="users">Users</option>
                    <option value="articles">Articles</option>
                    <option value="albums">Albums</option>
                    <option value="galleries">Galleries</option>
                    <option value="categories">Categories</option>
                </select>

                <button class="px-4 py-2 bg-blue-600 text-white rounded">
                    Filter
                </button>
            </form>

            <div class="bg-[#212844] text-white rounded-xl p-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th>Nama / Judul</th>
                            <th>Jenis</th>
                            <th>Dihapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($items as $item)
                            <tr class="border-b border-gray-700">
                                <td>
                                    {{ $item->name ?? $item->title ?? '-' }}
                                </td>

                                <td>
                                    {{ strtolower(class_basename($item)) }}
                                </td>

                                <td>
                                    {{ $item->deleted_at->format('d M Y H:i') }}
                                </td>

                                <td class="flex gap-2 py-2">
                                    <form method="POST"
                                          action="{{ route('superadmin.users.trash.restore', $item->id) }}">
                                        @csrf
                                        <input type="hidden" name="type"
                                               value="{{ strtolower(class_basename($item)) }}">
                                        <button class="bg-yellow-500 px-3 py-1 rounded">
                                            Restore
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('superadmin.users.trash.forceDelete', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="type"
                                               value="{{ strtolower(class_basename($item)) }}">
                                        <button class="bg-red-600 px-3 py-1 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    Sampah kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
