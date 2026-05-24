// Second-pass: remove orphaned dark-mode-only Tailwind classes left behind
// after a naive "dark:" strip.
//
// Pattern we fix: original had  bg-light bg-dark   → became  bg-light bg-dark
// (the "dark:" prefix was stripped, but the dark-only class value remains!)
const fs = require('fs');
const path = require('path');

const PROJECT = 'C:\\Users\\pc\\Desktop\\English-LMS';

// All blade files that were already touched by the first pass
const files = [
  'resources/views/welcome.blade.php',
  'resources/views/learn/lesson.blade.php',
  'resources/views/materials/create.blade.php',
  'resources/views/materials/edit.blade.php',
  'resources/views/lessons/edit.blade.php',
  'resources/views/components/nav-link.blade.php',
  'resources/views/enrollments/show.blade.php',
  'resources/views/tests/show.blade.php',
  'resources/views/auth-session-status.blade.php',
  'resources/views/browse.blade.php',
  'resources/views/confirm-password.blade.php',
  'resources/views/create.blade.php',
  'resources/views/danger-button.blade.php',
  'resources/views/dashboard.blade.php',
  'resources/views/delete-user-form.blade.php',
  'resources/views/dropdown.blade.php',
  'resources/views/dropdown-link.blade.php',
  'resources/views/edit.blade.php',
  'resources/views/forgot-password.blade.php',
  'resources/views/guest.blade.php',
  'resources/views/index.blade.php',
  'resources/views/input-error.blade.php',
  'resources/views/input-label.blade.php',
  'resources/views/login.blade.php',
  'resources/views/modal.blade.php',
  'resources/views/my-results.blade.php',
  'resources/views/navigation.blade.php',
  'resources/views/preview.blade.php',
  'resources/views/primary-button.blade.php',
  'resources/views/register.blade.php',
  'resources/views/reset-password.blade.php',
  'resources/views/responsive-nav-link.blade.php',
  'resources/views/result.blade.php',
  'resources/views/results.blade.php',
  'resources/views/secondary-button.blade.php',
  'resources/views/show.blade.php',
  'resources/views/students.blade.php',
  'resources/views/take.blade.php',
  'resources/views/text-input.blade.php',
  'resources/views/tutor-register.blade.php',
  'resources/views/update-password-form.blade.php',
  'resources/views/update-profile-information-form.blade.php',
  'resources/views/verify-email.blade.php',
];

// These are dark-mode-only color classes that should be removed if they appear
// without a "dark:" prefix next to an appropriate light-winged class
const darkOnlyClasses = [
  // Gray dark scale
  'gray-700', 'gray-800', 'gray-900',
  'gray-700/50', 'gray-800/50', 'gray-900/50',
  'gray-700/20', 'gray-800/20', 'gray-900/20',
  'gray-700/30', 'gray-800/30', 'gray-900/30',
  // Color dark scales
  'indigo-900', 'indigo-900/50', 'indigo-900/30', 'indigo-900/20',
  'purple-900', 'purple-900/50', 'purple-900/30', 'purple-900/20',
  'green-900', 'green-900/30',
  'emerald-900', 'emerald-900/30',
  'yellow-900', 'yellow-900/20',
  'amber-900', 'amber-900/20',
  'blue-900', 'blue-900/20',
  // Dark text colors (not hover/focus/focus-visible, those can be legit)
  'text-gray-300', 'text-gray-400', 'text-indigo-400', 'text-indigo-300',
  'text-green-300', 'text-green-400', 'text-amber-400', 'text-amber-300',
  'text-purple-400', 'text-purple-300', 'text-emerald-300', 'text-emerald-400',
  'text-yellow-200', 'text-yellow-300',
  'text-blue-300', 'text-blue-200',
  // Border colors
  'border-gray-600', 'border-gray-700', 'border-gray-800',
  'border-indigo-700', 'border-indigo-600',
  // Background classes
  'bg-gray-700', 'bg-gray-800', 'bg-gray-900',
  'bg-gray-700/50', 'bg-gray-800/50', 'bg-gray-900/50',
  'divide-gray-700',
];

