<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 active:bg-red-800 bg-red-600 hover:bg-red-700 active:bg-red-800 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide shadow-lg shadow-red-500/50 hover:shadow-xl hover:shadow-red-600/50 shadow-red-600/30 hover:shadow-red-700/40 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform hover:-translate-y-0.5 transition-all duration-200 ease-out disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none']) }}>
    {{ $slot }}
</button>

