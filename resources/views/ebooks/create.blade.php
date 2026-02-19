<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Add New E-Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                    required placeholder="e.g. Beauty Guide 101">
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Author -->
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Author</label>
                                <input type="text" name="author" id="author" value="{{ old('author') }}" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                    required placeholder="e.g. John Doe">
                                @error('author') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                         <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                placeholder="Write a short description...">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <!-- Cover Upload -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 relative group hover:border-[#d4a5a5] transition-colors border-dashed border-2">
                                <label for="cover" class="block text-gray-600 font-medium mb-4 font-serif text-center">Cover Image</label>
                                
                                <div class="relative flex flex-col items-center justify-center cursor-pointer">
                                    
                                    <div id="image-placeholder" class="text-center space-y-2">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#d4a5a5] transition" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="text-sm text-gray-500 font-medium">Click to upload cover</p>
                                        <p class="text-xs text-gray-400">PNG, JPG</p>
                                    </div>
                                    
                                    <img id="image-preview" src="" class="hidden absolute inset-0 w-full h-40 object-contain rounded-lg" />
                                    
                                    <input id="cover" name="cover" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                                </div>
                                @error('cover') <span class="text-red-500 text-xs mt-2 block text-center">{{ $message }}</span> @enderror
                            </div>

                             <!-- PDF File Upload -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 relative group hover:border-[#d4a5a5] transition-colors border-dashed border-2">
                                <label for="file" class="block text-gray-600 font-medium mb-4 font-serif text-center">PDF File</label>
                                
                                <div class="relative flex flex-col items-center justify-center cursor-pointer h-40">
                                    <div class="text-center space-y-2">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#d4a5a5] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        <p id="file-name" class="text-sm text-gray-500 font-medium">Click to upload PDF</p>
                                        <p class="text-xs text-gray-400">PDF only</p>
                                    </div>
                                    <input id="file" name="pdf" type="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(event)" required>
                                </div>
                                @error('pdf') <span class="text-red-500 text-xs mt-2 block text-center">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Login Required Toggle -->
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex items-center justify-between">
                            <div class="space-y-1">
                                <label class="text-gray-700 font-medium font-serif">Login Required for Download</label>
                                <p class="text-xs text-gray-500">If enabled, users must be logged in to download this E-Book.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_auth_required" value="1" class="sr-only peer" checked>
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#d4a5a5]"></div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-50 pt-8">
                        <a href="{{ route('ebooks.index') }}" class="px-6 py-3 rounded-full text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 font-medium transition shadow-sm">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-full text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                            Upload E-Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('image-preview');
                output.src = reader.result;
                output.classList.remove('hidden');
                document.getElementById('image-placeholder').classList.add('opacity-0');
            };
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function updateFileName(event) {
            var input = event.target;
            var fileName = input.files[0].name;
            document.getElementById('file-name').textContent = fileName;
        }
    </script>
    @endpush
</x-app-layout>
