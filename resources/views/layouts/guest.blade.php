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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
             body {
                font-family: 'Lato', sans-serif;
            }
            .font-serif {
                font-family: 'Playfair Display', serif;
            }
            .luxury-gradient-bg {
                 background: linear-gradient(135deg, #fdfbfb 0%, #fae8e8 100%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased luxury-gradient-bg">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6 animate-fade-in-down">
                <a href="/" class="flex flex-col items-center gap-2 group">
                     <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4a5a5] to-[#c29595] flex items-center justify-center text-white font-serif font-bold text-3xl shadow-xl group-hover:scale-110 transition-transform duration-300">
                        L
                    </div>
                    <span class="font-serif text-2xl text-gray-800 tracking-wide font-medium mt-2">Luxury<span class="text-[#d4a5a5]">Beauty</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-3xl border border-white/50 backdrop-blur-sm relative">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-pink-50 opacity-50 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-32 h-32 rounded-full bg-gold-50 opacity-50 blur-2xl"></div>
                
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-400 font-serif">
                &copy; {{ date('Y') }} Luxury Beauty. All rights reserved.
            </div>
        </div>
    </body>
</html>
