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
        <label v-if="label" class="block text-sm font-medium text-navy mb-1.5">{{ label }}</label>
        <input
            ref="inputEl"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            v-bind="$attrs"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1.5 text-xs text-danger">{{ error }}</p>
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
        <label v-if="label" class="block text-sm font-medium text-navy mb-1.5">{{ label }}</label>
        <textarea
            :value="modelValue"
            :placeholder="placeholder"
            :rows="rows"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent resize-none"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1.5 text-xs text-danger">{{ error }}</p>
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
        <label v-if="label" class="block text-sm font-medium text-navy mb-1.5">{{ label }}</label>
        <select
            :value="modelValue"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent bg-white"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option v-if="placeholder" value="" disabled>{{ placeholder }}</option>
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.name }}
            </option>
        </select>
        <p v-if="error" class="mt-1.5 text-xs text-danger">{{ error }}</p>
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

**Important:** The following Jetstream components have been **permanently deleted** from `resources/js/Components/` root — do NOT recreate them:
- `TextInput.vue` → replaced by `Form/FormInput`
- `InputLabel.vue` → replaced by `Form/FormInput` (label is a prop)
- `InputError.vue` → replaced by `Form/FormInput` (error is a prop)
- `FormSection.vue` (root) → replaced by `Form/FormSection`

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
        class="cursor-pointer px-4 py-2 text-sm text-white bg-brand rounded-lg hover:bg-brand-dark transition font-medium">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-white bg-brand rounded-lg hover:bg-brand-dark transition font-medium disabled:opacity-50">
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
        class="cursor-pointer px-4 py-2 text-sm text-navy border border-gray-300 bg-transparent rounded-lg hover:bg-gray-50 transition font-medium">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-navy border border-gray-300 bg-transparent rounded-lg hover:bg-gray-50 transition font-medium disabled:opacity-50">
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
        class="cursor-pointer px-4 py-2 text-sm text-white bg-danger rounded-lg hover:bg-danger-dark transition font-medium">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-white bg-danger rounded-lg hover:bg-danger-dark transition font-medium disabled:opacity-50">
        <slot />
    </button>
