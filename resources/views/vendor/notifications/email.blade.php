<x-mail::message>
{{-- Logo --}}
<img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 150px; margin-bottom: 20px;">

{{-- Salam Pembuka --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# Oops!
@else
# Halo!
@endif
@endif

{{-- Intro --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Tombol Aksi --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Penutup --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salam Akhir --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Salam,<br>
{{ config('app.name') }}
@endif

{{-- Catatan Tambahan --}}
@isset($actionText)
<x-slot:subcopy>
Jika Anda mengalami kesulitan menekan tombol ":actionText", salin dan tempel URL berikut ke browser Anda:  
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
