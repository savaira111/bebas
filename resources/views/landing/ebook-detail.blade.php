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
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-pink-luxury uppercase tracking-widest text-[10px] font-bold block">Premium Ebook</span>
                                @if($ebook->is_auth_required)
                                    <span class="bg-red-500 text-white text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Member Only</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border border-gray-200">Public</span>
                                @endif
                            </div>
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


                            {{-- Download Ebook --}}
                            <button onclick="handleDownload()" 
                                    class="w-full py-4 px-6 rounded-sm bg-gray-900 text-white hover:bg-pink-luxury hover:text-white font-bold tracking-widest uppercase shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Guide
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Download Modal (OTP Flow) --}}
    <div id="downloadModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-sm transform scale-95 transition-transform duration-300 relative">
            <button onclick="closeDownloadModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div id="modalContent">
                {{-- Step 1: Identity --}}
                <div id="step-identity" class="">
                    <div class="text-center mb-6">
                        <span class="text-pink-luxury uppercase tracking-widest text-xs font-bold mb-1 block">Verify Identity</span>
                        <h3 class="font-serif text-2xl text-gray-900 border-b border-gray-100 pb-2">Enter Details</h3>
                        <p class="text-xs text-gray-400 mt-2 italic">Fill in your information to receive a verification code.</p>
                    </div>
                    
                    <form id="form-identity" onsubmit="event.preventDefault(); sendOtp();">
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest font-bold text-gray-400 mb-1 ml-1" style="font-family: 'Lato', sans-serif;">Full Name</label>
                                <input type="text" id="guest_name" required placeholder="Your Name" 
                                       class="w-full bg-gray-50/50 border border-gray-200 rounded-sm px-4 py-3 text-gray-900 focus:outline-none focus:border-pink-luxury focus:ring-1 focus:ring-pink-luxury transition-all text-sm">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest font-bold text-gray-400 mb-1 ml-1" style="font-family: 'Lato', sans-serif;">Email Address</label>
                                <input type="email" id="guest_email" required placeholder="yourname@example.com" 
                                       class="w-full bg-gray-50/50 border border-gray-200 rounded-sm px-4 py-3 text-gray-900 focus:outline-none focus:border-pink-luxury focus:ring-1 focus:ring-pink-luxury transition-all text-sm">
                            </div>
                        </div>
                        
                        <button type="submit" id="btn-send-otp"
                                class="w-full py-4 rounded-sm bg-gray-900 text-white text-xs font-bold uppercase tracking-widest hover:bg-pink-luxury transition-all shadow-lg flex items-center justify-center gap-2">
                            <span>Send Verification Code</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>

                {{-- Step 2: Verification --}}
                <div id="step-otp" class="hidden">
                    <div class="text-center mb-6">
                        <span class="text-pink-luxury uppercase tracking-widest text-xs font-bold mb-1 block">Check Your Inbox</span>
                        <h3 class="font-serif text-2xl text-gray-900 border-b border-gray-100 pb-2">Verification</h3>
                        <p class="text-[10px] text-gray-400 mt-2">Enter the 6-digit code sent to your email.</p>
                    </div>
                    
                    <form id="form-otp" onsubmit="event.preventDefault(); verifyOtp();">
                        <div class="space-y-4 mb-6">
                            <input type="text" id="otp_code" required maxlength="6" placeholder="000000" 
                                   class="w-full bg-gray-50 border border-gray-300 rounded-sm px-4 py-4 text-gray-900 text-center text-3xl tracking-[10px] font-bold focus:outline-none focus:border-pink-luxury focus:ring-1 focus:ring-pink-luxury transition-all">
                        </div>
                        
                        <button type="submit" id="btn-verify-otp"
                                class="w-full py-4 rounded-sm bg-[#d4a5a5] text-white text-xs font-bold uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg">
                            Verify & Download
                        </button>

                        <div class="mt-4 text-center">
                            <button type="button" onclick="backToIdentity()" class="text-[10px] text-gray-400 hover:text-pink-luxury font-bold uppercase tracking-widest flex items-center justify-center gap-1 mx-auto transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                                Change Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden form for final download submit --}}
    <form id="finalDownloadForm" action="{{ route('landing.ebooks.download', $ebook->id) }}" method="POST" class="hidden">
        @csrf
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const downloadModal = document.getElementById('downloadModal');
        const modalInner = downloadModal.querySelector('div');
        const stepIdentity = document.getElementById('step-identity');
        const stepOtp = document.getElementById('step-otp');

        function openDownloadModal() {
            downloadModal.classList.remove('hidden');
            void downloadModal.offsetWidth; 
            downloadModal.classList.remove('opacity-0');
            modalInner.classList.remove('scale-95');
            modalInner.classList.add('scale-100');
        }

        function closeDownloadModal() {
            downloadModal.classList.add('opacity-0');
            modalInner.classList.remove('scale-100');
            modalInner.classList.add('scale-95');
            setTimeout(() => {
                downloadModal.classList.add('hidden');
                backToIdentity(); // Reset state
            }, 300);
        }

        function backToIdentity() {
            stepOtp.classList.add('hidden');
            stepIdentity.classList.remove('hidden');
        }

        function showOtpStep() {
            stepIdentity.classList.add('hidden');
            stepOtp.classList.remove('hidden');
        }

        function handleDownload() {
            @auth
                // Authenticated users get direct download
                document.getElementById('finalDownloadForm').submit();
            @else
                @if($ebook->is_auth_required)
                    // Protected ebook for guest: Show login prompt
                    Swal.fire({
                        title: '<span class="font-serif text-2xl text-gray-900">Member Exclusive</span>',
                        html: '<p class="text-gray-500 font-light mt-2">Sila log masuk terlebih dahulu untuk mengakses sumber premium ini.</p>',
                        confirmButtonText: 'LOGIN SEKARANG',
                        confirmButtonColor: '#111827',
                        background: '#ffffff',
                        color: '#374151',
                        showCancelButton: true,
                        cancelButtonText: 'BATAL',
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
                    // Public ebook for guest: Show OTP modal
                    openDownloadModal();
                @endif
            @endauth
        }

        async function sendOtp() {
            const btn = document.getElementById('btn-send-otp');
            const name = document.getElementById('guest_name').value;
            const email = document.getElementById('guest_email').value;

            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...';

            try {
                const response = await fetch("{{ route('landing.ebooks.send-otp', $ebook->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name, email })
                });

                const data = await response.json();

                if (data.success) {
                    showOtpStep();
                } else {
                    Swal.fire('Kesalahan', data.message || 'Gagal mengirim OTP.', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Kesalahan', 'Terjadi kesalahan sistem.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<span>Send Verification Code</span> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
            }
        }

        async function verifyOtp() {
            const btn = document.getElementById('btn-verify-otp');
            const otp = document.getElementById('otp_code').value;

            btn.disabled = true;
            btn.innerHTML = 'Verifying...';

            try {
                const response = await fetch("{{ route('landing.ebooks.verify-otp', $ebook->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ otp })
                });

                if (response.ok) {
                    closeDownloadModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Verification Success',
                        text: 'Your download will start shortly.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    setTimeout(() => {
                        document.getElementById('finalDownloadForm').submit();
                    }, 1000);
                } else {
                    const data = await response.json();
                    Swal.fire('Verification Failed', data.message || 'Invalid code.', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'An error occurred during verification.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Verify & Download';
            }
        }
    </script>
@endsection