</template>
```

**Important:** The following Jetstream components have been **permanently deleted** from `resources/js/Components/` root — do NOT recreate them:
- `PrimaryButton.vue` (root) → replaced by `Button/PrimaryButton`
- `SecondaryButton.vue` (root) → replaced by `Button/SecondaryButton`
- `DangerButton.vue` (root) → replaced by `Button/DangerButton`

---

### `resources/js/Components/Search/Search.vue`

```vue
<script setup>
import { ref, watch, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import FormInput from '@/Components/Form/FormInput.vue'

const props = defineProps({
    route: { type: String, required: true },

    routeParam: {
        type: Object,
        default: () => ({}),
    },

    modelValue: {
        type: String,
        default: '',
    },

    param: {
        type: String,
        default: 'search',
    },
})

const value = ref(props.modelValue)
let debounceTimeout = null

watch(value, (newVal) => {
    clearTimeout(debounceTimeout)

    debounceTimeout = setTimeout(() => {
        const params = { ...props.routeParam }

        if (newVal) {
            params[props.param] = newVal
        }

        router.visit(route(props.route, params), {
            preserveScroll: true,
            preserveState: true,
        })
    }, 300)
})

onUnmounted(() => clearTimeout(debounceTimeout))
</script>

<template>
    <FormInput
        v-model="value"
        type="search"
        placeholder="Search..."
    />
</template>
```


---

### `resources/js/Components/Shared/DataGrid.vue`

```vue
<script setup>
import { computed } from 'vue'

const props = defineProps({
    items:              { type: Array,             default: () => [] },
    columns:            { type: Array,             required: true },
    rowKey:             { type: String,            default: 'id' },
    zebra:              { type: Boolean,           default: false },
    maxHeight:          { type: String,            default: null },
    actionsSpan:        { type: Number,            default: null },
    rowClass:           { type: [String, Function], default: '' },
    stickyHeader:       { type: Boolean,           default: false },
    showSummary:        { type: Boolean,           default: false },
    summaryPosition:    { type: String,            default: 'bottom' }, // 'top' | 'bottom'
    summarySticky:      { type: Boolean,           default: false },
    mobileHighlightKey: { type: String,            default: null },
})

const computedActionsSpan = computed(() => {
    if (props.actionsSpan != null) return props.actionsSpan
    const used = props.columns.reduce((sum, c) => sum + (c.span ?? 3), 0)
    return Math.max(12 - used, 0)
})

const headerClass = computed(() => [
    'hidden md:grid grid-cols-12 items-center px-5 py-3 bg-gray-50 text-xs text-muted uppercase tracking-wider border-b border-gray-100',
    props.stickyHeader ? 'sticky top-0 z-10 bg-gray-50/80 backdrop-blur' : '',
])

const summaryClass = 'grid grid-cols-12 items-center px-5 py-3 text-sm font-semibold text-navy bg-gray-50 border-t border-gray-100'

const summaryStyle = computed(() => {
    if (!props.summarySticky) return undefined
    return props.summaryPosition === 'top'
        ? { position: 'sticky', top: props.stickyHeader ? '41px' : '0px', zIndex: 9 }
        : { position: 'sticky', bottom: '0px', zIndex: 9 }
})
</script>

<template>
    <div class="overflow-auto scrollbar-custom" :style="maxHeight ? { maxHeight } : {}">

        <!-- Header -->
        <div v-if="columns?.length" :class="headerClass">
            <div v-for="col in columns" :key="col.key"
                :class="[`col-span-${col.span ?? 3}`, col.align === 'right' ? 'text-right' : 'text-left']">
                {{ col.label }}
            </div>
            <div v-if="computedActionsSpan" :class="`col-span-${computedActionsSpan} text-right`">Actions</div>
        </div>

        <!-- Summary (top) -->
        <div v-if="showSummary && summaryPosition === 'top'" :class="summaryClass" :style="summaryStyle">
            <slot name="summary-row" />
        </div>

        <!-- Rows -->
        <div class="divide-y divide-gray-100">
            <div v-for="(row, i) in items" :key="row?.[rowKey] ?? i"
                class="grid grid-cols-12 items-center px-5 py-4 text-sm hover:bg-gray-50 transition-colors"
                :class="[
                    zebra && i % 2 === 1 ? 'bg-gray-50' : '',
                    typeof rowClass === 'function' ? rowClass(row) : rowClass,
                ]">

                <div v-for="col in columns" :key="col.key"
                    :class="[`col-span-12 md:col-span-${col.span ?? 3}`, 'mt-2 md:mt-0', col.align === 'right' ? 'md:text-right' : '']">
                    <div class="md:hidden text-[11px] uppercase tracking-wide text-muted mb-0.5">
                        {{ col.mobileLabel ?? col.label }}
                    </div>

                    <!-- Mobile highlight pill for the designated key column -->
                    <template v-if="mobileHighlightKey && col.key === mobileHighlightKey">
                        <span class="md:hidden inline-flex items-center rounded-full px-3 py-0.5 mb-1 text-xs font-medium bg-gray-100 text-navy">
                            {{ row?.[col.key] }}
                        </span>
                        <slot :name="`cell-${col.key}`" :row="row" :value="row?.[col.key]">
                            <span class="hidden md:block truncate">
                                {{ col.format ? col.format(row?.[col.key], row) : (row?.[col.key] ?? '—') }}
                            </span>
                        </slot>
                    </template>

                    <slot v-else :name="`cell-${col.key}`" :row="row" :value="row?.[col.key]">
                        <span class="truncate block">
                            {{ col.format ? col.format(row?.[col.key], row) : (row?.[col.key] ?? '—') }}
                        </span>
                    </slot>
                </div>

                <div v-if="computedActionsSpan"
                    :class="`col-span-12 md:col-span-${computedActionsSpan} mt-2 md:mt-0 md:text-right`">
                    <slot name="row-actions" :row="row" />
                </div>
            </div>
        </div>

        <!-- Summary (bottom) -->
        <div v-if="showSummary && summaryPosition === 'bottom'" :class="summaryClass" :style="summaryStyle">
            <slot name="summary-row" />
        </div>

        <!-- Empty -->
        <div v-if="!items?.length" class="px-5 py-12 text-center text-sm text-muted">
            <slot name="empty">No records found.</slot>
        </div>
    </div>
</template>

<style scoped>
.scrollbar-custom::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.scrollbar-custom::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-custom::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 20px;
}

.scrollbar-custom::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
```

---

## Step 2: Install Required Packages (if missing)

Check if `lucide-vue-next` is in `package.json`. If missing, run:

```bash
npm install lucide-vue-next
```

---

## Step 3: Vue Coding Conventions (always enforce)

These rules apply to **every** Vue file you write or edit in this project:

### Arrow Functions
Always use arrow functions. Never use the `function` keyword in Vue `<script setup>`.

✅ Correct
```js
const submit = () => { form.post(route('users.store')) }
const confirmDelete = (row) => { deleteTarget.value = row }
const roleBadge = (role) => ({ admin: 'bg-purple-100' }[role] ?? '')
```

❌ Avoid
```js
function submit() { ... }
function confirmDelete(row) { ... }
```

### Single Resource `data` Wrapper
On edit/show pages, single API Resources are wrapped in a `data` key. Always use `props.model?.data?.field`:

```js
const form = useForm({
    name: props.user?.data?.name ?? '',
})
function submit() {
    form.put(route('users.update', props.user?.data?.id))
}
```

### Optional Chaining
Always use `?.` when accessing props or nested values in templates and scripts.

---

## Step 4: Confirm and Proceed

After the check:
- If files were created → silently note it and proceed with the task
- If files already existed → silently skip and proceed with the task

Do **not** ask the user about this check. It should be invisible unless something goes wrong.
