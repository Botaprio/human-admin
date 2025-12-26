@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm transition-all duration-300 hover:shadow-md focus:shadow-lg']) !!}>
