<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Manajemen Pengguna
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded shadow">
                    {{ session('error') }}
                </div>
            @endif

            <!-- SEARCH + FILTER -->
            <form method="GET" class="flex gap-2 flex-1">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari username atau role..."
                       class="flex-1 px-4 py-2 rounded-lg bg-[#2a3155] text-white placeholder-gray-300 text-sm outline-none border border-transparent focus:border-[#3b4470]">

                <select name="role"
                        class="px-4 py-2 rounded-lg bg-[#2a3155] text-white text-sm border border-transparent focus:border-[#3b4470]">
                    <option value="" class="text-gray-700">Semua Role</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>

                <button class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                    Terapkan
                </button>
            </form>

            <!-- ADD USER BUTTON -->
            @if(Auth::user()->role === 'admin')
                <div class="flex justify-end">
                    <a href="{{ route('admin.users.create') }}"
                       class="px-4 py-2 bg-[#212844] text-white rounded-xl hover:bg-[#1a1f3b] transition shadow-md whitespace-nowrap">
                       + Tambah Pengguna
                    </a>
                </div>
            @endif

            <!-- TABLE -->
            <div class="bg-[#212844] shadow-xl rounded-2xl overflow-x-auto mt-2">
                <table class="min-w-full divide-y divide-gray-700 text-sm">
                    <thead class="bg-[#1a1f3b]">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">No</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Profil</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Username</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Nama</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Email</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Role</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-[#2a3155] transition">
                                <td class="px-3 py-2 text-white">
                                    {{ $loop->iteration }}
                                </td>
                                
                                <!-- PROFILE PHOTO OR INITIAL -->
                                <td class="px-3 py-2">
                                    @if($user->profile_photo_url)
                                        <img src="{{ $user->profile_photo_url }}"
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
                                        {{ $user->role == 'superadmin'
                                            ? 'bg-red-600 text-white'
                                            : ($user->role == 'admin'
                                                ? 'bg-yellow-500 text-black'
                                                : 'bg-green-500 text-white') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 flex gap-2">
                                    @if($user->role === 'user')
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                               class="px-3 py-1 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition shadow-sm">
                                                Edit
                                            </a>
                                            <button type="button"
                                                    onclick="confirmDelete({{ $user->id }})"
                                                    class="px-3 py-1 bg-red-600 text-white rounded-xl hover:bg-red-700 transition shadow-sm">
                                                Hapus
                                            </button>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 bg-gray-600 text-white rounded-xl text-sm">
                                            Hanya Lihat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-300">
                                    Tidak ada pengguna ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Pengguna ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = `/admin/users/${userId}`;
                    form.method = 'POST';

                    let csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
