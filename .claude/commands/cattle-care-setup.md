# Cattle Care — Project Setup

Run this **once at the start of every new conversation** before doing any task.

---

## Step 1: Check and Create Required Files

Check if the following files exist. Create any that are missing. Skip silently if they already exist.

---

### `app/Traits/Searchable.php`

```php
<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * @param array $params
     * @return Builder
     */
    protected function search(array $params = []): Builder
    {
        return self::where(function ($query) use ($params) {
            if (!empty($params['search'])) {
                foreach (self::$searchable as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $params['search'] . '%');
                }
            }
        });
    }
}
```

---

### `app/Http/Requests/SearchRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'nullable',
        ];
    }
}
```

---

### `resources/js/Components/Form/FormInput.vue`

```vue
<script setup>
import { ref } from 'vue'

defineOptions({ inheritAttrs: false })

defineProps({
    modelValue:  { type: String, default: '' },
    label:       { type: String, default: '' },
    type:        { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    error:       { type: String, default: '' },
})

defineEmits(['update:modelValue'])

const inputEl = ref(null)
defineExpose({ focus: () => inputEl.value?.focus() })
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1.5">{{ label }}</label>
        <input
            ref="inputEl"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            v-bind="$attrs"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1.5 text-xs text-red-500">{{ error }}</p>
    </div>
</template>
```

---

### `resources/js/Components/Form/FormTextarea.vue`

```vue
<script setup>
defineProps({
    modelValue:  { type: String, default: '' },
    label:       { type: String, default: '' },
    placeholder: { type: String, default: '' },
    rows:        { type: Number, default: 4 },
    error:       { type: String, default: '' },
})

defineEmits(['update:modelValue'])
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1.5">{{ label }}</label>
        <textarea
            :value="modelValue"
            :placeholder="placeholder"
            :rows="rows"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent resize-none"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1.5 text-xs text-red-500">{{ error }}</p>
    </div>
</template>
```

---

### `resources/js/Components/Form/FormSelect.vue`

```vue
<script setup>
defineProps({
    modelValue:  { type: String, default: '' },
    label:       { type: String, default: '' },
    placeholder: { type: String, default: '' },
    options:     { type: Array, default: () => [] },
    error:       { type: String, default: '' },
})

defineEmits(['update:modelValue'])
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1.5">{{ label }}</label>
        <select
            :value="modelValue"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option v-if="placeholder" value="" disabled>{{ placeholder }}</option>
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.name }}
            </option>
        </select>
        <p v-if="error" class="mt-1.5 text-xs text-red-500">{{ error }}</p>
    </div>
</template>
```

---

### `resources/js/Components/Form/FormSection.vue`

```vue
<script setup>
import { computed, useSlots } from 'vue'

defineEmits(['submitted'])

const slots = useSlots()
const hasTitle   = computed(() => !!slots.title)
const hasActions = computed(() => !!slots.actions)
</script>

<template>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div v-if="hasTitle" class="px-6 py-4 border-b border-gray-100">
            <slot name="title" />
        </div>

        <form @submit.prevent="$emit('submitted')">
            <!-- Form body -->
            <div class="p-6 space-y-5">
                <slot name="form" />
            </div>

            <!-- Footer / Actions -->
            <div v-if="hasActions" class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
                <slot name="actions" />
            </div>
        </form>
    </div>
</template>
```

**Form component usage rules:**
- All form field/layout components live in `resources/js/Components/Form/`
- The following Jetstream components have been **permanently deleted** from `resources/js/Components/` root — do NOT recreate them:
  - `TextInput.vue` → replaced by `FormInput`
  - `InputLabel.vue` → replaced by `FormInput` (label is a prop)
  - `InputError.vue` → replaced by `FormInput` (error is a prop)
  - `FormSection.vue` (root) → replaced by `Form/FormSection`
- **IMPORTANT:** When building any form or form-related component, NEVER use Jetstream's `TextInput`, `InputLabel`, `InputError`, or `FormSection`. Always use our custom components from `@/Components/Form/` instead.
- `FormInput` combines label + input + error in one component; always import from `@/Components/Form/FormInput`
- `FormInput` exposes a `focus()` method via `defineExpose`, so `ref` works for programmatic focus
- `FormInput` uses `inheritAttrs: false` + `v-bind="$attrs"` — extra attrs like `autocomplete`, `@keyup.enter`, `autofocus` pass through to the `<input>`
- `FormSelect` expects `options` as `[{ value, name }]` array
- `FormSection` slots: `#title`, `#form`, `#actions` — header/footer only render when their slot is provided

---

### `resources/js/Components/Button/PrimaryButton.vue`

```vue
<script setup>
import { Link } from '@inertiajs/vue3'

defineOptions({ inheritAttrs: false })

defineProps({
    as:       { type: String,  default: 'button' },
    href:     { type: String,  default: '' },
    type:     { type: String,  default: 'button' },
    disabled: { type: Boolean, default: false },
})
</script>

<template>
    <Link v-if="as === 'link'" :href="href" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-white bg-green-700 rounded-lg hover:bg-green-800 transition font-medium">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-white bg-green-700 rounded-lg hover:bg-green-800 transition font-medium disabled:opacity-50">
        <slot />
    </button>
</template>
```

---

### `resources/js/Components/Button/SecondaryButton.vue`

```vue
<script setup>
import { Link } from '@inertiajs/vue3'

defineOptions({ inheritAttrs: false })

defineProps({
    as:       { type: String,  default: 'button' },
    href:     { type: String,  default: '' },
    type:     { type: String,  default: 'button' },
    disabled: { type: Boolean, default: false },
})
</script>

<template>
    <Link v-if="as === 'link'" :href="href" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-gray-600 border border-gray-300 bg-white rounded-lg hover:bg-gray-100 transition font-medium">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-gray-600 border border-gray-300 bg-white rounded-lg hover:bg-gray-100 transition font-medium disabled:opacity-50">
        <slot />
    </button>
</template>
```

---

### `resources/js/Components/Button/DangerButton.vue`

```vue
<script setup>
import { Link } from '@inertiajs/vue3'

defineOptions({ inheritAttrs: false })

defineProps({
    as:       { type: String,  default: 'button' },
    href:     { type: String,  default: '' },
    type:     { type: String,  default: 'button' },
    disabled: { type: Boolean, default: false },
})
</script>

<template>
    <Link v-if="as === 'link'" :href="href" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition font-medium">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition font-medium disabled:opacity-50">
        <slot />
    </button>
</template>
```

**Button usage rules:**
- All buttons (including those from Jetstream) live in `resources/js/Components/Button/`
- The following Jetstream components have been **permanently deleted** from `resources/js/Components/` root — do NOT recreate them:
  - `PrimaryButton.vue` (root) → replaced by `Button/PrimaryButton`
  - `SecondaryButton.vue` (root) → replaced by `Button/SecondaryButton`
  - `DangerButton.vue` (root) → replaced by `Button/DangerButton`
- Use `as="link"` prop + `:href` to render as an Inertia `<Link>`
- Default renders as a `<button>` element
- `v-bind="$attrs"` + `inheritAttrs: false` ensures `@click`, extra `class`, etc. forward correctly
- Never import buttons from `@/Components/` root — always use `@/Components/Button/`

---

## Step 2: Confirm and Proceed

After the check:
- If files were created → silently note it and proceed with the task
- If files already existed → silently skip and proceed with the task

Do **not** ask the user about this check. It should be invisible unless something goes wrong.
