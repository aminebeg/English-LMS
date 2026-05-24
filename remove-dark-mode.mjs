const fs = require('fs');
const path = require('path');

const PROJECT = 'C:\\Users\\pc\\Desktop\\English-LMS';

const files = [
  'resources/views/welcome.blade.php',
  'resources/views/learn/lesson.blade.php',
  'resources/views/materials/create.blade.php',
  'resources/views/materials/edit.blade.php',
  'resources/views/lessons/edit.blade.php',
  'resources/views/components/nav-link.blade.php',
];

// Ordered replacements so later ones don't trample earlier matches
const replacements = [

  // ── Remove .dark CSS selectors (lessons/edit.blade.php inline styles) ──────
  ['\n        .dark .ql-toolbar {', '\n        /* dark theme removed permanently */\n        /* .dark .ql-toolbar {'],
  ['\n        .dark .ql-container {', '\n        /* dark theme removed permanently */\n        /* .dark .ql-container {'],
  ['\n        .dark .ql-stroke {', '\n        /* dark theme removed permanently */\n        /* .dark .ql-stroke {'],
  ['\n        .dark .ql-fill {', '\n        /* dark theme removed permanently */\n        /* .dark .ql-fill {'],
  ['\n        .dark .ql-picker {', '\n        /* dark theme removed permanently */\n        /* .dark .ql-picker {'],
  ['\n        .dark .sortable-ghost {', '\n        /* dark theme removed permanently */\n        /* .dark .sortable-ghost {'],

  // Close each opened comment block
  ['        /* dark theme removed permanently */\n        /* .dark .ql-toolbar {', '        /* (dark .ql-toolbar block removed) */'],
  ['        /* dark theme removed permanently */\n        /* .dark .ql-container {', '        /* (dark .ql-container block removed) */'],
  ['        /* dark theme removed permanently */\n        /* .dark .ql-stroke {', '        /* (dark .ql-stroke block removed) */'],
  ['        /* dark theme removed permanently */\n        /* .dark .ql-fill {', '        /* (dark .ql-fill block removed) */'],
  ['        /* dark theme removed permanently */\n        /* .dark .ql-picker {', '        /* (dark .ql-picker block removed) */'],
  ['        /* dark theme removed permanently */\n        /* .dark .sortable-ghost {', '        /* (dark .sortable-ghost block removed) */'],

  // ── Pattern: dark not- → not- (tackle "not-" before word classes too) ──────
  ['dark:', ''],
];

let totalChanges = 0;

for (const file of files) {
  const fullPath = path.join(PROJECT, file);
  let content = fs.readFileSync(fullPath, 'utf-8');
  const before = content;

  for (const [search, replace] of replacements) {
    const matches = content.match(new RegExp(search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'));
    if (matches) {
      content = content.split(search).join(replace);
    }
  }

  if (content !== before) {
    fs.writeFileSync(fullPath, content, 'utf-8');
    const changes = (before.match(/dark:/g) || []).length;
    totalChanges += changes;
    console.log(`✓ ${file}  (removed ~${changes} dark: references)`);
  } else {
    console.log(`  ${file}  (no dark: references found)`);
  }
}

console.log(`\nDone. ~${totalChanges} dark: references stripped from ${files.length} files.`);
