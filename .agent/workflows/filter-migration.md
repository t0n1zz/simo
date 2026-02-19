---
description: Replace Vue 2 $options.filters with helper function imports
---

# Migrate Vue 2 Filters to Helper Functions

## What This Does
Vue 3 removed the filters API (`$options.filters`). This workflow converts filter usage to imported helper functions.

## The Helper File Location

All filter functions are already defined in:
`/Users/tony/Code/simo/resources/js/helpers/filterHelpers.js`

## Available Filter Functions

| Function | Purpose | Example Output |
|----------|---------|----------------|
| `date(value)` | Format date | "09-01-2026" |
| `time(value)` | Format time | "08:53:17" |
| `dateTime(value)` | Format date + time | "09-01-2026 \| 08:53:17" |
| `dateMonth(value)` | Format with month name | "09 January 2026" |
| `month(value)` | Month name only | "January" |
| `year(value)` | Year only | "2026" |
| `checkStatus(value)` | Status badge HTML | `<span class="badge">...</span>` |
| `checkTingkatAktivis(value)` | Aktivis level text | "Pengurus", "Manajer", etc. |
| `currency(value)` | Format currency | "Rp 1.000.000" |
| `number(value)` | Format number | "1.000.000" |
| `percentage(value)` | Format percentage | "50%" |
| `statusDiklat(value)` | Diklat status badge | HTML badge |
| `statusPeserta(value)` | Peserta status badge | HTML badge |
| `kegiatanTipe(value)` | Kegiatan type text | "Diklat PUSKOPCUINA" |

## Step-by-Step Process

### Step 1: Find Filter Usage in Template

Look for patterns like:
```vue
v-html="$options.filters.dateTime(props.item.created_at)"
v-html="$options.filters.checkStatus(props.item.terbitkan)"
```

### Step 2: Import Required Functions

Add imports at the top of `<script>`:

```javascript
import { dateTime, checkStatus, date } from '../../helpers/filterHelpers';
```

Adjust path based on file location:
- From `/views/{module}/`: use `'../../helpers/filterHelpers'`
- From `/components/`: use `'../helpers/filterHelpers'`

### Step 3: Create $filters Object in setup() or data()

**Option A: Using setup()** (recommended)
```javascript
export default {
    setup() {
        return {
            $filters: {
                dateTime,
                checkStatus,
                date
            }
        }
    },
    // ... rest of component
}
```

**Option B: Using data()** (if component doesn't have setup)
```javascript
import filters from '../../helpers/filterHelpers';

export default {
    data() {
        return {
            $filters: filters,
            // ... other data
        }
    },
}
```

### Step 4: Update Template Usage

**BEFORE:**
```vue
<td v-html="$options.filters.dateTime(props.item.created_at)"></td>
<td v-html="$options.filters.checkStatus(props.item.terbitkan)"></td>
```

**AFTER:**
```vue
<td v-html="$filters.dateTime(props.item.created_at)"></td>
<td v-html="$filters.checkStatus(props.item.terbitkan)"></td>
```

Note: Only change `$options.filters` to `$filters`. The function name stays the same.

## Complete Example

### BEFORE:
```vue
<template>
    <tr>
        <td v-html="$options.filters.dateTime(props.item.created_at)"></td>
        <td v-html="$options.filters.checkStatus(props.item.terbitkan)"></td>
        <td v-html="$options.filters.date(props.item.tanggal_lahir)"></td>
    </tr>
</template>

<script>
export default {
    // No filter imports needed in Vue 2
}
</script>
```

### AFTER:
```vue
<template>
    <tr>
        <td v-html="$filters.dateTime(props.item.created_at)"></td>
        <td v-html="$filters.checkStatus(props.item.terbitkan)"></td>
        <td v-html="$filters.date(props.item.tanggal_lahir)"></td>
    </tr>
</template>

<script>
import { dateTime, checkStatus, date } from '../../helpers/filterHelpers';

export default {
    setup() {
        return {
            $filters: {
                dateTime,
                checkStatus,
                date
            }
        }
    },
}
</script>
```

## Files That Need This Migration

Run this command to find them:
```bash
grep -r '\$options.filters' /Users/tony/Code/simo/resources/js --include="*.vue" -l
```

Common files:
- All `table.vue` files (display formatted dates, statuses)
- Form files with date displays
- Detail/view files

## Quick Find-Replace Patterns

In each file:
1. Find: `$options.filters.`
2. Replace with: `$filters.`
3. Add imports and setup() as shown above
