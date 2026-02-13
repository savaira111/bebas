<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('Create New Album') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-50 p-8">
                
                <form action="{{ route('albums.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Album Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" required placeholder="e.g. Product Launch 2026">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                         <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" placeholder="Optional description">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-4">
                        <a href="{{ route('albums.index') }}" class="px-6 py-3 rounded-xl text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5" style="background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);">
                            Create Album
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
