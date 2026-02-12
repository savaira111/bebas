<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Tambah Gallery</h2>
    </x-slot>

    <div class="py-10 max-w-xl mx-auto">
        <form method="POST" action="{{ route('galleries.store') }}"
              enctype="multipart/form-data"
              class="bg-[#212844] p-6 rounded-xl text-white space-y-4" id="galleryForm">
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
                <select name="type" id="type"
                        class="w-full bg-[#2a3155] rounded p-2"
                        required>
                    <option value="foto">Foto</option>
                    <option value="video">Video</option>
                    <option value="balance">Balance</option>
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

            {{-- File Foto / Video Dinamis --}}
            <div>
                <label class="block mb-1">File (Foto / Video) — Maks 10</label>
                <div id="file-inputs" class="space-y-2">
                    <div class="flex gap-2 items-center">
                        <input type="file" name="images[]" class="w-full text-sm file-input">
                        <a href="#" target="_blank" class="text-blue-400 underline browse-link hidden">Lihat</a>
                        <button type="button" class="add-input px-2 py-1 bg-gray-500 rounded hover:bg-gray-600">+</button>
                    </div>
                </div>
               
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

    <script>
        const maxFiles = 10;
        const fileInputsContainer = document.getElementById('file-inputs');
        const typeSelect = document.getElementById('type');

        fileInputsContainer.addEventListener('click', function(e){
            if(e.target.classList.contains('add-input')){
                const currentInputs = fileInputsContainer.querySelectorAll('input[type="file"]').length;
                if(currentInputs >= maxFiles){
                    alert('Maksimal 10 file!');
                    return;
                }
                const newDiv = document.createElement('div');
                newDiv.classList.add('flex','gap-2','items-center');
                newDiv.innerHTML = `
                    <input type="file" name="images[]" class="w-full text-sm file-input">
                    <a href="#" target="_blank" class="text-blue-400 underline browse-link hidden">Lihat</a>
                    <button type="button" class="remove-input px-2 py-1 bg-red-500 rounded hover:bg-red-600">-</button>
                `;
                fileInputsContainer.appendChild(newDiv);
            }

            if(e.target.classList.contains('remove-input')){
                e.target.parentElement.remove();
            }
        });

        fileInputsContainer.addEventListener('change', function(e){
            if(e.target.classList.contains('file-input')){
                const file = e.target.files[0];
                const link = e.target.nextElementSibling;
                const type = typeSelect.value;

                if(file){
                    const fileType = file.type;
                    // Validasi tipe file
                    if(type === 'foto' && !fileType.startsWith('image/')){
                        alert('Hanya file gambar yang diperbolehkan untuk tipe foto!');
                        e.target.value = '';
                        link.classList.add('hidden');
                        return;
                    }
                    if(type === 'video' && !fileType.startsWith('video/')){
                        alert('Hanya file video yang diperbolehkan untuk tipe video!');
                        e.target.value = '';
                        link.classList.add('hidden');
                        return;
                    }
                    // jika balance, boleh keduanya

                    link.href = URL.createObjectURL(file);
                    link.classList.remove('hidden');
                } else {
                    link.classList.add('hidden');
                }
            }
        });
    </script>
</x-app-layout>
