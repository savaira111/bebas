<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Pengguna Terhapus
        </h2>
    </x-slot>

    <div class="py-12" style="background-color:#F0E8D5; min-height:100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tombol Kembali -->
            <a href="{{ route('superadmin.users.index') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Kembali
            </a>

            <!-- Form Pencarian -->
            <form method="GET" class="flex gap-2 mt-4 mb-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari username atau email..."
                       class="flex-1 px-3 py-2 rounded-lg bg-[#2a3155] text-white placeholder-gray-300 border border-transparent focus:border-[#3b4470] outline-none">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Cari
                </button>
            </form>

            <div class="bg-[#212844] text-white rounded-xl p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-2">No</th>
                            <th class="text-left py-2">Username</th>
                            <th class="text-left py-2">Email</th>
                            <th class="text-left py-2">Role</th>
                            <th class="text-left py-2">Dihapus Pada</th>
                            <th class="text-left py-2">Auto Hapus Dalam</th>
                            <th class="text-left py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)

                            {{-- Superadmin tidak ditampilkan --}}
                            @if($user->role === 'superadmin')
                                @continue
                            @endif

                            @php
                                $expiresAt = $user->deleted_at->copy()->addDays(7);
                                $remaining = now()->lt($expiresAt)
                                    ? $expiresAt->diff(now())
                                    : null;
                            @endphp

                            <tr class="border-b border-gray-700 hover:bg-[#2a3155] transition">
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">{{ $user->username }}</td>
                                <td class="py-2">{{ $user->email }}</td>

                                <td class="py-2">
                                    @if($user->role === 'admin')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-400 text-black">
                                            Admin
                                        </span>
                                    @elseif($user->role === 'user')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">
                                            User
                                        </span>
                                    @endif
                                </td>

                                <td class="py-2">
                                    {{ $user->deleted_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                </td>

                                <td class="py-2 text-sm">
                                    @if($remaining)
                                        <span class="text-green-400 font-semibold">
                                            {{ $remaining->d }} hari
                                            {{ $remaining->h }} jam
                                            {{ $remaining->i }} menit
                                        </span>
                                        <div class="text-xs text-gray-400">
                                            Auto hapus:
                                            {{ $expiresAt->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </div>
                                    @else
                                        <span class="text-red-400 font-semibold">
                                            Kedaluwarsa
                                        </span>
                                    @endif
                                </td>

                                <td class="py-2 flex gap-2">
                                    <!-- Restore -->
                                    <button
                                        onclick="confirmRestore('{{ route('superadmin.users.restore', $user->id) }}')"
                                        class="px-3 py-1 bg-yellow-500 text-black rounded-lg hover:bg-yellow-600 transition">
                                        Pulihkan
                                    </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-300">
                                    Tempat sampah kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmRestore(route) {
            Swal.fire({
                title: 'Pulihkan pengguna?',
                text: 'Pengguna ini akan dikembalikan ke sistem.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, pulihkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = route;
                    form.method = 'POST';

                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    `;

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmDelete(route) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Pengguna ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = route;
                    form.method = 'POST';

                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
