@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full px-4 py-3 border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50']) }}>
