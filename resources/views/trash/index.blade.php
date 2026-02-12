<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Tempat Sampah
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#F0E8D5] to-[#E0D8C0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- SweetAlert Sukses -->
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
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

            <!-- Filter -->
            <form method="GET" class="flex gap-2">
                <select name="type" class="px-3 py-2 rounded bg-[#2a3155] text-white">
                    <option value="">Semua</option>
                    <option value="users" {{ request('type')=='users' ? 'selected' : '' }}>Users</option>
                    <option value="articles" {{ request('type')=='articles' ? 'selected' : '' }}>Articles</option>
                    <option value="albums" {{ request('type')=='albums' ? 'selected' : '' }}>Albums</option>
                    <option value="galleries" {{ request('type')=='galleries' ? 'selected' : '' }}>Galleries</option>
                    <option value="categories" {{ request('type')=='categories' ? 'selected' : '' }}>Categories</option>
                </select>

                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Filter
                </button>
            </form>

            <!-- Tabel Trash -->
            <div class="bg-[#212844] shadow-lg sm:rounded-lg p-4 overflow-x-auto">
                <table class="w-full text-sm divide-y divide-gray-600">
                    <thead class="bg-[#2a3155]">
                        <tr>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Nama / Judul</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Jenis</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Dihapus</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Sisa Waktu</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-600">
                        @forelse($items as $item)
                            @php
                                $expiresAt = $item->deleted_at->copy()->addDays(7);
                                $remaining = now()->lt($expiresAt)
                                    ? $expiresAt->diff(now())
                                    : null;
                            @endphp
                            <tr class="hover:bg-[#1a1f33] transition">
                                <td class="px-3 py-2 text-white">{{ $item->name ?? $item->title ?? '-' }}</td>
                                <td class="px-3 py-2 text-white">{{ strtolower(class_basename($item)) }}</td>
                                <td class="px-3 py-2 text-gray-200">{{ $item->deleted_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                                <td class="px-3 py-2 text-sm">
                                    @if($remaining)
                                        <span class="text-green-400 font-semibold">
                                            {{ $remaining->d }}j {{ $remaining->h }}h {{ $remaining->i }}m
                                        </span>
                                    @else
                                        <span class="text-red-400 font-semibold">Kedaluwarsa</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 flex gap-2">
                                    <button type="button"
                                            data-route="{{ route('superadmin.users.trash.restore', $item->id) }}"
                                            data-type="{{ strtolower(class_basename($item)) }}"
                                            onclick="confirmAction(this, 'restore')"
                                            class="px-3 py-1 bg-yellow-500 text-black rounded hover:bg-yellow-600 transition">
                                        Restore
                                    </button>

                                    <button type="button"
                                            data-route="{{ route('superadmin.users.trash.forceDelete', $item->id) }}"
                                            data-type="{{ strtolower(class_basename($item)) }}"
                                            onclick="confirmAction(this, 'delete')"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-300">Sampah kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAction(button, action) {
            const title = action === 'delete' ? 'Hapus Permanen?' : 'Pulihkan Data?';
            const text = action === 'delete' ? 'Data akan dihapus selamanya' : 'Data akan dikembalikan';
            const method = action === 'delete' ? 'DELETE' : 'POST';

            Swal.fire({
                title: title,
                text: text,
                icon: action === 'delete' ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = button.dataset.route;
                    form.method = 'POST';
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type" value="${button.dataset.type}">
                        ${method === 'DELETE' ? '<input type="hidden" name="_method" value="DELETE">' : ''}
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
