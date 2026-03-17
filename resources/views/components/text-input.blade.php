@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-gray-300 rounded-lg focus:ring purple-500 focus:border-purple-500']) }}>
