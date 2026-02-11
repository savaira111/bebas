<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>

    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>

<body class="h-full font-sans">

    <div class="min-h-screen w-full bg-cover bg-center bg-no-repeat flex items-center justify-center"
         style="background-image: url('/images/bg-login.jpg');">

        @yield('content')

    </div>

</body>
</html>
