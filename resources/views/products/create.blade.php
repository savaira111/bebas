<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Product Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                    placeholder="e.g. Rose Gold Serum" required>
                                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Category</label>
                                <select name="category_id" id="category_id" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3 text-gray-600" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Price (IDR)</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-400 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" 
                                        class="block w-full rounded-2xl border-gray-200 pl-10 focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                        placeholder="0" required>
                                </div>
                                @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                             <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Description</label>
                                <textarea name="description" id="description" rows="4" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3"
                                    placeholder="Describe the product details...">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Stock</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock') }}" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                    placeholder="Available quantity">
                                @error('stock') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Product Image</label>
                                <div class="mt-2 flex justify-center rounded-3xl border-2 border-dashed border-red-100 px-6 pt-10 pb-10 bg-pink-50/30 hover:bg-pink-50/60 transition duration-300 relative overflow-hidden group">
                                    <div class="space-y-2 text-center relative z-10">
                                        <div class="mx-auto h-16 w-16 text-red-200 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
                                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="image" class="relative cursor-pointer rounded-md font-medium text-red-400 focus-within:outline-none hover:text-red-500">
                                                <span>Upload a file</span>
                                                <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(event)">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-400">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                    <div class="absolute inset-0 bg-red-50 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                </div>
                                <div id="image-preview" class="mt-6 hidden text-center">
                                    <p class="text-sm text-gray-500 mb-2 font-medium" style="font-family: 'Playfair Display', serif;">Preview:</p>
                                    <div class="relative inline-block">
                                        <img id="preview-img" src="" alt="Image Preview" class="mx-auto h-64 w-auto rounded-2xl shadow-lg object-cover border-4 border-white">
                                        <div class="absolute inset-0 rounded-2xl ring-1 ring-black/5"></div>
                                    </div>
                                </div>
                                @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-end space-x-4">
                        <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-full text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 font-medium transition shadow-sm">
                            Cancel
                        </a>
                        <button type="submit" name="create_another" value="1" class="px-6 py-3 rounded-full text-red-400 bg-red-50 hover:bg-red-100 font-medium transition shadow-sm border border-transparent">
                            Save & Create Another
                        </button>
                        <button type="submit" class="px-8 py-3 rounded-full text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                            Save Product
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
                var output = document.querySelector('#preview-img');
                output.src = reader.result;
                document.getElementById('image-preview').classList.remove('hidden');
            };
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
