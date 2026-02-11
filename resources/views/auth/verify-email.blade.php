<x-guest-layout>
    <div class="bg-[#212844] text-white rounded-2xl shadow-2xl p-6 max-w-md mx-auto mt-20">

        <h1 class="text-2xl font-bold mb-3 text-center">
            Verifikasi Email Anda
        </h1>

        <p class="text-gray-300 mb-6 text-center">
            Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi email Anda dengan mengklik tautan yang kami kirim ke kotak masuk Anda.
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="mb-4 text-green-400 text-center font-medium">
                Tautan verifikasi baru telah dikirim ke email Anda!
            </p>
        @endif

        <div class="flex flex-col gap-4">

            <!-- Resend Email -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-green-600 text-white rounded-xl py-2 font-semibold hover:bg-green-700 transition">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <!-- Cancel / Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-red-600 text-white rounded-xl py-2 font-semibold hover:bg-red-700 transition">
                    Cancel
                </button>
            </form>
        </div>

    </div>
</x-guest-layout>