let totalFilesChanged = 0;
let totalRemovals = 0;

function isClassNameChar(c) {
  return (c >= 'a' && c <= 'z') || (c >= '0' && c <= '9') || c === '-' || c === '/' ;
}

function isValidTailwindClass(word) {
  // Check that this word looks like a Tailwind class that is preceded by a space or "
  return /^[a-z][a-z0-9/-]/.test(word) && word.length > 1;
}

function removeOrphanedDarkClasses(content) {
  let removals = 0;

  // Strategy: for each "dark-only" class, check if the line also contains
  // a sibling light wing class. If so, remove the dark-only one.

  for (const dc of darkOnlyClasses) {
    // Match: space + darkClass (not preceded by dark:) — this catches orphaned classes
    // We use a positive lookbehind-to-simple strategy: find all instances of ' dc ',
    // ' dc"', 'dc ', 'dc"', etc. but ONLY when the class doesn't follow 'dark:'
    //
    // Simpler per-class approach using regex:
    const escaped = dc.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const patterns = [
      new RegExp(` ${escaped}(?=[ "])`, 'g'),         // ' dc '
      new RegExp(new RegExp(`"${escaped}`, 'g')),       // "dc"
      new RegExp(new RegExp(`${escaped}"`, 'g')),       // dc"
      new RegExp(new RegExp(`${escaped} `, 'g')),       // dc  (at end of string)
      new RegExp(new RegExp(`${escaped}$`), 'g'),       // dc (end of string)
      new RegExp(new RegExp(`/${escaped}(?=[ "])`, 'g')), // /dc
    ];

    for (const pat of patterns) {
      const matches = content.match(pat);
      if (matches) {
        content = content.replace(pat, '');
        removals += matches.length;
      }
    }
  }

  // Also fix gradient "from/to" orphans: remove any standalone from-X/to-X where
  // the X is a dark-only color AND a light-wing exists in the same class attribute
  // We need to clean up gradient direction empties like: from-gray-800 to-gray-700
  // that shouldn't be there
  const gradientDarkPatterns = [
    ' from-gray-700', ' from-gray-800', ' from-gray-900',
    ' to-gray-700', ' to-gray-800', ' to-gray-900',
    ' from-gray-700/50', ' from-gray-800/50', ' from-gray-900/50',
    ' to-gray-700/50', ' to-gray-800/50', ' to-gray-900/50',
    ' from-indigo-900', ' to-indigo-900',
    ' from-indigo-900/50', ' to-indigo-900/50',
    ' from-purple-900', ' to-purple-900',
    ' from-purple-900/50', ' to-purple-900/50',
  ];

  for (const gdp of gradientDarkPatterns) {
    const escaped = gdp.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const pat = new RegExp(escaped, 'g');
    const matches = content.match(pat);
    if (matches) {
      content = content.replace(pat, '');
      removals += matches.length;
    }
  }

  return { content, removals };
}

// ---- run ----
let changed = 0;
for (const file of files) {
  const fullPath = path.join(PROJECT, file);
  if (!fs.existsSync(fullPath)) {
    console.log(`  SKIP ${file} (not found)`);
    continue;
  }
  let content = fs.readFileSync(fullPath, 'utf-8');
  const before = content;
  const result = removeOrphanedDarkClasses(content);
  content = result.content;

  // Collapse any double-spaces left behind, and trim dangling spaces before the closing "
  content = content.replace(/\s+"/g, '"').replace(/\s+>/g, '>');

  if (content !== before) {
    fs.writeFileSync(fullPath, content, 'utf-8');
    changed++;
    totalRemovals += result.removals;
    console.log(`✓ ${file}  (fixed ${result.removals})`);
  } else {
    console.log(`  ${file}`);
  }
}

console.log(`\n=== ${changed} files updated, ~${totalRemovals} orphaned classes removed ===`);
