<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-sm text-gray-700 uppercase tracking-wide shadow-sm hover:bg-gray-50 hover:bg-gray-700 hover:border-gray-400 hover:border-gray-500 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform hover:-translate-y-0.5 transition-all duration-200 ease-out disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none']) }}>
    {{ $slot }}
</button>

