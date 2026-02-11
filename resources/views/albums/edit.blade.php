<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Edit Album
        </h2>
    </x-slot>

    <div class="py-12" style="background-color:#F0E8D5; min-height:100vh;">
        <div class="max-w-md mx-auto p-8 rounded-2xl shadow-2xl bg-[#212844] text-white">

            <h2 class="text-2xl font-bold text-center mb-6">
                Edit Album
            </h2>

            @if($errors->any())
                <div class="mb-3 p-2 bg-red-600 text-white rounded">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('albums.update', $album) }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- NAMA ALBUM -->
                <div>
                    <label class="block font-semibold mb-1">Nama Album</label>
                    <input type="text"
                           name="name"
                           required
                           value="{{ old('name', $album->name) }}"
                           placeholder="Nama album"
                           class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="block font-semibold mb-1">Deskripsi</label>
                    <textarea name="description"
                              rows="3"
                              placeholder="Deskripsi album"
                              class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">{{ old('description', $album->description) }}</textarea>
                </div>

                <!-- COVER -->
                <div>
                    <label class="block font-semibold mb-1">Cover Album</label>

                    @if($album->cover_image)
                        <img src="{{ asset('storage/'.$album->cover_image) }}"
                             class="w-32 h-32 object-cover rounded-lg mb-3">
                    @endif

                    <input type="file"
                           name="cover_image"
                           accept="image/*"
                           class="w-full text-sm text-gray-300">
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Update
                    </button>

                    <a href="{{ route('albums.index') }}"
                       class="flex-1 py-2 bg-gray-500 hover:bg-gray-600 text-white text-center rounded-lg">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
