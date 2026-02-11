<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Tambah Album
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-md mx-auto p-8 rounded-2xl shadow-2xl bg-[#212844] text-white">

            <h2 class="text-2xl font-bold text-center mb-6">
                Buat Album Produk
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
                  action="{{ route('albums.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- NAMA ALBUM -->
                <div>
                    <label class="block font-semibold mb-1">Nama Album</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Contoh: Skincare Series"
                           class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="block font-semibold mb-1">Deskripsi</label>
                    <textarea name="description"
                              rows="4"
                              placeholder="Deskripsi singkat album"
                              class="w-full px-4 py-2 rounded-lg bg-[#212844] border border-white text-white placeholder-gray-400">{{ old('description') }}</textarea>
                </div>

                <!-- COVER IMAGE -->
                <div>
                    <label class="block font-semibold mb-1">Cover Album</label>
                    <input type="file"
                           name="cover_image"
                           accept="image/*"
                           class="w-full text-sm text-gray-300
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:bg-green-600 file:text-white
                                  hover:file:bg-green-700">
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Simpan Album
                    </button>

                    <a href="{{ route('albums.index') }}"
                       class="flex-1 py-2 bg-gray-500 hover:bg-gray-600 text-white text-center rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
