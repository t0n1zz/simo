---
description: Migrate Vue 2 slot syntax to Vue 3 in a specific file
---

# Vue 2 to Vue 3 Slot Syntax Migration

## What This Does
Converts Vue 2 slot syntax to Vue 3 syntax in Vue component files.

## The Transformation Rules

### Rule 1: Named Slots
**Find:** `slot="slot-name"`
**Replace with:** `#slot-name`

Example:
```vue
<!-- Vue 2 (OLD) -->
<template slot="button-desktop">

<!-- Vue 3 (NEW) -->
<template #button-desktop>
```

### Rule 2: Scoped Slots
**Find:** `slot="slot-name" slot-scope="props"`
**Replace with:** `#slot-name="props"`

Example:
```vue
<!-- Vue 2 (OLD) -->
<template slot="item-desktop" slot-scope="props">

<!-- Vue 3 (NEW) -->
<template #item-desktop="props">
```

### Rule 3: Default Slot with Scope
**Find:** `slot-scope="props"` (without slot name)
**Replace with:** `#default="props"`

### Rule 4: Div with Slot (convert to template)
**Find:** `<div slot="slot-name">`
**Replace with:** `<template #slot-name><div>`... and close properly

Example:
```vue
<!-- Vue 2 (OLD) -->
<div slot="modal-body1">
  content here
</div>

<!-- Vue 3 (NEW) -->
<template #modal-body1>
  <div>
    content here
  </div>
</template>
```

## Step-by-Step Process

1. Open the target Vue file
2. Search for all occurrences of `slot="`
3. Apply Rule 1, 2, 3, or 4 based on the pattern found
4. Search for all occurrences of `slot-scope="`
5. Apply the appropriate rule
6. Verify the file still has valid Vue 3 syntax
7. Test that the component renders correctly

## Common Patterns in This Project

### Pattern A: DataViewer Table Slots
```vue
<!-- OLD -->
<template slot="button-desktop">...</template>
<template slot="button-mobile">...</template>
<template slot="item-desktop" slot-scope="props">...</template>

<!-- NEW -->
<template #button-desktop>...</template>
<template #button-mobile>...</template>
<template #item-desktop="props">...</template>
```

### Pattern B: Modal Slots
```vue
<!-- OLD -->
<template slot="modal-title">...</template>
<template slot="modal-body1">...</template>
<template slot="modal-body2">...</template>

<!-- NEW -->
<template #modal-title>...</template>
<template #modal-body1>...</template>
<template #modal-body2>...</template>
```

### Pattern C: Button Column Slots
```vue
<!-- OLD -->
<slot name="button-kolom"></slot>

<!-- This is CORRECT - slot definitions don't need to change -->
<!-- Only slot USAGE needs to change -->
```

## Files That Need This Migration

Priority order (fix these first):
1. `/Users/tony/Code/simo/resources/js/components/dataviewer2.vue`
2. `/Users/tony/Code/simo/resources/js/components/modal.vue`
3. `/Users/tony/Code/simo/resources/js/components/header.vue`
4. All files in `/Users/tony/Code/simo/resources/js/views/*/table.vue`
5. All files in `/Users/tony/Code/simo/resources/js/views/*/form.vue`

## How to Find Files That Need Migration

Run this command in terminal:
```bash
grep -r 'slot="' /Users/tony/Code/simo/resources/js --include="*.vue" -l
```

## Verification

After migration, the component should:
1. Not show any Vue warnings about slots in browser console
2. Render the same content as before
3. Have no `slot="` or `slot-scope="` attributes remaining
