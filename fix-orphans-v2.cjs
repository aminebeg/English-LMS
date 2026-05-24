/**
 * Third-pass — intelligent class-attribute rebuild
 *
 * For each class="..." attribute in every Blade file:
 *   1. Tokenize the classes (handle Blade {{ }} expressions)
 *   2. For normal Tailwind classes: detect "orphaned" dark-mode classes that
 *      are adjacent to a non-dark sibling in wrong way, and remove them
 *   3. For Blade conditional expressions: inspect each branch separately and
 *      rebuild it, removing any remaining "dark:" prefix
 *
 * After the raw "dark:" → "" strip, the bad patterns we must fix:
 *  A) "text-gray-900 dark:text-gray-100"  →  "text-gray-100"   (wrong: dark wing only)
 *  B) "class="bg-gray-50 dark:bg-gray-900" → "class="bg-gray-50"  (correct if darkMode:false)
 *  C) "class="bg-gray-50 dark:bg-gray-900 bg-white dark:bg-gray-800"  → keep light wings only
 *  D) gradient classes: "from-indigo-50 dark:from-gray-800" → keep "from-indigo-50"
 *  E) inside {{ }}: "bg-white dark:bg-gray-700" → rebuild as "bg-white"
 *  F) text-gray-900 dark:text-gray-100 → text-gray-100  [currently garbled to text-text-gray-100]
 *  G) "text-gray-600 dark:text-gray-400" → "text-gray-400"  (was light, text-gray-400 left)
 *  H) "text-gray-600 dark:text-gray-300" → "text-gray-300"
 *  I) "text-indigo-600 dark:text-indigo-400" → "text-indigo-400"
 *  J) "text-green-600 dark:text-green-400" → "text-green-400"
 *
 * Strategy A: remove all known dark-mode-only color values wherever they
 *   appear as a term (not preceded by part of a light-wing)
 * Strategy B: for garbled leftovers like "text-text-gray-100", replace with
 *   the clean dark wing value
 * Strategy C: for non-garbled correct leftovers (e.g. "bg-gray-800" alone),
 *   remove them
 */
const fs = require('fs');
const path = require('path');

const PROJECT = 'C:\\Users\\pc\\Desktop\\English-LMS';

// All processed blade files
const files = [
  'resources/views/welcome.blade.php',
  'resources/views/learn/lesson.blade.php',
  'resources/views/materials/create.blade.php',
  'resources/views/materials/edit.blade.php',
  'resources/views/lessons/edit.blade.php',
  'resources/views/components/nav-link.blade.php',
  'resources/views/enrollments/show.blade.php',
  'resources/views/tests/show.blade.php',
  'resources/views/dashboard.blade.php',
];

// ── Known artifacts from the naive strip ─────────────────────────────────────

// Pattern F: "text-text-gray-100" etc — garbled from "text-gray-900 dark:text-gray-100"
// The dark: strip turned "text-gray-900 dark:text-gray-100" into "text-gray-100 text-text-gray-100"
// then the double-space collapse merged it. We need to replace the garbled form.
const garbledReplacements = [
  // text-text-gray-100 → text-gray-100
  ['text-text-gray-100', 'text-gray-100'],
  ['text-text-gray-200', 'text-gray-200'],
  ['text-text-gray-300', 'text-gray-300'],
  ['text-text-gray-400', 'text-gray-400'],
  ['text-text-gray-500', 'text-gray-500'],
  ['text-text-gray-600', 'text-gray-600'],
  ['text-text-gray-700', 'text-gray-700'],
  ['text-text-gray-800', 'text-gray-800'],
  ['text-text-gray-900', 'text-gray-900'],
  // more garbled with other prefixes
  ['text-text-indigo-100', 'text-indigo-100'],
  ['text-text-indigo-200', 'text-indigo-200'],
  ['text-text-indigo-300', 'text-indigo-300'],
  ['text-text-indigo-400', 'text-indigo-400'],
  ['text-text-indigo-500', 'text-indigo-500'],
  ['text-text-indigo-600', 'text-indigo-600'],
  ['text-text-indigo-700', 'text-indigo-700'],
  ['text-text-indigo-800', 'text-indigo-800'],
  ['text-text-indigo-900', 'text-indigo-900'],
  // bg-text-gray etc
  ['bg-text-gray-100', 'bg-gray-100'],
  ['bg-text-gray-200', 'bg-gray-200'],
  ['bg-text-gray-300', 'bg-gray-300'],
  ['bg-text-gray-400', 'bg-gray-400'],
  ['bg-text-indigo-100', 'bg-indigo-100'],
  ['bg-text-indigo-200', 'bg-indigo-200'],
  ['bg-text-indigo-300', 'bg-indigo-300'],
  ['bg-text-indigo-400', 'bg-indigo-400'],
];

