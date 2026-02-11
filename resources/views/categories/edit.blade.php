<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-md mx-auto p-8 rounded-2xl shadow-2xl bg-[#212844] text-white">

            <h2 class="text-2xl font-bold text-center mb-6">
                Edit Category
            </h2>

            @if ($errors->any())
                <div class="mb-3 p-2 bg-red-600 text-white rounded">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Category -->
                <div>
                    <label class="block font-semibold mb-1">Nama Category</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $category->name) }}"
                           required
                           placeholder="Contoh: Skincare"
                           class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block font-semibold mb-1">Slug</label>
                    <input type="text"
                           id="slug"
                           name="slug"
                           value="{{ old('slug', $category->slug) }}"
                           required
                           placeholder="Contoh: skincare"
                           class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block font-semibold mb-1">Deskripsi</label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              placeholder="Deskripsi singkat category"
                              class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">{{ old('description', $category->description) }}</textarea>
                </div>

                <!-- Button -->
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">
                        Update Category
                    </button>

                    <a href="{{ route('categories.index') }}"
                       class="flex-1 py-2 bg-gray-500 hover:bg-gray-600 text-white text-center rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script untuk slug otomatis -->
    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('input', function() {
            let slug = this.value.toLowerCase()
                                 .trim()
                                 .replace(/[\s\W-]+/g, '-') 
                                 .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        });
    </script>
</x-app-layout>
