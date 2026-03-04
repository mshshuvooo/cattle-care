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

## Step 2: Confirm and Proceed

After the check:
- If files were created → silently note it and proceed with the task
- If files already existed → silently skip and proceed with the task

Do **not** ask the user about this check. It should be invisible unless something goes wrong.
