<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Tambah Gallery</h2>
    </x-slot>

    <div class="py-10 max-w-xl mx-auto">
        <form method="POST" action="{{ route('galleries.store') }}"
              enctype="multipart/form-data"
              class="bg-[#212844] p-6 rounded-xl text-white space-y-4">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="block mb-1">Judul</label>
                <input type="text" name="title"
                       class="w-full bg-[#2a3155] rounded p-2"
                       required>
            </div>

            {{-- Tipe --}}
            <div>
                <label class="block mb-1">Tipe</label>
                <select name="type"
                        class="w-full bg-[#2a3155] rounded p-2"
                        required>
                    <option value="foto">Foto</option>
                    <option value="video">Video</option>

                </select>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block mb-1">Kategori</label>
                <select name="category_id"
                        class="w-full bg-[#2a3155] rounded p-2"
                        required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Album --}}
            <div>
                <label class="block mb-1">Album</label>
                <select name="album_id"
                        class="w-full bg-[#2a3155] rounded p-2">
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}">
                            {{ $album->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block mb-1">Deskripsi</label>
                <textarea name="description"
                          rows="3"
                          class="w-full bg-[#2a3155] rounded p-2"></textarea>
            </div>

            {{-- Foto / Video --}}
            <div>
                <label class="block mb-1">File (Foto / Video)</label>
                <input type="file" name="images[]"
                       multiple
                       class="w-full text-sm"
                       required>
            </div>

            <div class="flex gap-2 pt-2">
                <button class="w-1/2 py-2 bg-green-600 rounded hover:bg-green-700">
                    Simpan
                </button>
                <a href="{{ route('galleries.index') }}"
                   class="w-1/2 py-2 text-center bg-gray-500 rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
