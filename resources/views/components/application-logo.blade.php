@php
    $words = explode(' ', config('app.name'));
    $initials = '';
    foreach ($words as $word) {
        if (strlen($word) > 0) {
            $initials .= strtoupper($word[0]);
        }
    }
@endphp

<svg viewBox="0 0 100 34" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <text x="0" y="24" font-family="'Fraunces', serif" font-size="22" font-weight="500" fill="currentColor">{{ $initials }}</text>
    <rect x="0" y="29" width="{{ strlen($initials) * 18 }}" height="2" fill="currentColor" />
</svg>
