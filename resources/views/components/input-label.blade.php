@props(['value'])

<label {{ $attributes->merge(['class' => 'w-full border-gray-300 rounded-lg focus:ring blue-500 focus:border-blue-500']) }}>
    {{ $value ?? $slot }}
</label>
