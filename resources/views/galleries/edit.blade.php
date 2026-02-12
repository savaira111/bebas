<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Edit Gallery</h2>
    </x-slot>

    <div class="py-10 max-w-xl mx-auto">
        <form method="POST" action="{{ route('galleries.update', $gallery->id) }}"
              enctype="multipart/form-data"
              class="bg-[#212844] p-6 rounded-xl text-white space-y-4">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div>
                <label class="block mb-1">Judul</label>
                <input type="text" name="title"
                       value="{{ old('title', $gallery->title) }}"
                       class="w-full bg-[#2a3155] rounded p-2"
                       required>
            </div>

            {{-- Tipe --}}
            <div>
                <label class="block mb-1">Tipe</label>
                <select name="type"
                        class="w-full bg-[#2a3155] rounded p-2"
                        required>
                    <option value="foto" {{ old('type', $gallery->type) == 'foto' ? 'selected' : '' }}>Foto</option>
                    <option value="video" {{ old('type', $gallery->type) == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="balance" {{ old('type', $gallery->type) == 'balance' ? 'selected' : '' }}>Balance</option>
                </select>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block mb-1">Kategori</label>
                <select name="category_id"
                        class="w-full bg-[#2a3155] rounded p-2"
                        required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $gallery->category_id) == $category->id ? 'selected' : '' }}>
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
                        <option value="{{ $album->id }}"
                            {{ old('album_id', $gallery->album_id) == $album->id ? 'selected' : '' }}>
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
                          class="w-full bg-[#2a3155] rounded p-2">{{ old('description', $gallery->description) }}</textarea>
            </div>

            {{-- File Foto / Video --}}
            <div>
                <label class="block mb-1">File (Foto / Video) — Maks 10</label>
                <input type="file" name="images[]"
                       multiple
                       class="w-full text-sm">

                @if(optional($gallery->photos)->count() > 0)
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($gallery->photos as $image)
                            <a href="{{ asset('storage/' . $image->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $image->image) }}"
                                     class="w-20 h-20 object-cover rounded cursor-pointer">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex gap-2 pt-2">
                <button class="w-1/2 py-2 bg-green-600 rounded hover:bg-green-700">
                    Update
                </button>
                <a href="{{ route('galleries.index') }}"
                   class="w-1/2 py-2 text-center bg-gray-500 rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
