<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Manajemen Pengguna
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#F0E8D5] to-[#E0D8C0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- SweetAlert Sukses -->
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

            <!-- Pencarian + Filter -->
            <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari username atau role..."
                       class="px-3 py-2 rounded border border-gray-500 bg-[#2a3155] text-white focus:outline-none flex-1">

                <select name="role"
                        class="px-3 py-2 rounded border border-gray-500 bg-[#2a3155] text-white focus:outline-none">
                    <option value="all" {{ request('role')=='all' ? 'selected' : '' }}>Semua Role</option>
                    <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ request('role')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                    Terapkan
                </button>
            </form>

            <!-- Tombol Tambah User -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('superadmin.users.create') }}" 
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
                    + Tambah User
                </a>
            </div>

            <!-- Tabel User -->
            <div class="bg-[#212844] shadow-lg sm:rounded-lg p-4 overflow-x-auto mt-4">
                <table class="min-w-full divide-y divide-gray-600 text-sm">
                    <thead class="bg-[#2a3155]">
                        <tr>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">No</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Profil</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Username</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Nama</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Email</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Role</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Dibuat Pada</th>
                            <th class="px-3 py-2 text-left text-gray-200 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-600">
                        @forelse($users as $user)

                            {{-- Sembunyikan superadmin --}}
                            @if($user->role === 'superadmin')
                                @continue
                            @endif

                            <tr class="hover:bg-[#1a1f33] transition">
                                <td class="px-3 py-2 text-white">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- FOTO PROFIL / INISIAL -->
                                <td class="px-3 py-2">
                                    @if(!empty($user->profile_photo_path))
                                        <img src="{{ Storage::url($user->profile_photo_path) }}"
                                             alt="Profil" class="h-10 w-10 rounded-full object-cover border border-white">
                                    @else
                                        <div class="h-10 w-10 rounded-full flex items-center justify-center bg-gray-600 text-white font-bold border border-white">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-white">{{ $user->username ?? '-' }}</td>
                                <td class="px-3 py-2 text-white">{{ $user->name }}</td>
                                <td class="px-3 py-2 text-white">{{ $user->email }}</td>

                                <td class="px-3 py-2">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $user->role == 'admin' ? 'bg-yellow-500 text-black' : 'bg-green-500 text-white' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <!-- Dibuat Pada -->
                                <td class="px-3 py-2 text-gray-200">
                                    {{ $user->created_at
                                        ? $user->created_at->timezone(config('app.timezone'))->format('d M Y, H:i') . ' WIB'
                                        : '-' }}
                                </td>

                                <!-- Aksi -->
                                <td class="px-3 py-2 flex gap-2">
                                    <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <button onclick="deleteUser({{ $user->id }})"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-300">
                                    Tidak ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- SweetAlert Hapus -->
    <script>
        function deleteUser(id) {
            Swal.fire({
                title: 'Pindahkan ke Sampah?',
                text: "User ini akan dipindahkan ke tempat sampah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = `/superadmin/users/${id}`;
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
