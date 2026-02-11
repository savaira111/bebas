<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">Tambah Artikel</h2>
    </x-slot>

    <div class="py-12" style="background-color:#F0E8D5; min-height:100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-600 text-white rounded">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('articles.store') }}"
                  enctype="multipart/form-data">
                @csrf

                {{-- TOP : JUDUL & SLUG --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-[#212844] p-6 rounded-2xl shadow text-white">
                        <label class="block font-semibold mb-2">Judul</label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               required
                               placeholder="Contoh: Cara Merawat Kulit Wajah"
                               class="w-full px-4 py-2 rounded-lg bg-[#2a3155] border border-white text-white">
                    </div>

                    <div class="bg-[#212844] p-6 rounded-2xl shadow text-white">
                        <label class="block font-semibold mb-2">Slug (Otomatis)</label>
                        <input type="text"
                               name="slug"
                               id="slug"
                               value="{{ old('slug') }}"
                               readonly
                               class="w-full px-4 py-2 rounded-lg bg-[#2a3155] border border-white text-gray-300 cursor-not-allowed">
                        <small class="text-gray-300">Slug otomatis mengikuti judul</small>
                    </div>
                </div>

                {{-- MAIN GRID --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- LEFT : CONTENT --}}
                    <div class="lg:col-span-2 bg-[#212844] p-6 rounded-2xl shadow text-white">
                        <label class="block font-semibold mb-2">Konten</label>
                        <textarea id="content"
                                  name="content"
                                  rows="12"
                                  class="w-full px-4 py-2 rounded-lg bg-white text-black border border-gray-300">{{ old('content') }}</textarea>
                    </div>

                    {{-- RIGHT : SEO + IMAGE --}}
                    <div class="space-y-6">

                        {{-- SEO --}}
                        <div class="bg-[#212844] p-6 rounded-2xl shadow text-white">
                            <label class="block font-semibold mb-3">SEO (Opsional)</label>

                            <label class="text-sm text-gray-300">Meta Title</label>
                            <input type="text"
                                   name="meta_title"
                                   value="{{ old('meta_title') }}"
                                   placeholder="Judul khusus untuk mesin pencari"
                                   class="w-full mb-3 px-4 py-2 rounded-lg bg-[#2a3155] border border-white text-white">

                            <label class="text-sm text-gray-300">Meta Keywords</label>
                            <input type="text"
                                   name="meta_keywords"
                                   value="{{ old('meta_keywords') }}"
                                   placeholder="contoh: skincare, wajah, perawatan"
                                   class="w-full mb-1 px-4 py-2 rounded-lg bg-[#2a3155] border border-white text-white">
                            <small class="text-gray-300">Pisahkan dengan koma (,)</small>

                            <label class="text-sm text-gray-300 mt-3 block">Meta Description</label>
                            <textarea name="meta_description"
                                      rows="3"
                                      placeholder="Ringkasan singkat artikel untuk hasil pencarian Google"
                                      class="w-full mt-1 px-4 py-2 rounded-lg bg-[#2a3155] border border-white text-white">{{ old('meta_description') }}</textarea>
                        </div>

                        {{-- IMAGE --}}
                        <div class="bg-[#212844] p-6 rounded-2xl shadow text-white space-y-4">
                            <div>
                                <label class="block font-semibold mb-2">Image</label>
                                <input type="file"
                                       name="image"
                                       accept="image/*"
                                       class="w-full text-sm text-gray-300
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:bg-green-600 file:text-white
                                              hover:file:bg-green-700">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-center gap-4 mt-8">
                    <button type="submit"
                            class="px-8 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Submit
                    </button>

                    <a href="{{ route('articles.index') }}"
                       class="px-8 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- CKEDITOR --}}
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content', {
            height: 400,
            extraPlugins: 'colorbutton,font,justify,uploadimage,image2',
            removePlugins: 'image',
            toolbar: [
                { name: 'clipboard', items: ['Undo','Redo'] },
                { name: 'styles', items: ['Styles','Format','Font','FontSize'] },
                { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike','RemoveFormat'] },
                { name: 'colors', items: ['TextColor','BGColor'] },
                { name: 'paragraph', items: ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','NumberedList','BulletedList'] },
                { name: 'insert', items: ['Image','Table','HorizontalRule','SpecialChar','Link','Unlink'] },
                { name: 'tools', items: ['Maximize','Source'] }
            ]
        });

        const titleInput = document.getElementById('title');
        const slugInput  = document.getElementById('slug');

        titleInput.addEventListener('input', function () {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        });
    </script>
</x-app-layout>
