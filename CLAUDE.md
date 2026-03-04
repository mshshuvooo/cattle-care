# Cattle Care — Claude Code Instructions

## Stack
- **Backend:** Laravel 12 (PHP)
- **Frontend:** Vue 3 + Inertia.js v2
- **Styling:** Tailwind CSS v4
- **Database:** MySQL
- **Routing bridge:** Ziggy (named routes in JS via `route()`)

## Dev Commands
```bash
php artisan serve      # Start Laravel dev server
npm run dev            # Start Vite dev server (run alongside artisan serve)
php artisan migrate    # Run pending migrations
php artisan db:seed    # Run seeders
php artisan migrate:fresh --seed  # Wipe and reseed
```


## Migrations
Always include `softDeletes()` in every new migration table:

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    // ... other columns
    $table->timestamps();
    $table->softDeletes();
});
```

- `$table->softDeletes()` must always be the **last line** before closing, after `$table->timestamps()`
- Never omit `softDeletes()` from any new table

---


## Models
All models must use `SoftDeletes` and the custom `App\Traits\Searchable` trait.

```php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Searchable;

class User extends Model
{
    use SoftDeletes, Searchable;

    protected $guarded = ['id'];

    protected static array $searchable = [
        'name',
        'email',
    ];
}
```

- **Never use `$fillable`** — always use `$guarded = ['id']` instead
- **SoftDeletes** — never hard delete records; always use soft deletes
- **Searchable** — custom trait in `App\Traits\Searchable`. Requires a `$searchable` array on the model defining which fields to search against

---


## API Resources
Always use API Resource classes when returning model data. Never return raw models or arrays.

```php
use App\Http\Resources\UserResource;

// Single resource
return new UserResource($user);

// Collection
return UserResource::collection($users);
```

### Naming Convention
Resources live in `app/Http/Resources/`:

| Model  | Resource Class   |
|--------|-----------------|
| User   | `UserResource`  |
| Staff  | `StaffResource` |

### Generate with Artisan
```bash
php artisan make:resource UserResource
```

---


## Controller Rules

### Use Resource Controllers with Separate Methods
Group all related actions inside one controller with dedicated methods.

```php
class UserController extends Controller
{
    public function index(): Response
        {
            $params = [
            'search' => $request->search,
        ];

        $users = UserResource::collection(User::search($params)
            ->paginate()->withQueryString());

        $breadcrumbs = [
            ['label' => 'Users', 'url' => ''],
        ];

        return Inertia::render('User/Index', [
            'search'      => $request->search,
            'users'       => $users,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function create(): Response
    {
        $breadcrumbs = [
            ['label' => 'Users', 'url' => route('user.index')],
            ['label' => 'Add New User', 'url' => ''],
        ];

        return Inertia::render('User/Create', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('user.index');
    }

    public function show(User $user): Response
    {
        $breadcrumbs = [
            ['label' => 'Users', 'url' => route('user.index')],
            ['label' => 'View User', 'url' => ''],
        ];

        return Inertia::render('User/Show', [
            'breadcrumbs' => $breadcrumbs,
            'user'        => $user,
        ]);
    }

    public function edit(User $user): Response
    {
        $breadcrumbs = [
            ['label' => 'Users', 'url' => route('user.index')],
            ['label' => 'Edit User', 'url' => ''],
        ];

        return Inertia::render('User/Edit', [
            'breadcrumbs' => $breadcrumbs,
            'user'        => $user,
        ]);
    }

    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('user.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('user.index');
    }
}
```

### Naming Convention
| Controller     | Handles                  |
|----------------|--------------------------|
| `UserController` | index, create, store, edit, update, destroy |



### Search in Controllers
Always use this exact pattern in the `index()` method:

```php
public function index(SearchRequest $request)
{
    $params = [
        'search' => $request->search,
    ];

    $users = UserResource::collection(User::search($params)
        ->paginate()->withQueryString());

    $breadcrumbs = [
        ['label' => 'Users', 'url' => ''],
    ];

    return Inertia::render('User/Index', [
        'search'      => $request->search,
        'users'       => $users,
        'breadcrumbs' => $breadcrumbs,
    ]);
}
```

- Always use `SearchRequest` for the `index()` method
- Always wrap results in an API Resource collection e.g. `UserResource::collection(...)`
- Always use `->paginate()->withQueryString()` — never `->get()`
- Always pass `'search' => $request->search` back to Vue so the search input stays populated

---

## Breadcrumbs
Every method that returns an Inertia response **must** include breadcrumbs.

```php
public function create()
{
    $breadcrumbs = [
        ['label' => 'Users', 'url' => route('user.index')],
        ['label' => 'Add New User', 'url' => ''],
    ];

    return Inertia::render('User/Create', [
        'breadcrumbs' => $breadcrumbs,
    ]);
}
```

- The **last breadcrumb** always has an empty `url` (current page)
- Always pass breadcrumbs as `'breadcrumbs'` key in the Inertia props

---

## Eloquent — Store & Update
Always use `$request->validated()` directly. **Never** use associative arrays when `validated()` covers it.

```php
User::create($request->validated());
$user->update($request->validated());
```

---

## Form Requests
Always use a dedicated Form Request class for validation. Never validate inside the controller.

```php
class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
        ];
    }
}
```

### Naming Convention
Form Requests live in `app/Http/Requests/ModelName/` folder:

| Action  | Class Path                  |
|---------|-----------------------------|
| store   | `App\Http\Requests\User\StoreRequest`   |
| update  | `App\Http\Requests\User\UpdateRequest`  |

---

## Inertia Views
- Views live in `resources/js/Pages/`
- Follow the folder structure: `ModelName/Action.vue`

| Action  | View Path          |
|---------|--------------------|
| index   | `User/Index.vue`   |
| create  | `User/Create.vue`  |
| edit    | `User/Edit.vue`    |

---

## Flash Messages
Always use `->with('success', '...')` for flash messages on redirects:

```php
return redirect()->route('user.index')->with('success', 'User created successfully.');
```

Read from `$page.props.flash.success` in Vue.

---

## Vue Frontend Conventions
Always use optional chaining (`?.`) when accessing props in Vue templates. Never access properties directly without it.

✅ **Correct**
```vue
{{ user?.name }}
{{ user?.email }}
```

❌ **Avoid**
```vue
{{ user.name }}
{{ user.email }}
```

---

