<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { background-color: #fff; padding: 20px; border-radius: 10px; width: 600px; margin: 30px auto; }
        .btn { background-color: #4f46e5; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hai, {{ $name }}</h2>
        <p>Kamu menerima email ini karena kami menerima permintaan untuk mereset password akunmu.</p>
        <p><a class="btn" href="{{ $url }}">Reset Password</a></p>
        <p>Jika kamu tidak meminta reset password, abaikan email ini.</p>
        <p>Salam,<br>Tim Kami</p>
    </div>
</body>
</html>
