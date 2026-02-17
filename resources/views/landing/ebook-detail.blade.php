@extends('layouts.landing')

@section('title', $ebook->title)

@section('content')
    <div class="bg-white min-h-screen py-12 md:py-20 px-4">
        <div class="max-w-6xl mx-auto">
            
            {{-- Breadcrumb / Back --}}
            <div class="mb-8" data-aos="fade-right">
                <a href="{{ route('landing.ebooks') }}" class="group inline-flex items-center text-gray-500 hover:text-pink-luxury transition-colors">
                    <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="text-xs uppercase tracking-widest font-medium">Back to Library</span>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden" data-aos="fade-up">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                
                    {{-- Left: Cover Info --}} 
                    <div class="md:col-span-5 relative bg-[#fdfbfb] p-8 md:p-12 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                        {{-- Cover Image --}}
                        <div class="relative w-full max-w-[280px] shadow-2xl rounded-sm overflow-hidden transform transition hover:scale-[1.02] duration-500">
                             @if($ebook->cover)
                                <img src="{{ asset('storage/' . $ebook->cover) }}" alt="{{ $ebook->title }}" class="w-full h-auto object-cover">
                            @else
                                <div class="w-full aspect-[3/4] bg-gray-100 flex items-center justify-center text-gray-400">
                                    <span class="font-serif italic">No Cover</span>
                                </div>
                            @endif
                        </div>

                        {{-- Stats --}}
                        <div class="mt-10 flex items-center justify-around w-full max-w-[280px] text-gray-500 text-sm border-t border-gray-200 pt-6">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-pink-luxury font-bold text-lg">{{ number_format($ebook->total_download) }}</span>
                                <span class="text-xs uppercase tracking-wider text-gray-400">Downloads</span>
                            </div>
                            <div class="w-px h-8 bg-gray-200"></div>
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-gray-900 font-bold text-lg">{{ $ebook->created_at->format('M Y') }}</span>
                                <span class="text-xs uppercase tracking-wider text-gray-400">Published</span>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Details --}}
                    <div class="md:col-span-7 p-8 md:p-12 flex flex-col">
                        <div class="mb-auto">
                            <span class="text-pink-luxury uppercase tracking-widest text-xs font-bold mb-3 block">Premium Ebook</span>
                            <h1 class="font-serif text-3xl md:text-4xl text-gray-900 mb-8 leading-tight">
                                {{ $ebook->title }}
                            </h1>
                            
                            <div class="prose prose-sm md:prose-base prose-gray max-w-none font-light text-gray-600 leading-relaxed">
                                {!! nl2br(e($ebook->description)) !!}
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-gray-100">
                            {{-- View Ebook (Open in New Tab) --}}
                             @if($ebook->pdf)
                                <a href="{{ asset('storage/' . $ebook->pdf) }}" target="_blank" 
                                   class="flex-1 py-4 px-6 rounded-sm border border-gray-300 text-gray-600 hover:text-gray-900 hover:border-gray-900 text-center text-xs font-bold tracking-widest uppercase transition-all duration-300 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Preview
                                </a>
                            @endif

                            {{-- Download Ebook --}}
                            <button onclick="handleDownload()" 
                                    class="flex-1 py-4 px-6 rounded-sm bg-gray-900 text-white hover:bg-pink-luxury hover:text-white font-bold tracking-widest uppercase shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Guide
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Captcha Modal --}}
    @auth
    <div id="captchaModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-sm transform scale-95 transition-transform duration-300 relative">
            <button onclick="closeCaptchaModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="text-center mb-6">
                <span class="text-pink-luxury uppercase tracking-widest text-xs font-bold mb-1 block">Security Check</span>
                <h3 class="font-serif text-2xl text-gray-900">Verify Download</h3>
            </div>
            
            <form action="{{ route('landing.ebooks.download', $ebook->id) }}" method="POST">
                @csrf
                <div class="space-y-4 mb-6">
                    <div class="flex justify-center bg-gray-50 p-4 rounded border border-gray-100">
                        {!! captcha_img() !!}
                    </div>
                    <div>
                        <input type="text" name="captcha" required placeholder="Enter Captcha Code" 
                               class="w-full bg-white border border-gray-300 rounded-sm px-4 py-3 text-gray-900 text-center tracking-widest uppercase focus:outline-none focus:border-pink-luxury focus:ring-1 focus:ring-pink-luxury transition-all placeholder:text-xs">
                    </div>
                </div>
                
                <button type="submit" 
                        class="w-full py-3 rounded-sm bg-gray-900 text-white text-xs font-bold uppercase tracking-widest hover:bg-pink-luxury transition-colors">
                    Start Download
                </button>
            </form>
        </div>
    </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function handleDownload() {
            @guest
                Swal.fire({
                    // icon: 'info',
                    title: '<span class="font-serif text-2xl text-gray-900">Member Exclusive</span>',
                    html: '<p class="text-gray-500 font-light mt-2">Please login to access our premium resources and guides.</p>',
                    confirmButtonText: 'LOGIN NOW',
                    confirmButtonColor: '#111827', // Gray-900
                    background: '#ffffff',
                    color: '#374151',
                    showCancelButton: true,
                    cancelButtonText: 'CANCEL',
                    cancelButtonColor: '#9ca3af',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'px-6 py-3 bg-gray-900 text-white text-xs uppercase tracking-widest font-bold rounded-sm hover:bg-pink-luxury transition-colors mr-2',
                        cancelButton: 'px-6 py-3 bg-gray-200 text-gray-600 text-xs uppercase tracking-widest font-bold rounded-sm hover:bg-gray-300 transition-colors',
                        popup: 'rounded-lg shadow-xl border-t-4 border-pink-luxury'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const currentUrl = window.location.href;
                        window.location.href = "{{ route('login') }}?return_url=" + encodeURIComponent(currentUrl);
                    }
                });
            @else
                openCaptchaModal();
            @endguest
        }

        @auth
        const modal = document.getElementById('captchaModal');
        const modalContent = modal.querySelector('div');

        function openCaptchaModal() {
            modal.classList.remove('hidden');
            void modal.offsetWidth; 
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }

        function closeCaptchaModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
        @endauth
        
        @if($errors->has('captcha'))
            @auth
            document.addEventListener('DOMContentLoaded', () => {
                openCaptchaModal();
                Swal.fire({
                    icon: 'error',
                    title: 'Verification Failed',
                    text: '{{ $errors->first('captcha') }}',
                    confirmButtonColor: '#111827',
                    background: '#fff',
                    color: '#374151'
                });
            });
            @endauth
        @endif
    </script>
@endsection
