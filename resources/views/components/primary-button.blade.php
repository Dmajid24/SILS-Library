<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700']) }}>
    {{ $slot }}
</button>
