<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Add New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                required placeholder="e.g. Skincare" onkeyup="generateSlug()">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                         <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-gray-200 focus:ring focus:ring-gray-100 focus:ring-opacity-50 transition bg-gray-100 py-3 text-gray-500" 
                                readonly>
                            @error('slug') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                         <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Playfair Display', serif;">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                class="mt-1 block w-full rounded-2xl border-gray-200 shadow-sm focus:border-red-200 focus:ring focus:ring-red-100 focus:ring-opacity-50 transition bg-gray-50/30 py-3" 
                                placeholder="Optional description">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-4">
                        <a href="{{ route('categories.index') }}" class="px-6 py-3 rounded-full text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 font-medium transition shadow-sm">
                            Cancel
                        </a>
                        <button type="submit" name="create_another" value="1" class="px-6 py-3 rounded-full text-red-400 bg-red-50 hover:bg-red-100 font-medium transition shadow-sm border border-transparent">
                            Save & Create Another
                        </button>
                        <button type="submit" class="px-8 py-3 rounded-full text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('name').addEventListener('input', function() {
            let name = this.value;
            let slug = name.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes
            
            document.getElementById('slug').value = slug;
        });
    </script>
    @endpush
</x-app-layout>
