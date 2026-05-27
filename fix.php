<?php
$dir = new RecursiveDirectoryIterator('resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);
foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $original = $content;

    // Fix malformed HTML tags
    $content = preg_replace('/text->/', 'text-gray-900">', $content);
    $content = preg_replace('/border->/', 'border-gray-200">', $content);
    $content = preg_replace('/bg->/', 'bg-gray-900">', $content);

    // Fix garbled classes
    $content = str_replace('text-bg-white', 'bg-white', $content);
    $content = str_replace('bg-text-white', 'bg-white text-gray-900', $content);
    $content = str_replace('bg-hover:', 'hover:', $content);
    $content = str_replace('bg-rounded-', 'rounded-', $content);
    $content = str_replace('bg-border-', 'border-', $content);
    $content = str_replace('text-leading-', 'leading-', $content);
    $content = str_replace('text-mb-', 'mb-', $content);
    $content = str_replace('text-mt-', 'mt-', $content);
    $content = str_replace('text-uppercase', 'uppercase', $content);
    $content = str_replace('text-truncate', 'truncate', $content);
    $content = str_replace('bg-transition', 'transition', $content);
    
    // Fix prose-invert
    $content = str_replace('prose-invert', '', $content);
    
    // Fix duplicate/conflicting colors left behind (e.g. bg-gray-50 bg-gray-700/50 -> bg-gray-50)
    $content = preg_replace('/(bg-[a-z]+-\d+)\s+bg-[a-z]+-\d+(?:\/\d+)?/', '$1', $content);
    $content = preg_replace('/(text-[a-z]+-\d+)\s+text-[a-z]+-\d+(?:\/\d+)?/', '$1', $content);
    $content = preg_replace('/(border-[a-z]+-\d+)\s+border-[a-z]+-\d+(?:\/\d+)?/', '$1', $content);
    
    // Some garbled combinations like "text-gray-700 text-gray-300 transition-colors"
    $content = str_replace(' bg-gray-700/50', '', $content);
    $content = str_replace(' bg-gray-700', '', $content);
    $content = str_replace(' text-gray-400', '', $content);
    $content = str_replace(' text-gray-300', '', $content);
    $content = str_replace(' border-gray-600', '', $content);
    $content = str_replace(' text-indigo-400', '', $content);
    $content = str_replace(' text-indigo-200', '', $content);
    $content = str_replace(' text-yellow-200', '', $content);
    $content = str_replace(' text-orange-300', '', $content);
    $content = str_replace(' text-purple-400', '', $content);
    $content = str_replace(' text-purple-200', '', $content);
    $content = str_replace(' text-blue-200', '', $content);
    
    // One specific fix for missing quotes from text-gray-900"
    $content = str_replace('class="text-gray-900"', 'class="text-gray-900"', $content);

    if ($content !== $original) {
        file_put_contents($path, $content);
        echo "Fixed: $path\n";
    }
}
