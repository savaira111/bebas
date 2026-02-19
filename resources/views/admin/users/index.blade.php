<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="px-6 py-2.5 rounded-full text-white font-medium tracking-wide shadow-lg transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                + Add User
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- Search and Filter -->
        <div class="mb-8 relative max-w-4xl mx-auto md:mx-0 flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                 <form action="{{ route('admin.users.index') }}" method="GET" class="w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users by name or email..." class="w-full pl-12 pr-4 py-3 rounded-full border-gray-200 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm bg-white" style="color: #666;">
                    <button type="submit" class="absolute left-4 top-3.5 text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                </form>
            </div>
            
             <div class="flex gap-2">
                 <a href="{{ route('admin.users.trashed') }}" class="px-6 py-3 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Trash
                </a>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left font-bold tracking-wide luxury-table-head">
                            <th class="px-8 py-5 uppercase text-xs">No</th>
                            <th class="px-8 py-5 uppercase text-xs">User</th>
                            <th class="px-8 py-5 uppercase text-xs">Role</th>
                            <th class="px-8 py-5 uppercase text-xs">Email Verified</th>
                            <th class="px-8 py-5 uppercase text-xs">Registered</th>
                            <th class="px-8 py-5 text-right uppercase text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-pink-50/30 transition duration-150">
                                <td class="px-8 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-8 py-4">
                                     <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-500 font-bold mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    @if($user->role === 'admin')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Admin
                                        </span>
                                    @elseif($user->role === 'superadmin')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gold-100 text-yellow-800" style="background-color: #fff8e1; color: #bfa05f;">
                                            Super Admin
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-4">
                                    @if($user->email_verified_at)
                                        <span class="text-green-500 text-sm flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Verified
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">Pending</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-500">
                                    {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-gray-400 hover:text-red-400 transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        @if(auth()->id() !== $user->id)
                                            <button onclick="confirmDelete('{{ $user->id }}')" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-10 text-center text-gray-400 italic">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                {{ $users->appends(request()->query())->links() }}
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
                confirmButtonText: 'Ya, hapus pengguna!',
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
