<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
             <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="w-full md:w-1/2">
                     <form method="GET" class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Find an article..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 focus:border-[#d4a5a5] focus:ring focus:ring-pink-100 transition shadow-sm bg-white text-gray-700">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <div class="relative min-w-[180px]">
                            <select name="author_role" onchange="this.form.submit()" 
                                class="w-full pl-4 pr-10 py-2.5 rounded-full border border-gray-200 focus:border-[#d4a5a5] focus:ring focus:ring-pink-100 transition shadow-sm bg-white text-gray-700 text-sm appearance-none cursor-pointer">
                                <option value="">All Authors</option>
                                <option value="user" {{ request('author_role') === 'user' ? 'selected' : '' }}>Users</option>
                                <option value="admin" {{ request('author_role') === 'admin' ? 'selected' : '' }}>Admins/SuperAdmins</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                     <a href="{{ route('articles.trashed') }}" 
                       class="px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm font-medium flex items-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Trash
                    </a>
                    <a href="{{ route('articles.create') }}" 
                       class="px-6 py-2.5 rounded-full text-white font-medium shadow-lg transform transition hover:-translate-y-0.5"
                       style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                        + Write Article
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold tracking-wide luxury-table-head bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Title</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Author</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Category</th>
                                <th class="px-8 py-5 uppercase text-xs text-gray-500">Status</th>
                                <th class="px-8 py-5 text-right uppercase text-xs text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($articles as $article)
                                <tr class="hover:bg-pink-50/30 transition duration-150" id="article-row-{{ $article->id }}">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            @if($article->image)
                                                <img src="{{ Storage::url($article->image) }}" class="h-10 w-10 rounded-lg object-cover border border-gray-100 shadow-sm">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs font-bold">IMG</div>
                                            @endif
                                            <div class="text-sm font-semibold text-gray-800" style="font-family: 'Playfair Display', serif;">
                                                {{ Str::limit($article->title, 35) }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-500 font-bold text-xs uppercase">
                                                {{ substr($article->user->name ?? 'A', 0, 1) }}
                                            </div>
                                            <div class="text-xs font-medium text-gray-600">
                                                {{ $article->user->name ?? 'Admin' }}
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        {{ $article->category->name ?? '-' }}
                                    </td>

                                    <td class="px-8 py-4">
                                        @switch($article->status)
                                            @case('published')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">Published</span>
                                                @break
                                            @case('pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Pending</span>
                                                @break
                                            @case('rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">Rejected</span>
                                                @break
                                            @default
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">Draft</span>
                                        @endswitch
                                    </td>

                                    <td class="px-8 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            
                                            <!-- Review Button for Pending -->
                                            @if($article->status == 'pending')
                                                 <button onclick="reviewArticle('{{ $article->slug }}', '{{ addslashes($article->title) }}')" class="text-indigo-500 hover:text-indigo-700 transition font-bold flex items-center gap-1 text-[10px] uppercase tracking-widest border border-indigo-200 px-3 py-1 rounded-full hover:bg-indigo-50 bg-white shadow-sm">
                                                      Review
                                                 </button>
                                            @endif

                                            <a href="{{ route('articles.edit', $article) }}" class="text-gray-400 hover:text-yellow-600 transition" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <button onclick="confirmDelete('{{ $article->slug }}')" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="delete-form-{{ $article->slug }}" action="{{ route('articles.destroy', $article) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                        No articles found. Start writing one!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/50">
                    {{ $articles->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function reviewArticle(id, title) {
            Swal.fire({
                title: 'Review Artikel',
                html: `
                    <div class="text-left mb-4">
                        <p class="text-sm text-gray-600 font-medium mb-1">Judul: <span class="text-gray-900">${title}</span></p>
                        <hr class="my-3 border-gray-100">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Komentar / Alasan (Opsional untuk Approve)</label>
                        <textarea id="reviewer_note" class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-100 transition" rows="3" placeholder="Tulis catatan peninjau di sini..."></textarea>
                    </div>
                `,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="fas fa-check mr-2"></i> Approve',
                denyButtonText: '<i class="fas fa-times mr-2"></i> Reject',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#10b981',
                denyButtonColor: '#ef4444',
                customClass: {
                    confirmButton: 'px-6 py-2 rounded-full font-bold uppercase tracking-wider text-xs',
                    denyButton: 'px-6 py-2 rounded-full font-bold uppercase tracking-wider text-xs',
                    cancelButton: 'px-6 py-2 rounded-full font-bold uppercase tracking-wider text-xs'
                },
                preConfirm: () => {
                    return {
                        action: 'approve',
                        reviewer_note: document.getElementById('reviewer_note').value
                    }
                },
                preDeny: () => {
                    const note = document.getElementById('reviewer_note').value;
                    if (!note) {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                        return false;
                    }
                    return {
                        action: 'reject',
                        reviewer_note: note
                    }
                }
            }).then((result) => {
                if (result.isConfirmed || result.isDenied) {
                    const data = result.isConfirmed ? result.value : result.value;
                    const action = result.isConfirmed ? 'approve' : 'reject';
                    
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/articles/${id}/review`;
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    const inputs = [
                        { name: '_token', value: csrfToken },
                        { name: 'action', value: action },
                        { name: 'reviewer_note', value: data.reviewer_note }
                    ];
                    
                    inputs.forEach(input => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = input.name;
                        hiddenInput.value = input.value;
                        form.appendChild(hiddenInput);
                    });
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Artikel akan dipindahkan ke sampah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'text-white px-6 py-2 rounded-full font-bold text-xs uppercase tracking-wider',
                    cancelButton: 'text-gray-600 px-6 py-2 rounded-full font-bold text-xs uppercase tracking-wider hover:bg-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#d4a5a5',
                customClass: {
                    confirmButton: 'px-8 py-2 rounded-full font-bold text-xs uppercase tracking-wider'
                }
            });
        @endif
    </script>
    @endpush
</x-app-layout>
