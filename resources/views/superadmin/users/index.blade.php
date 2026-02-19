<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('User Management (SuperAdmin)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Filter & Search -->
                <form method="GET" class="flex flex-wrap gap-3 flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search username or role..."
                        class="px-4 py-2 rounded-full border border-gray-200 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm w-full md:w-64 bg-white text-gray-700">

                    <select name="role"
                            class="px-4 py-2 rounded-full border border-gray-200 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm bg-white text-gray-700 cursor-pointer">
                        <option value="all" {{ request('role')=='all' ? 'selected' : '' }}>All Roles</option>
                        <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                    </select>

                    <button type="submit"
                            class="px-6 py-2 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm font-medium">
                        Filter
                    </button>
                    <!-- Clear button removed as requested -->
                </form>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                     <a href="{{ route('superadmin.users.trash.index', ['type' => 'users']) }}" 
                       class="px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm font-medium flex items-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Trash
                    </a>
                    <a href="{{ route('superadmin.users.create') }}" 
                       class="px-6 py-2.5 rounded-full text-white font-medium shadow-lg transform transition hover:-translate-y-0.5"
                       style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                        + Add User
                    </a>
                </div>
            </div>

            <!-- Tabel User -->
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold tracking-wide luxury-table-head bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">No</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Profile</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Username</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Name</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Email</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Role</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Created At</th>
                                <th class="px-8 py-5 text-right uppercase text-xs text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                @if($user->role === 'superadmin')
                                    @continue
                                @endif
                                <tr class="hover:bg-pink-50/30 transition duration-150">
                                    <td class="px-8 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                    
                                    <!-- FOTO PROFIL / INISIAL -->
                                    <td class="px-8 py-4">
                                        @if(!empty($user->profile_photo_path))
                                            <img src="{{ Storage::url($user->profile_photo_path) }}"
                                                 alt="Profil" class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">
                                        @else
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center bg-gray-100 text-gray-400 font-bold border border-gray-200">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-8 py-4 text-gray-700 font-medium">{{ $user->username ?? '-' }}</td>
                                    <td class="px-8 py-4">
                                         <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-500">{{ $user->email }}</td>

                                    <td class="px-8 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold tracking-wide
                                            {{ $user->role == 'admin' ? 'bg-orange-100 text-orange-600' : ($user->role == 'superadmin' ? 'bg-purple-100 text-purple-600' : 'bg-green-100 text-green-600') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </td>

                                    <td class="px-8 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('superadmin.users.edit', $user->id) }}" class="text-gray-400 hover:text-yellow-600 transition" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            @if($user->role !== 'superadmin' && $user->id !== auth()->id())
                                                <button onclick="confirmDelete({{ $user->id }})" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-8 py-10 text-center text-gray-400 italic">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pengguna akan dipindahkan ke sampah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, hapus!',
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
                    document.getElementById('delete-form-' + id).submit();
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
