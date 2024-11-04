@props([
    'active',
    'icon' => null,
    'icon2' => null,
    ])
@php
$classes = ($active ?? false)
            ? 'inline-flex items-center bg-sky-100 w-full px-2 py-2 rounded border-l-4 border-sky-600 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center w-full px-2 py-2 border-l-4 border-transparent text-sm font-medium leading-5 text-gray-500 hover:bg-gray-200 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes ]) }}>

    @if ($icon)
        {{-- @include("svg.$icon") <!-- Incluye el SVG según el nombre pasado como prop --> --}}
        <svg class="w-5 h-5 text-gray-500 transition  duration-75 dark:text-white  group-hover:text-gray-900"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  fill="currentColor" viewBox="0 0 22 21">
            <path fill-rule="evenodd" d="{{ $icon }}"
                clip-rule="evenodd"/>
            @if ($icon2)
            <path fill-rule="evenodd" d="{{ $icon2 }}"
                clip-rule="evenodd"/>
            @endif
        </svg>

    @endif

    <div class="pl-3">
        {{ $slot }}
    </div>
</a>



{{-- <a href="#"
class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
<svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
    <path
        d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
    <path
        d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
</svg>
<span class="ms-3">Dashboard</span>
</a> --}}
