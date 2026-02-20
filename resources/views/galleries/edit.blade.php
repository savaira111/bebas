<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Edit Image') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Image Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" required>
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                <select name="type" id="type" onchange="toggleType(this.value)" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" required>
                                    <option value="foto" {{ old('type', $gallery->type) == 'foto' ? 'selected' : '' }}>Photo</option>
                                    <option value="video" {{ old('type', $gallery->type) == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $gallery->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Video URL (conditionally shown) -->
                            <div id="video-url-group" class="{{ old('type', $gallery->type) == 'video' ? '' : 'hidden' }}">
                                <label for="video_url" class="block text-sm font-medium text-gray-700">YouTube Video URL</label>
                                <input type="text" name="video_url" id="video_url" value="{{ old('video_url', $gallery->video_url) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('description', $gallery->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                         <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Image</label>
                            <div class="mt-2 text-center bg-gray-50 rounded-lg p-2 mb-4">
                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="Current Image" class="mx-auto h-48 w-auto rounded shadow-sm object-cover">
                            </div>

                            <label for="image" class="block text-sm font-medium text-gray-700">Change Image</label>
                            <div class="mt-2 flex justify-center rounded-xl border-2 border-dashed border-gray-300 px-6 pt-5 pb-6 bg-gray-50 hover:bg-white transition">
                                <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="image" class="relative cursor-pointer rounded-md bg-white font-medium text-red-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-red-500 focus-within:ring-offset-2 hover:text-red-500">
                                            <span>Upload new file</span>
                                            <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(event)">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                </div>
                            </div>
                            <div id="image-preview" class="mt-4 hidden text-center">
                                <p class="text-sm text-gray-500 mb-2">New Image Preview:</p>
                                <img src="" alt="Preview" class="mx-auto h-48 w-auto rounded-lg shadow-md object-cover">
                            </div>
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('galleries.index') }}" class="px-6 py-3 rounded-xl text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                            Update Image
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleType(type) {
            const videoGroup = document.getElementById('video-url-group');
            if (type === 'video') {
                videoGroup.classList.remove('hidden');
            } else {
                videoGroup.classList.add('hidden');
            }
        }

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.querySelector('#image-preview img');
                output.src = reader.result;
                document.getElementById('image-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
