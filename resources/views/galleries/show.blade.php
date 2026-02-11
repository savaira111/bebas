<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">{{ $gallery->title }}</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-4">
            @foreach($gallery->photos as $photo)
                <div class="bg-[#212844] p-2 rounded">
                    <img src="{{ asset('storage/'.$photo->image) }}"
                         class="w-full h-40 object-cover rounded">
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
