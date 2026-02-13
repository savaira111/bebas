<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luxury Product Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #fdfbfb; /* Very soft pink/white */
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        .luxury-gradient {
            background: linear-gradient(135deg, #e5b3b3 0%, #d4a5a5 100%);
        }
        .luxury-gold-text {
            color: #bfa05f;
        }
        .luxury-shadow {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="antialiased text-gray-700">
    <div class="min-h-screen">
        @if (isset($header))
            <header class="bg-white shadow-sm border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: "{{ session('success') }}",
                                confirmButtonColor: '#d4a5a5',
                                background: '#fff',
                                color: '#555'
                            });
                        });
                    </script>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
