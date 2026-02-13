<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Luxury Beauty') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
        
        <!-- Trix Editor -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
             body {
                font-family: 'Lato', sans-serif;
                background-color: #fdfbfb;
                color: #5d5d5d;
            }
            h1, h2, h3, h4, h5, h6, .font-serif {
                font-family: 'Playfair Display', serif;
            }
            
            /* Luxury Theme Utilities */
            .luxury-gradient {
                background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);
            }
            .text-gold-600 {
                color: #bfa05f;
            }
            .bg-gold-50 {
                background-color: #f9f5eb;
            }
            .border-gold-200 {
                border-color: #e6dcc6;
            }
            .bg-luxury-nude {
                background-color: #fdfbfb; /* Soft Nude/White */
            }
            .luxury-shadow {
                box-shadow: 0 10px 30px rgba(212, 165, 165, 0.1);
            }
            
            /* Form & Inputs */
            input:focus, select:focus, textarea:focus {
                border-color: #d4a5a5 !important;
                --tw-ring-color: #d4a5a5 !important;
                --tw-ring-opacity: 0.2;
            }
            
            /* Buttons */
            .btn-luxury {
                background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%);
                color: white;
                box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4);
                transition: all 0.3s ease;
            }
            .btn-luxury:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(212, 165, 165, 0.6);
            }

            /* Table Styling */
            .luxury-table-head {
                background-color: #faf9f9;
                color: #a08080;
                font-family: 'Playfair Display', serif;
                letter-spacing: 0.05em;
            }
            .luxury-table-row:hover {
                background-color: rgba(255, 240, 245, 0.4);
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            ::-webkit-scrollbar-thumb {
                background: #d4a5a5;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #c29595;
            }
            
            /* SweetAlert Custom */
            .swal2-popup {
                border-radius: 20px !important;
                font-family: 'Lato', sans-serif;
            }
            .swal2-title {
                font-family: 'Playfair Display', serif !important;
                color: #4a4a4a !important;
            }
            .swal2-confirm {
                background: linear-gradient(135deg, #d4a5a5 0%, #c29595 100%) !important;
                box-shadow: 0 4px 15px rgba(212, 165, 165, 0.4) !important;
            }
        </style>
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-luxury-nude flex flex-col">
            
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-50 relative z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                     @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: "{{ session('success') }}",
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'px-6 py-2 rounded-full font-medium text-white'
                                    },
                                    buttonsStyling: false
                                });
                            });
                        </script>
                    @endif

                    {{ $slot }}
                </div>
            </main>
            
            <footer class="bg-white border-t border-gray-100 py-6 mt-auto">
                <div class="max-w-7xl mx-auto px-4 text-center text-gray-400 text-sm font-serif">
                    &copy; {{ date('Y') }} Luxury Beauty Dashboard. All rights reserved.
                </div>
            </footer>
        </div>
        @stack('scripts')
    </body>
</html>
