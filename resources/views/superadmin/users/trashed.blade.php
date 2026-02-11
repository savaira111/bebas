<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Data Terhapus
        </h2>
    </x-slot>

    <div class="py-12" style="background-color:#F0E8D5; min-height:100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <a href="{{ route('superadmin.users.index') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Kembali
            </a>

            <form method="GET" class="flex flex-wrap gap-2 mt-4 mb-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari data..."
                       class="flex-1 px-3 py-2 rounded-lg bg-[#2a3155] text-white placeholder-gray-300 border border-transparent focus:border-[#3b4470] outline-none">

                <select name="type"
                        class="px-3 py-2 rounded-lg bg-[#2a3155] text-white border border-transparent focus:border-[#3b4470] outline-none">
                    <option value="">Semua Jenis</option>
                    <option value="users" {{ request('type') === 'users' ? 'selected' : '' }}>User Management</option>
                    <option value="articles" {{ request('type') === 'articles' ? 'selected' : '' }}>Artikel</option>
                    <option value="albums" {{ request('type') === 'albums' ? 'selected' : '' }}>Album</option>
                    <option value="galleries" {{ request('type') === 'galleries' ? 'selected' : '' }}>Galleries</option>
                    <option value="categories" {{ request('type') === 'categories' ? 'selected' : '' }}>Categories</option>
                </select>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Terapkan
                </button>
            </form>

            <div class="bg-[#212844] text-white rounded-xl p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-2">No</th>
                            <th class="text-left py-2">Nama / Judul</th>
                            <th class="text-left py-2">Jenis Data</th>
                            <th class="text-left py-2">Dihapus Pada</th>
                            <th class="text-left py-2">Hapus Otomatis Dalam</th>
                            <th class="text-left py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $item)

                            @php
                                $expiresAt = $item->deleted_at->copy()->addDays(7);
                                $remaining = now()->lt($expiresAt)
                                    ? $expiresAt->diff(now())
                                    : null;

                                $label = class_basename($item);
                            @endphp

                            <tr class="border-b border-gray-700 hover:bg-[#2a3155] transition">
                                <td class="py-2">{{ $loop->iteration }}</td>

                                <td class="py-2">
                                    {{ $item->name ?? $item->title ?? $item->username ?? '-' }}
                                </td>

                                <td class="py-2">
                                    <span class="px-3 py-1 text-xs rounded-full bg-indigo-500">
                                        {{ $label }}
                                    </span>
                                </td>

                                <td class="py-2">
                                    {{ $item->deleted_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                </td>

                                <td class="py-2 text-sm">
                                    @if($remaining)
                                        <span class="text-green-400 font-semibold">
                                            {{ $remaining->d }} hari {{ $remaining->h }} jam {{ $remaining->i }} menit
                                        </span>
                                        <div class="text-xs text-gray-400">
                                            Hapus otomatis:
                                            {{ $expiresAt->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </div>
                                    @else
                                        <span class="text-red-400 font-semibold">Kedaluwarsa</span>
                                    @endif
                                </td>

                                <td class="py-2 flex gap-2">
                                    <form method="POST" action="{{ route('superadmin.users.restore', $item->id) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-yellow-500 text-black rounded-lg hover:bg-yellow-600 transition">
                                            Pulihkan
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('superadmin.users.forceDelete', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 rounded-lg hover:bg-red-700 transition">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-300">
                                    Tempat sampah kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
