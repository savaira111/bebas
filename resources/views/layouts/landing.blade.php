<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Luxury Beauty') }} - @yield('title', 'Elegant & Timeless')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #fdfbfb; /* Soft Nude/White */
            color: #5d5d5d;
        }
        h1, h2, h3, h4, h5, h6, .font-serif {
            font-family: 'Playfair Display', serif;
        }
        
        /* Luxury Color Palette */
        .text-gold-500 { color: #d4af37; }
        .text-gold-600 { color: #bfa05f; }
        .bg-gold-50 { background-color: #f9f5eb; }
        .bg-gold-500 { background-color: #d4af37; }
        
        .text-pink-luxury { color: #d4a5a5; }
        .bg-pink-luxury { background-color: #d4a5a5; }
        .bg-pink-soft { background-color: #fceeee; }
        
        .luxury-gradient {
            background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);
        }
        
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: #d4a5a5;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 transition-all duration-300 shadow-sm" x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="font-serif text-2xl tracking-widest text-gray-800 hover:text-pink-luxury transition duration-300">
                        LUXURY<span class="text-pink-luxury">BEAUTY</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="nav-link text-sm uppercase tracking-wider text-gray-600 hover:text-gray-900 {{ request()->routeIs('home') ? 'text-pink-luxury' : '' }}">Home</a>
                    <a href="{{ route('landing.about') }}" class="nav-link text-sm uppercase tracking-wider text-gray-600 hover:text-gray-900 {{ request()->routeIs('landing.about') ? 'text-pink-luxury' : '' }}">About</a>
                    <a href="{{ route('landing.products') }}" class="nav-link text-sm uppercase tracking-wider text-gray-600 hover:text-gray-900 {{ request()->routeIs('landing.products') ? 'text-pink-luxury' : '' }}">Products</a>
                    <a href="{{ route('landing.galleries') }}" class="nav-link text-sm uppercase tracking-wider text-gray-600 hover:text-gray-900 {{ request()->routeIs('landing.galleries') ? 'text-pink-luxury' : '' }}">Gallery</a>
                    <a href="{{ route('landing.articles') }}" class="nav-link text-sm uppercase tracking-wider text-gray-600 hover:text-gray-900 {{ request()->routeIs('landing.articles') ? 'text-pink-luxury' : '' }}">Artikel</a>
                    <a href="{{ route('landing.ebooks') }}" class="nav-link text-sm uppercase tracking-wider text-gray-600 hover:text-gray-900 {{ request()->routeIs('landing.ebooks') ? 'text-pink-luxury' : '' }}">Ebooks</a>
                    
                    @auth
                        <!-- User Dropdown (Desktop) -->
                        <div class="relative" x-data="{ userOpen: false }">
                            <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="flex items-center space-x-2 text-sm font-serif text-pink-luxury font-bold hover:text-gray-900 transition focus:outline-none">
                                <span>Hi, {{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': userOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100"
                                 style="display: none;">
                                
                                @if(Auth::user()->hasRole('superadmin'))
                                    <a href="{{ route('dashboard.superadmin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-luxury transition">Dashboard</a>
                                @elseif(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('dashboard.admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-luxury transition">Dashboard</a>
                                @endif

                                @if(Auth::user()->hasRole('user'))
                                    <a href="{{ route('user.articles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-luxury transition">Artikel Saya</a>
                                @endif
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm uppercase tracking-wider text-gray-900 hover:text-pink-luxury transition font-medium">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 text-sm uppercase tracking-wider text-white bg-pink-luxury hover:bg-gray-800 transition rounded-full shadow-lg">Register</a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-t border-gray-100">
            <div class="pt-2 pb-4 space-y-1 px-4">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-pink-luxury hover:bg-gray-50 rounded-md">Home</a>
                <a href="{{ route('landing.about') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-pink-luxury hover:bg-gray-50 rounded-md">About</a>
                <a href="{{ route('landing.products') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-pink-luxury hover:bg-gray-50 rounded-md">Products</a>
                <a href="{{ route('landing.galleries') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-pink-luxury hover:bg-gray-50 rounded-md">Gallery</a>
                <a href="{{ route('landing.articles') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-pink-luxury hover:bg-gray-50 rounded-md">Articles</a>
                <a href="{{ route('landing.ebooks') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-pink-luxury hover:bg-gray-50 rounded-md">Ebooks</a>
                @auth
                    <!-- Mobile User Menu -->
                    <div class="pt-4 pb-2 border-t border-gray-100 mt-4">
                        <div class="flex items-center px-3">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-luxury font-bold font-serif">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            @if(Auth::user()->hasRole('superadmin'))
                                <a href="{{ route('dashboard.superadmin') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-pink-luxury hover:bg-gray-50 rounded-md transition">Dashboard</a>
                            @elseif(Auth::user()->hasRole('admin'))
                                <a href="{{ route('dashboard.admin') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-pink-luxury hover:bg-gray-50 rounded-md transition">Dashboard</a>
                            @endif
                            @if(Auth::user()->hasRole('user'))
                                <a href="{{ route('user.articles.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-pink-luxury hover:bg-gray-50 rounded-md transition">Artikel Saya</a>
                            @endif
                            
                             <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 text-base font-medium text-red-500 hover:bg-red-50 rounded-md transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center mt-4 px-5 py-3 text-base font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full text-center mt-2 px-5 py-3 text-base font-medium text-white bg-pink-luxury hover:bg-pink-600 rounded-md">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Brand -->
                <div class="space-y-4">
                    <h3 class="font-serif text-2xl tracking-widest">LUXURY<span class="text-pink-luxury">BEAUTY</span></h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Redefining elegance with premium beauty products designed to enhance your natural radiants. Experience the touch of luxury.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h4 class="font-serif text-lg text-pink-luxury">Explore</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('landing.about') }}" class="hover:text-white transition">Our Story</a></li>
                        <li><a href="{{ route('landing.products') }}" class="hover:text-white transition">Collections</a></li>
                        <li><a href="{{ route('landing.articles') }}" class="hover:text-white transition">Artikel</a></li>
                        <li><a href="{{ route('landing.galleries') }}" class="hover:text-white transition">Gallery</a></li>
                        <li><a href="{{ route('landing.contact') }}" class="hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Newsletter / Contact -->
                <div class="space-y-4">
                    <h4 class="font-serif text-lg text-pink-luxury">Connect</h4>
                    <p class="text-gray-400 text-sm">Stay updated with our latest collections.</p>
                     <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pink-luxury transition"><span class="sr-only">Instagram</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    </div>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} Luxury Beauty. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-cubic',
        });

        // Logout Confirmation
        document.querySelectorAll('form[action="{{ route('logout') }}"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan keluar dari sesi ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d4a5a5',
                    cancelButtonColor: '#f3f4f6',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'text-white px-6 py-2 rounded-full font-medium',
                        cancelButton: 'text-gray-600 px-6 py-2 rounded-full hover:bg-gray-100 font-medium'
                    },
                    background: '#fff',
                    color: '#555'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Success Message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d4a5a5',
                customClass: {
                    confirmButton: 'px-6 py-2 rounded-full font-medium text-white'
                }
            });
        @endif
    </script>
</body>
</html>
