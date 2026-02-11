<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Tambah Category
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-md mx-auto p-8 rounded-2xl shadow-2xl bg-[#212844] text-white">

            <h2 class="text-2xl font-bold text-center mb-6">
                Buat Category Baru
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

            <form method="POST"
                  action="{{ route('categories.store') }}"
                  class="space-y-6">
                @csrf

                <!-- NAMA CATEGORY -->
                <div>
                    <label class="block font-semibold mb-1">Nama Category</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Contoh: Skincare"
                           class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">
                </div>

                <!-- SLUG -->
                <div>
                    <label class="block font-semibold mb-1">Slug</label>
                    <input type="text"
                           name="slug"
                           id="slug"
                           value="{{ old('slug') }}"
                           required
                           placeholder="Contoh: skincare"
                           class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="block font-semibold mb-1">Deskripsi</label>
                    <textarea name="description"
                              rows="4"
                              placeholder="Deskripsi singkat category"
                              class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">{{ old('description') }}</textarea>
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Simpan Category
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
                                 .replace(/[\s\W-]+/g, '-') // spasi & karakter non-alfanumerik jadi -
                                 .replace(/^-+|-+$/g, ''); // hapus - di awal/akhir
            slugInput.value = slug;
        });
    </script>
</x-app-layout>
