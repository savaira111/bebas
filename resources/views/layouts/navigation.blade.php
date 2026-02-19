<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">

    <!-- Menu Navigasi Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="group flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#d4a5a5] to-[#c29595] flex items-center justify-center text-white font-serif font-bold text-xl shadow-lg group-hover:shadow-pink-200 transition-all duration-300">
                            L
                        </div>
                        <span class="font-serif text-xl text-gray-800 tracking-wide font-medium group-hover:text-[#d4a5a5] transition-colors">Luxury<span class="text-[#d4a5a5]">Beauty</span></span>
                    </a>
                </div>

                <!-- Link Navigasi -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center h-full">
                    @unless(request()->routeIs('profile.edit'))
                        @auth
                            @php
                                $navClasses = "inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out h-full border-transparent text-gray-500 hover:text-[#d4a5a5] hover:border-[#d4a5a5] focus:outline-none focus:text-[#d4a5a5] focus:border-[#d4a5a5]";
                                $activeClasses = "inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out h-full border-[#d4a5a5] text-[#c29595] focus:outline-none focus:border-[#d4a5a5]";
                            @endphp



                            <!-- ROLE: ADMIN & SUPERADMIN -->
                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                                
                                @php
                                    $dashboardRoute = Auth::user()->role === 'superadmin' ? 'dashboard.superadmin' : 'dashboard.admin';
                                @endphp

                                <a href="{{ route($dashboardRoute) }}" class="{{ request()->routeIs($dashboardRoute) ? $activeClasses : $navClasses }}">
                                    Dashboard
                                </a>

                                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? $activeClasses : $navClasses }}">
                                    Products
                                </a>

                                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? $activeClasses : $navClasses }}">
                                    Categories
                                </a>

                                <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? $activeClasses : $navClasses }}">
                                    Articles
                                </a>

                                <a href="{{ route('albums.index') }}" class="{{ request()->routeIs('albums.*') ? $activeClasses : $navClasses }}">
                                    Albums
                                </a>

                                <a href="{{ route('galleries.index') }}" class="{{ request()->routeIs('galleries.*') ? $activeClasses : $navClasses }}">
                                    Galleries
                                </a>

                                <a href="{{ route('ebooks.index') }}" class="{{ request()->routeIs('ebooks.*') ? $activeClasses : $navClasses }}">
                                    E-Books
                                </a>

                                @if(Auth::user()->role === 'superadmin')
                                    <a href="{{ route('superadmin.users.index') }}" class="{{ request()->routeIs('superadmin.users.*') ? $activeClasses : $navClasses }}">
                                        Users
                                    </a>
                                @endif
                                
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? $activeClasses : $navClasses }}">
                                        Users
                                    </a>
                                @endif

                            @endif
                        @endauth
                    @endunless
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                 @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                    <button @click="open = ! open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-2">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                             class="h-9 w-9 rounded-full object-cover border-2 border-gray-100 shadow-sm" alt="{{ Auth::user()->name }}" />
                        
                        <div class="text-left hidden md:block">
                            <div class="font-bold text-gray-800 font-serif">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-[#d4a5a5] font-semibold tracking-wider uppercase">{{ Auth::user()->role }}</div>
                        </div>

                        <svg class="ms-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                            x-transition
                            class="absolute right-0 z-50 mt-2 w-48 rounded-2xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 py-1 focus:outline-none"
                            style="display: none;">
                        
                        <div class="block px-4 py-2 text-xs text-gray-400 font-serif border-b border-gray-50">
                            {{ __('Manage Account') }}
                        </div>

                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-[#c29595] transition">
                            {{ __('Landing Page') }}
                        </a>




                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); confirmLogout();"
                               class="block px-4 py-2 text-sm text-red-400 hover:bg-red-50 hover:text-red-600 transition">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-[#d4a5a5] font-medium mr-4">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-gradient-to-r from-[#d4a5a5] to-[#c29595] text-white font-medium shadow-md hover:shadow-lg transition">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Logout?',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d4a5a5',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'text-white px-6 py-2 rounded-full font-bold text-xs uppercase tracking-wider',
                    cancelButton: 'text-gray-600 px-6 py-2 rounded-full font-bold text-xs uppercase tracking-wider hover:bg-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>
    @endpush
</nav>
