<?php
$path = 'resources/views/dashboard.blade.php';
$content = file_get_contents($path);

// Fix bg-relative
$content = str_replace('bg-relative', 'relative', $content);

// Fix overriding bg-gray-900
$content = str_replace('bg-blue-100 text-blue-800 bg-gray-900', 'bg-blue-100 text-blue-800', $content);

// Fix bg-flex
$content = str_replace('bg-flex', 'flex', $content);

// Fix text-hover:bg-gray-50 hover:bg-gray-900
$content = str_replace('text-hover:bg-gray-50 hover:bg-gray-900', 'hover:bg-gray-50 text-gray-700', $content);

// Fix hover:text-hover:text-white
$content = str_replace('hover:text-hover:text-white', 'hover:text-gray-900', $content);

// Fix button transition garble
$content = str_replace('active:bg-focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transition', 'active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition', $content);

// Fix bg-text-indigo-600
$content = str_replace('bg-text-indigo-600', 'text-indigo-600', $content);

// Fix divide->
$content = str_replace('divide->', '">', $content);

// Fix bg-text-green-200 and yellow-200
$content = str_replace('bg-text-green-200', '', $content);
$content = str_replace('bg-text-yellow-200', '', $content);

// Fix hover:text-hover:mr-4
$content = str_replace('hover:text-hover:mr-4', 'hover:text-indigo-900 mr-4', $content);

file_put_contents($path, $content);
echo "dashboard classes fixed\n";
