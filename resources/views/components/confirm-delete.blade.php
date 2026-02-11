<x-app-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-900">
    <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 border border-gray-700">
        <h2 class="text-xl font-semibold text-white mb-3">Konfirmasi Hapus</h2>

        <p class="text-gray-300 mb-6">
            Apakah kamu yakin ingin menghapus user ini? Data akan masuk trash.
        </p>

        <div class="flex justify-end gap-3">
            <a href="{{ url()->previous() }}"
               class="px-4 py-2 rounded bg-gray-600 text-white hover:bg-gray-500">
                Batal
            </a>

            <form action="{{ $deleteUrl }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-500">
                    Hapus
                </button>
            </form>
        </div>
    </div>

</div>

</x-app-layout>