// ── Dark-mode-only color values to remove ─────────────────────────────────────
// These classes, when appearing WITHOUT a sibling light wing, are dark-only.
// They should be deleted wherever found (but not if they appear alongside a
// near-identical light wing that is a clear pair).
const orphanableDarkClasses = [
  // Gray backgrounds (dark scales)
  'bg-gray-700', 'bg-gray-800', 'bg-gray-900',
  'bg-gray-700/50', 'bg-gray-800/50', 'bg-gray-900/50',
  'bg-gray-700/20', 'bg-gray-800/20', 'bg-gray-900/20',
  'bg-gray-700/30', 'bg-gray-800/30', 'bg-gray-900/30',
  'bg-gray-700/40', 'bg-gray-800/40', 'bg-gray-900/40',
  // Color dark backgrounds
  'bg-indigo-900', 'bg-indigo-900/50', 'bg-indigo-900/30', 'bg-indigo-900/20',
  'bg-purple-900', 'bg-purple-900/50', 'bg-purple-900/20', 'bg-purple-900/30',
  'bg-blue-900', 'bg-blue-900/20',
  'bg-green-900', 'bg-green-900/30',
  'bg-emerald-900',
  'bg-yellow-900/20', 'bg-amber-900/20',
  // Gray text colors
  'text-gray-300', 'text-gray-400', 'text-gray-500',
  // Color text colors (darker/saturated variants only used in dark mode)
  'text-indigo-300', 'text-indigo-400',
  'text-purple-300', 'text-purple-400',
  'text-green-300', 'text-green-400',
  'text-emerald-300', 'text-emerald-400',
  'text-yellow-200', 'text-yellow-300',
  'text-amber-300', 'text-amber-400',
  'text-blue-200', 'text-blue-300',
  // Border dark colors
  'border-gray-600', 'border-gray-700', 'border-gray-800',
  'border-indigo-700', 'border-indigo-600',
  'border-yellow-400', 'border-yellow-500',
  'border-green-700',
  // Dividers
  'divide-gray-700',
];

let totalChanged = 0;

function fixFile(fullPath) {
  let content = fs.readFileSync(fullPath, 'utf-8');
  const before = content;
  let clipboard = 0;

  // ── Step 1: Fix garbled class names ────────────────────────────────────────
  for (const [garbled, replacement] of garbledReplacements) {
    // Only replace garbled if it's NOT a separate occurrence already existing legitimately
    // i.e., context: it appears near ' ' (space) or '"' 
    const count = (content.match(new RegExp(garbled.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g')) || []).length;
    if (count > 0) {
      content = content.replace(new RegExp(garbled.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), replacement);
      clipboard += count;
    }
  }

  // ── Step 2: Remove orphaned dark-only classes ──────────────────────────────
  // Tokenize class attributes (not inside CSS/JS)
  for (const oc of orphanableDarkClasses) {
    const escaped = oc.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    // Match in class="..." contexts: space+before-dark, before_end_attr
    const patterns = [
      ` ${escaped}(?=[ >])`,        // ' oc attr-end'
      ` ${escaped}(?=")`,           // ' oc"'
    ];
    for (const pat of patterns) {
      const re = new RegExp(pat, 'g');
      const matches = content.match(re);
      if (matches) {
        content = content.replace(re, '');
        clipboard += matches.length;
      }
    }
  }

  // ── Step 3: Collapse multi-spaces inside class="" ──────────────────────────
  content = content.replace(/\s+"/g, '"').replace(/\s+>/g, '>');

  // ── Step 4: Remove bare orphanable classes (no space before, e.g. at start) ─
  for (const oc of orphanableDarkClasses) {
    const escaped = oc.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    content = content.replace(new RegExp(`class="${escaped}[ >"]`, 'g'), 'class=""');
    content = content.replace(new RegExp(`class="${escaped}$`, 'g'), 'class=""');
    // Remove from class=" xyz oc
    content = content.replace(new RegExp(`"${escaped}(?=[ >"])`, 'g'), '');
  }

  // ── Step 5: Remove orphaned gradient direction classes ────────────────────
  // orphan: " from-gray-800 to-gray-700 " (gray-700/800 in from/to)
  const gradientOrphans = [
    ' from-gray-700', ' from-gray-800', ' from-gray-900',
    ' to-gray-700', ' to-gray-800', ' to-gray-900',
    ' from-gray-700/50', ' to-gray-700/50',
    ' from-gray-800/50', ' to-gray-800/50',
    ' from-gray-900/50', ' to-gray-900/50',
    ' from-indigo-900', ' to-indigo-900',
    ' from-indigo-900/30', ' to-indigo-900/30',
    ' from-indigo-900/50', ' to-indigo-900/50',
    ' from-purple-900', ' to-purple-900',
    ' from-purple-900/30', ' to-purple-900/30',
    ' from-purple-900/50', ' to-purple-900/50',
  ];
  for (const gdp of gradientOrphans) {
    const re = new RegExp(gdp.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
    const matches = content.match(re);
    if (matches) {
      content = content.replace(re, '');
      clipboard += matches.length;
    }
  }

  // ── Step 6: Remove orphaned /50 or /30 opacity classes that are dark-only ──
  // bg-indigo-900/30, bg-indigo-900/50 etc
  const opacityOrphans = [
    'bg-indigo-900/50', 'bg-indigo-900/30', 'bg-indigo-900/20',
    'bg-purple-900/50', 'bg-purple-900/30', 'bg-purple-900/20',
    'bg-gray-700/50', 'bg-gray-800/50', 'bg-gray-900/50',
  ];
  for (const op of opacityOrphans) {
    const re = new RegExp((` ${op}(?=[ >"])`).replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
    const matches = content.match(re);
    if (matches) {
      content = content.replace(re, '');
      clipboard += matches.length;
    }
  }

  // ── Final cleanup ──────────────────────────────────────────────────────────
  content = content.replace(/\s+"/g, '"').replace(/\s+>/g, '>');
  content = content.replace(/\s{2,}/g, ' ');

  if (content !== before) {
    fs.writeFileSync(fullPath, content, 'utf-8');
    console.log(`✓ ${path.relative(PROJECT, fullPath)}  (${clipboard} fixes)`);
    return clipboard;
  }
  return 0;
}

for (const file of files) {
  const fullPath = path.join(PROJECT, file);
  if (!fs.existsSync(fullPath)) { continue; }
  totalChanged += fixFile(fullPath);
}

console.log(`\n=== ${totalChanged} total fixes across ${files.length} files ===`);
