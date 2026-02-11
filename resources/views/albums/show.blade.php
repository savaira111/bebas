<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Detail Album
        </h2>
    </x-slot>

    <div class="py-12" style="background-color:#F0E8D5; min-height:100vh;">
        <div class="max-w-3xl mx-auto p-8 rounded-2xl shadow-2xl bg-[#212844] text-white">

            <!-- HEADER -->
            <div class="flex flex-col md:flex-row gap-6 mb-6">
                @if($album->cover_image)
                    <img src="{{ asset('storage/'.$album->cover_image) }}"
                         class="w-full md:w-48 h-48 object-cover rounded-xl">
                @else
                    <div class="w-full md:w-48 h-48 bg-gray-600 rounded-xl flex items-center justify-center">
                        <span class="text-gray-300">No Cover</span>
                    </div>
                @endif

                <div class="flex-1">
                    <h2 class="text-3xl font-bold mb-2">
                        {{ $album->name }}
                    </h2>

                    @if($album->description)
                        <p class="text-gray-300 mb-3">
                            {{ $album->description }}
                        </p>
                    @endif

                    <p class="text-sm text-gray-400">
                        Dibuat: {{ $album->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            <!-- ACTION -->
            <div class="flex gap-3 mb-8">
                <a href="{{ route('albums.edit', $album) }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white">
                    Edit
                </a>

                <a href="{{ route('albums.index') }}"
                   class="px-4 py-2 bg-gray-500 hover:bg-gray-600 rounded-lg text-white">
                    Kembali
                </a>
            </div>

            <!-- PHOTOS -->
            <h3 class="text-xl font-semibold mb-4">
                Foto Album
            </h3>

            @if($album->photos->count())
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($album->photos as $photo)
                        <div class="group relative">
                            <img src="{{ asset('storage/'.$photo->image) }}"
                                 class="w-full h-32 object-cover rounded-lg">

                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100
                                        flex items-center justify-center rounded-lg transition">
                                <span class="text-sm text-white">
                                    {{ $photo->caption ?? 'Foto' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 italic">
                    Belum ada foto di album ini.
                </p>
            @endif

        </div>
    </div>
</x-app-layout>
