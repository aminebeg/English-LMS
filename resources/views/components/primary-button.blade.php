<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-600/50 shadow-indigo-400/30 hover:shadow-indigo-500/40 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform hover:-translate-y-0.5 transition-all duration-200 ease-out disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none']) }}>
    {{ $slot }}
</button>

