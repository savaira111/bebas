<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Trash Management (SuperAdmin)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Filter -->
            <form method="GET" class="flex flex-wrap gap-4 bg-white p-4 rounded-3xl shadow-sm border border-gray-100 items-center">
                <label class="text-gray-600 font-medium font-serif">Filter Type:</label>
                <div class="relative">
                    <select name="type" class="appearance-none pl-4 pr-10 py-2 rounded-full border border-gray-200 bg-gray-50 text-gray-600 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm cursor-pointer hover:bg-white">
                        <option value="">All Types</option>
                        <option value="users" {{ request('type')=='users' ? 'selected' : '' }}>Users</option>
                        <option value="articles" {{ request('type')=='articles' ? 'selected' : '' }}>Articles</option>
                        <option value="albums" {{ request('type')=='albums' ? 'selected' : '' }}>Albums</option>
                        <option value="galleries" {{ request('type')=='galleries' ? 'selected' : '' }}>Galleries</option>
                        <option value="categories" {{ request('type')=='categories' ? 'selected' : '' }}>Categories</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <button type="submit" class="px-6 py-2 rounded-full bg-gradient-to-r from-[#d4a5a5] to-[#c29595] text-white font-medium shadow-md hover:shadow-lg transform transition hover:-translate-y-0.5">
                    Apply Filter
                </button>
            </form>

            <!-- Tabel Trash -->
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold tracking-wide luxury-table-head bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Name / Title</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Type</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Deleted At</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Time Remaining</th>
                                <th class="px-8 py-5 text-right uppercase text-xs text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $item)
                                @php
                                    $expiresAt = $item->deleted_at->copy()->addDays(7);
                                    $remaining = now()->lt($expiresAt)
                                        ? $expiresAt->diff(now())
                                        : null;
                                @endphp
                                <tr class="hover:bg-pink-50/30 transition duration-150">
                                    <td class="px-8 py-4">
                                        <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">
                                            {{ $item->name ?? $item->title ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 uppercase tracking-wide">
                                            {{ strtolower(class_basename($item)) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        {{ $item->deleted_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-8 py-4 text-sm">
                                        @if($remaining)
                                            <span class="text-green-600 font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $remaining->d }}d {{ $remaining->h }}h {{ $remaining->i }}m
                                            </span>
                                        @else
                                            <span class="text-red-500 font-bold">Expired</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            <button type="button"
                                                    data-route="{{ route('superadmin.users.trash.restore', $item->id) }}"
                                                    data-type="{{ strtolower(class_basename($item)) }}"
                                                    onclick="confirmAction(this, 'restore')"
                                                    class="text-yellow-600 hover:text-yellow-700 transition font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                Restore
                                            </button>

                                            <button type="button"
                                                    data-route="{{ route('superadmin.users.trash.forceDelete', $item->id) }}"
                                                    data-type="{{ strtolower(class_basename($item)) }}"
                                                    onclick="confirmAction(this, 'delete')"
                                                    class="text-red-400 hover:text-red-600 transition font-medium flex items-center gap-1 ml-4">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                 Forever
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                        Trash is empty.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAction(button, action) {
            const title = action === 'delete' ? 'Delete Permanently?' : 'Restore Item?';
            const text = action === 'delete' ? 'This action CANNOT be undone.' : 'The item will be restored.';
            const method = action === 'delete' ? 'DELETE' : 'POST';
            const confirmBtnColor = action === 'delete' ? '#ef4444' : '#bfa05f';
            const confirmBtnText = action === 'delete' ? 'Yes, delete forever!' : 'Yes, restore!';

            Swal.fire({
                title: title,
                text: text,
                icon: action === 'delete' ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: confirmBtnColor,
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: confirmBtnText,
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'text-white px-4 py-2 rounded-lg',
                    cancelButton: 'text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100'
                },
                background: '#fff',
                color: '#555'
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
    <style>
        .swal2-title { font-family: 'Playfair Display', serif !important; }
        .swal2-popup { border-radius: 20px !important; }
    </style>
    @endpush
</x-app-layout>
