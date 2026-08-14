@props(['active'])
@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-ledger text-sm font-medium leading-5 text-ink focus:outline-none focus:border-ledger transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-ink hover:border-hairline focus:outline-none focus:text-ink focus:border-hairline transition duration-150 ease-in-out';
@endphp
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>