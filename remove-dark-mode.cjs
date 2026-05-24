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

const replacements = [

  // ── Remove .dark CSS selectors in inline styles section ────────────────────
  // Convert ".dark .ql-toolbar { ... }" → ".ql-toolbar { ... }" (light-mode always)
  ['\n        .dark .ql-toolbar {', '\n        .ql-toolbar {'],
  ['\n        .dark .ql-container {', '\n        .ql-container {'],
  ['\n        .dark .ql-stroke {', '\n        .ql-stroke {'],
  ['\n        .dark .ql-fill {', '\n        .ql-fill {'],
  ['\n        .dark .ql-picker {', '\n        .ql-picker {'],
  ['\n        .dark .sortable-ghost {', '\n        .sortable-ghost {'],

  // ── Also update the dark colour values inside those blocks to light-mode ───
  //   .dark .ql-toolbar  → background-color:#f3f4f6 (gray-100)
  ['background-color: #374151;', 'background-color: #f3f4f6;'],
  //   .dark .ql-container  → border-color:#e5e7eb, color inherit
  ['background-color: #1f2937;', 'background-color: #ffffff;'],
  ['color: white;', 'color: inherit;'],
  //   .dark .ql-stroke  → stroke:#4b5563 (gray-600)
  ['stroke: #9ca3af !important;', 'stroke: #6b7280 !important;'],
  //   .dark .ql-fill  → fill:#6b7280
  ['fill: #9ca3af !important;', 'fill: #374151 !important;'],
  //   .dark .ql-picker  → color:#374151
  ['color: #9ca3af !important;', 'color: #374151 !important;'],
  //   .dark .sortable-ghost  → background:#f3f4f6 already light, remove override
  ['\n        background: #374151;', ''],

  // ── Finally strip every "dark:" prefixed Tailwind variant ─────────────────
  ['dark:', ''],
];

let totalChanges = 0;

for (const file of files) {
  const fullPath = path.join(PROJECT, file);
  let content = fs.readFileSync(fullPath, 'utf-8');
  const before = content;

  for (const [search, replace] of replacements) {
    if (content.includes(search)) {
      content = content.split(search).join(replace);
    }
  }

  if (content !== before) {
    fs.writeFileSync(fullPath, content, 'utf-8');
    const changes = (before.match(/dark:/g) || []).length;
    totalChanges += changes;
    console.log(`✓ ${file}  (~${changes} dark: refs stripped)`);
  } else {
    console.log(`  ${file}  (no dark: refs)`);
  }
}

console.log(`\nDone. ~${totalChanges} dark: refs stripped from ${files.length} files.`);
