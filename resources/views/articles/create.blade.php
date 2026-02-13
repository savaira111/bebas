<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Create New Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <!-- Status is handled by backend (default: draft) -->
                    <input type="hidden" name="status" value="draft">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Left Column (Main Content) -->
                        <div class="md:col-span-2 space-y-6">
                            
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-gray-600 font-medium mb-2 font-serif">Article Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                    class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm py-3 px-4 text-lg" 
                                    required placeholder="Enter an engaging title...">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Content with Trix -->
                            <div>
                                <label for="content" class="block text-gray-600 font-medium mb-2 font-serif">Content</label>
                                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                                <trix-editor input="content" class="rounded-2xl border-gray-200 bg-gray-50 focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm min-h-[400px] text-lg leading-relaxed"></trix-editor>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Right Column (Meta & Settings) -->
                        <div class="space-y-6">
                            
                            <!-- Category -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <label for="category_id" class="block text-gray-600 font-medium mb-2 font-serif">Category</label>
                                <select name="category_id" id="category_id" 
                                    class="block w-full rounded-xl border-gray-200 bg-white focus:border-red-200 focus:ring focus:ring-red-100 transition shadow-sm cursor-pointer" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Image Upload -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <label class="block text-gray-600 font-medium mb-2 font-serif">Cover Image</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-[#d4a5a5] transition-colors bg-white cursor-pointer relative group">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#d4a5a5] transition" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="image" class="relative cursor-pointer rounded-md font-medium text-[#c29595] hover:text-[#b08080] focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(this)">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                    <img id="preview" class="hidden absolute inset-0 w-full h-full object-cover rounded-xl" />
                                </div>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <!-- SEO Settings -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100" x-data="{ open: false }">
                                <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left text-gray-600 font-medium font-serif focus:outline-none">
                                    <span>SEO Meta Data</span>
                                    <svg class="w-4 h-4 transition-transform transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="open" class="mt-4 space-y-4" style="display: none;">
                                    <div>
                                        <label for="meta_title" class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="block w-full rounded-lg border-gray-200 text-sm">
                                    </div>
                                    <div>
                                        <label for="meta_description" class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" rows="3" class="block w-full rounded-lg border-gray-200 text-sm">{{ old('meta_description') }}</textarea>
                                    </div>
                                    <div>
                                        <label for="meta_keywords" class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Keywords</label>
                                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" class="block w-full rounded-lg border-gray-200 text-sm" placeholder="e.g. skin, beauty, face">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-50">
                        <a href="{{ route('articles.index') }}" class="px-6 py-3 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 font-medium transition mr-4">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-full text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%); box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);">
                            Save Draft
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <style>
        trix-toolbar .trix-button--icon { color: #888; }
        trix-toolbar .trix-button--icon:hover { color: #d4a5a5; }
        trix-toolbar .trix-button.trix-active { color: #c29595; }
        .trix-content { font-family: 'Lato', sans-serif; color: #4a4a4a; font-size: 1.1em; line-height: 1.8; }
        .trix-content h1 { font-family: 'Playfair Display', serif !important; font-size: 2em !important; font-weight: bold; margin-bottom: 0.5em; }
        .trix-content blockquote { border-left: 4px solid #d4a5a5; padding-left: 1em; color: #666; font-style: italic; }
        trix-editor { min-height: 400px; }
    </style>
    @endpush
</x-app-layout>
