<x-mail::message>
# Verification Code for E-Book Download

Hello, **{{ $name }}**!

Thank you for your interest in our premium E-Book: **{{ $ebookTitle }}**.

To proceed with your download, please use the verification code below:

<x-mail::panel>
<h1 style="text-align: center; color: #d4a5a5; letter-spacing: 10px; margin: 0;">{{ $otp }}</h1>
</x-mail::panel>

This code will expire in 10 minutes. If you did not request this code, please ignore this email.

Warm regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
