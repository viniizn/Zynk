@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium border-l-4 transition duration-150 ease-in-out
       text-indigo-700 bg-indigo-50 border-indigo-400
       hover:bg-indigo-100 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700
       dark:text-white dark:bg-gray-700 dark:border-indigo-500 dark:hover:bg-gray-600 dark:focus:bg-gray-600'
    : 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium border-l-4 transition duration-150 ease-in-out
       text-gray-600 border-transparent
       hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300
       focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300
       dark:text-gray-200 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700';
@endphp


<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
