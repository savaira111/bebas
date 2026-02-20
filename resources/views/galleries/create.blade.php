<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Add New Image') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data" id="gallery-form">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-8 p-6 rounded-2xl bg-red-50 border border-red-100 animate-fadeIn">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Periksa Kembali Data Anda</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-8">
                        {{-- Global Settings --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-100">
                            <!-- Global Title -->
                            <div class="md:col-span-2">
                                <label for="global_title" class="block text-sm font-medium text-gray-700">Gallery Title (for all files)</label>
                                <input type="text" name="global_title" id="global_title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" required placeholder="e.g. Summer Collection 2026">
                            </div>

                            <!-- Global Description -->
                            <div class="md:col-span-2">
                                <label for="global_description" class="block text-sm font-medium text-gray-700">Gallery Description</label>
                                <textarea name="global_description" id="global_description" rows="2" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" placeholder="Describe this gallery collection..."></textarea>
                            </div>

                             <!-- Global Type -->
                             <div>
                                <label for="global_type" class="block text-sm font-medium text-gray-700">Gallery Type</label>
                                <select id="global_type" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" onchange="applyGlobalType(this.value)">
                                    <option value="alltype">All Type (Photo & Video)</option>
                                    <option value="foto">Photo Only</option>
                                    <option value="video">Video Only</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Album -->
                            <div>
                                <label for="album_id" class="block text-sm font-medium text-gray-700">Album (Optional)</label>
                                <select name="album_id" id="album_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <option value="">Select Album</option>
                                    @foreach($albums as $album)
                                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Items Container --}}
                        <div id="items-container" class="space-y-6">
                            {{-- Row Template will be inserted here --}}
                        </div>

                        {{-- Add Row Button --}}
                        <div class="flex justify-center py-4">
                            <button type="button" id="add-row-btn" class="flex items-center space-x-2 px-6 py-2 rounded-full border-2 border-dashed border-gray-300 text-gray-500 hover:border-red-300 hover:text-red-400 transition group">
                                <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <span class="font-medium">Add Another Photo/Video</span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('galleries.index') }}" class="px-6 py-3 rounded-xl text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                            Save All Gallery
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-row-btn');
        const globalType = document.getElementById('global_type');
        let rowCount = 0;

        function createRowMarkup(index) {
            const currentGlobal = globalType.value;
            const isDisabled = currentGlobal !== 'alltype' ? 'disabled' : '';
            const selectedType = currentGlobal === 'alltype' ? 'foto' : currentGlobal;
            
            // First row (index 0) cannot be deleted
            const showDelete = index > 0 ? '' : 'hidden';

            return `
                <div class="item-row bg-gray-50 rounded-3xl p-6 border border-gray-100 relative transition hover:shadow-md animate-fadeIn" id="row-${index}">
                    <button type="button" onclick="removeRow(${index})" class="absolute -top-3 -right-3 bg-white border border-gray-200 text-gray-400 hover:text-red-500 rounded-full p-1.5 shadow-sm transition ${showDelete}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <!-- Type & Media Info -->
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Item Media Type</label>
                                    <select name="items[${index}][type]" onchange="handleItemTypeChange(${index}, this.value)" class="item-type-select w-full rounded-xl border-gray-200 text-sm focus:border-red-300 focus:ring-red-100 ${isDisabled ? 'bg-gray-100 cursor-not-allowed' : ''}" ${isDisabled}>
                                        <option value="foto" ${selectedType === 'foto' ? 'selected' : ''}>Photo</option>
                                        <option value="video" ${selectedType === 'video' ? 'selected' : ''}>Video</option>
                                    </select>
                                    ${isDisabled ? `<input type="hidden" name="items[${index}][type]" value="${selectedType}">` : ''}
                                </div>
                                <div class="text-xs text-gray-400 italic">
                                    ${isDisabled ? '* Locked by Gallery Type' : '* Individual type selection enabled'}
                                </div>
                            </div>
                            
                            <!-- Optional Caption -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Caption / Specific Notes (Optional)</label>
                                <textarea name="items[${index}][description]" rows="3" class="w-full rounded-xl border-gray-200 text-sm focus:border-red-300 focus:ring-red-100 placeholder-gray-300" placeholder="e.g. Close up shot..."></textarea>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Media Upload / Link -->
                            <div id="media-input-container-${index}">
                                <div id="photo-input-${index}" class="${selectedType === 'foto' ? '' : 'hidden'}">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Photo File</label>
                                    <div class="relative group">
                                        <div class="flex items-center justify-center p-4 rounded-xl border-2 border-dashed border-gray-200 bg-white hover:border-red-300 transition cursor-pointer" onclick="document.getElementById('file-input-${index}').click()">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-300 group-hover:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="text-xs text-gray-400 mt-1 block">Click to upload photo</span>
                                            </div>
                                        </div>
                                        <input type="file" id="file-input-${index}" name="items[${index}][image]" class="hidden" accept="image/*" onchange="previewMedia(${index}, event)">
                                    </div>
                                </div>

                                <div id="video-input-${index}" class="${selectedType === 'video' ? '' : 'hidden'} space-y-3">
                                    <div class="flex items-center space-x-4 mb-2">
                                        <label class="flex items-center space-x-2 text-xs font-bold text-gray-500">
                                            <input type="radio" name="video_source_${index}" value="file" checked onchange="toggleVideoSource(${index}, 'file')" class="text-red-400 focus:ring-red-200">
                                            <span>Upload File</span>
                                        </label>
                                        <label class="flex items-center space-x-2 text-xs font-bold text-gray-500">
                                            <input type="radio" name="video_source_${index}" value="ytb" onchange="toggleVideoSource(${index}, 'ytb')" class="text-red-400 focus:ring-red-200">
                                            <span>YouTube Link</span>
                                        </label>
                                    </div>
                                    <div id="video-file-container-${index}">
                                        <div class="flex items-center justify-center p-4 rounded-xl border-2 border-dashed border-gray-200 bg-white hover:border-red-300 transition cursor-pointer" onclick="document.getElementById('video-file-input-${index}').click()">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="text-xs text-gray-400 mt-1 block">Click to upload video</span>
                                            </div>
                                        </div>
                                        <input type="file" id="video-file-input-${index}" name="items[${index}][image_video]" class="hidden" accept="video/*" onchange="previewMedia(${index}, event, 'video')">
                                    </div>
                                    <div id="video-url-container-${index}" class="hidden">
                                        <input type="text" name="items[${index}][video_url]" placeholder="https://www.youtube.com/watch?v=..." class="w-full rounded-xl border-gray-200 text-sm focus:border-red-300 focus:ring-red-100">
                                    </div>
                                </div>
                            </div>

                            <!-- Preview -->
                            <div id="preview-${index}" class="hidden mt-2 relative">
                                <img src="" class="h-24 w-full object-cover rounded-xl shadow-sm border border-gray-200">
                                <div class="video-icon hidden absolute inset-0 flex items-center justify-center bg-black/20 rounded-xl">
                                    <svg class="w-8 h-8 text-white shadow-lg" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function addRow() {
            const activeRows = document.querySelectorAll('.item-row').length;
            if (activeRows >= 10) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Max upload foto atau video hanya 10 tidak lebih.',
                    icon: 'warning',
                    confirmButtonColor: '#d4a5a5',
                    confirmButtonText: 'Oke'
                });
                return;
            }
            
            const div = document.createElement('div');
            div.innerHTML = createRowMarkup(rowCount);
            container.appendChild(div.firstElementChild);
            rowCount++;
        }

        function removeRow(index) {
            const row = document.getElementById(`row-${index}`);
            row.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                row.remove();
            }, 300);
        }

        function applyGlobalType(val) {
            // Remove all existing rows and reset count to ensure clean state with correct locking
            // OR just update existing rows. The user said "gabisa berobah tapi tetap".
            // Let's update existing rows.
            const rows = document.querySelectorAll('.item-row');
            rows.forEach(row => {
                const index = row.id.split('-')[1];
                const select = row.querySelector('.item-type-select');
                const hiddenInput = row.querySelector(`input[type="hidden"][name="items[${index}][type]"]`);
                
                if (val === 'alltype') {
                    select.disabled = false;
                    select.classList.remove('bg-gray-100', 'cursor-not-allowed');
                    if (hiddenInput) hiddenInput.remove();
                } else {
                    select.value = val;
                    select.disabled = true;
                    select.classList.add('bg-gray-100', 'cursor-not-allowed');
                    
                    // Add hidden input if not exists to ensure value is sent
                    if (!hiddenInput) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `items[${index}][type]`;
                        input.value = val;
                        select.parentNode.appendChild(input);
                    } else {
                        hiddenInput.value = val;
                    }
                    
                    handleItemTypeChange(index, val);
                }
            });
        }

        function handleItemTypeChange(index, type) {
            const photoInput = document.getElementById(`photo-input-${index}`);
            const videoInput = document.getElementById(`video-input-${index}`);
            const previewDiv = document.getElementById(`preview-${index}`);
            
            // Clear preview on type change to avoid confusion
            previewDiv.classList.add('hidden');
            
            if (type === 'foto') {
                photoInput.classList.remove('hidden');
                videoInput.classList.add('hidden');
            } else {
                photoInput.classList.add('hidden');
                videoInput.classList.remove('hidden');
            }
        }

        function toggleVideoSource(index, source) {
            const fileContainer = document.getElementById(`video-file-container-${index}`);
            const urlContainer = document.getElementById(`video-url-container-${index}`);
            
            if (source === 'file') {
                fileContainer.classList.remove('hidden');
                urlContainer.classList.add('hidden');
            } else {
                fileContainer.classList.add('hidden');
                urlContainer.classList.remove('hidden');
            }
        }

        function previewMedia(index, event, type = 'photo') {
            const file = event.target.files[0];
            if (!file) return;

            const ext = file.name.split('.').pop().toLowerCase();
            const photoExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            const videoExts = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
            
            // Get current value from select or hidden input
            const select = document.querySelector(`#row-${index} .item-type-select`);
            const currentType = select.disabled ? document.querySelector(`input[name="items[${index}][type]"]`).value : select.value;

            if (currentType === 'foto' && !photoExts.includes(ext)) {
                 Swal.fire({
                    title: 'Tipe File Salah',
                    text: 'Kamu pilih tipe foto, jadi hanya boleh upload gambar.',
                    icon: 'error',
                    confirmButtonColor: '#d4a5a5'
                });
                event.target.value = '';
                return;
            }
            
            if (currentType === 'video' && !videoExts.includes(ext)) {
                 Swal.fire({
                    title: 'Tipe File Salah',
                    text: 'Kamu pilih tipe video, jadi hanya boleh upload video.',
                    icon: 'error',
                    confirmButtonColor: '#d4a5a5'
                });
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.getElementById(`preview-${index}`);
                const img = previewDiv.querySelector('img');
                const videoIcon = previewDiv.querySelector('.video-icon');
                
                if (currentType === 'video') {
                    img.src = 'https://img.icons8.com/clouds/200/video.png';
                    videoIcon.classList.remove('hidden');
                } else {
                    img.src = e.target.result;
                    videoIcon.classList.add('hidden');
                }
                
                previewDiv.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        document.addEventListener('DOMContentLoaded', () => {
            addBtn.addEventListener('click', addRow);
            addRow();
        });

        document.getElementById('gallery-form').addEventListener('submit', function(e) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length === 0) {
                 e.preventDefault();
                 Swal.fire('Error', 'Minimal harus ada 1 item.', 'error');
                 return;
            }
            
            rows.forEach((row, i) => {
                // Re-index all named inputs in this row to ensure sequential items[0], items[1], etc.
                row.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.name) {
                        // Replace items[X] with items[i]
                        input.name = input.name.replace(/items\[\d+\]/, `items[${i}]`);
                    }
                });

                // Special handling for video file: the backend expects 'image' key for the file
                const videoFileInput = row.querySelector(`input[id^="video-file-input"]`);
                if (videoFileInput && videoFileInput.files.length > 0) {
                    videoFileInput.name = `items[${i}][image]`;
                }
                
                // Ensure photo input also has correct sequential name if not already caught
                const photoInput = row.querySelector(`input[id^="file-input"]`);
                if (photoInput) {
                    photoInput.name = `items[${i}][image]`;
                }
            });
        });
    </script>
    <style>
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @endpush
</x-app-layout>
