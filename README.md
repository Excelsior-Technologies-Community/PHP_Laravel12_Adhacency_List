# PHP_Laravel12_Adhacency_List

##  Project Introduction

PHP_Laravel12_Adjacency_List is a Laravel 12 demonstration project that implements a hierarchical data management system using the Adjacency List pattern.
The project showcases how parent–child relationships can be stored in a single database table and retrieved efficiently through recursive Eloquent relationships powered by the staudenmeir/laravel-adjacency-list package.

------------------------------------------------------------------------

## Project Overview

The main goal of this project is to demonstrate how to:

- Design a self-referencing database structure using parent_id

- Implement recursive relationships in Laravel 12

- Retrieve hierarchical data using single-query tree traversal

- Convert flat query results into a nested tree structure

- Display unlimited-depth hierarchies using recursive Blade views

------------------------------------------------------------------------

## Step 1 --- Create Laravel 12 Project

``` bash
composer create-project laravel/laravel PHP_Laravel12_Adhacency_List "12.*"
cd PHP_Laravel12_Adhacency_List
```

Check Laravel version:

``` bash
php artisan --version
```

------------------------------------------------------------------------

## Step 2 --- Install Adjacency List Package

We will use the official package:

``` bash
composer require staudenmeir/laravel-adjacency-list
```

------------------------------------------------------------------------

## Step 3 --- Database Configuration

Open:

    .env

Update database credentials:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=adjacency_db
    DB_USERNAME=root
    DB_PASSWORD=

Run migration:

``` bash
php artisan migrate
```

------------------------------------------------------------------------

## Step 4 --- Create Category Model & Migration

``` bash
php artisan make:model Category -m
```

### Migration File

    database/migrations/xxxx_xx_xx_create_categories_table.php

``` php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
    $table->timestamps();
});
```

Run:

``` bash
php artisan migrate
```

------------------------------------------------------------------------

## Step 5 --- Configure Category Model

    app/Models/Category.php

``` php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasRecursiveRelationships;

    protected $fillable = ['name', 'parent_id'];
}
```

------------------------------------------------------------------------

## Step 6 --- Create Seeder for Sample Tree Data

``` bash
php artisan make:seeder CategorySeeder
```

    database/seeders/CategorySeeder.php

``` php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $electronics = Category::create(['name' => 'Electronics']);
        $laptop = Category::create(['name' => 'Laptop', 'parent_id' => $electronics->id]);
        $mobile = Category::create(['name' => 'Mobile', 'parent_id' => $electronics->id]);

        Category::create(['name' => 'Gaming Laptop', 'parent_id' => $laptop->id]);
        Category::create(['name' => 'Ultrabook', 'parent_id' => $laptop->id]);

        Category::create(['name' => 'Android', 'parent_id' => $mobile->id]);
        Category::create(['name' => 'iPhone', 'parent_id' => $mobile->id]);
    }
}
```

Register seeder in:

    database/seeders/DatabaseSeeder.php

``` php
public function run()
{
    $this->call(CategorySeeder::class);
}
```

Run:

``` bash
php artisan db:seed
```

------------------------------------------------------------------------

## Step 7 --- Fetch Tree Data in Controller

``` bash
php artisan make:controller CategoryController
```

    app/Http/Controllers/CategoryController.php

``` php
<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::tree()->get()->toTree();
        return view('categories.index', compact('categories'));
    }
}
```

------------------------------------------------------------------------

## Step 8 --- Create Blade View to Display Tree

Create:

    resources/views/categories/index.blade.php

``` php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Tree</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 2026 Design Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white">

    <!-- Page Wrapper -->
    <div class="max-w-6xl mx-auto px-6 py-12">

        <!-- Header -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10
                    rounded-3xl p-8 shadow-2xl mb-8">

            <h1 class="text-4xl font-bold tracking-tight bg-gradient-to-r
                       from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                Category Hierarchy
            </h1>

            <p class="text-slate-300 mt-3">
                Recursive tree structure powered by Laravel Adjacency List
            </p>
        </div>

        <!-- Tree Container -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10
                    rounded-3xl p-8 shadow-2xl">

            <ul class="space-y-4">
                @foreach ($categories as $category)
                    <li>

                        <!-- Parent Node -->
                        <div class="group flex items-center justify-between
                                    bg-gradient-to-r from-indigo-500/20 to-purple-500/20
                                    border border-indigo-400/20
                                    px-5 py-3 rounded-2xl
                                    hover:scale-[1.02] hover:border-indigo-300/40
                                    transition duration-300 shadow-lg">

                            <span class="font-semibold text-lg">
                                {{ $category->name }}
                            </span>

                            <span class="text-xs text-indigo-300 opacity-70">
                                Root
                            </span>
                        </div>

                        <!-- Children -->
                        @if ($category->children->count())
                            @include('categories.partials.children', [
                                'children' => $category->children
                            ])
                        @endif

                    </li>
                @endforeach
            </ul>

        </div>

    </div>

</body>
</html>
```

### Recursive Partial View

    resources/views/categories/partials/children.blade.php

``` php
<ul class="ml-8 mt-4 space-y-3 border-l border-indigo-400/20 pl-6">
    @foreach ($children as $child)
        <li>

            <div class="flex items-center justify-between
                        bg-white/5 border border-white/10
                        px-4 py-2 rounded-xl
                        hover:bg-indigo-500/10 hover:border-indigo-400/30
                        transition duration-300 backdrop-blur-md">

                <span class="text-slate-200">
                    {{ $child->name }}
                </span>

                <span class="text-xs text-slate-400">
                    Child
                </span>
            </div>

            @if ($child->children->count())
                @include('categories.partials.children', [
                    'children' => $child->children
                ])
            @endif

        </li>
    @endforeach
</ul>
```

------------------------------------------------------------------------

## Step 9 --- Web Route

    routes/web.php

``` php
use App\Http\Controllers\CategoryController;

Route::get('/categories', [CategoryController::class, 'index']);
```

Run server:

``` bash
php artisan serve
```

Visit:

```bash
    http://127.0.0.1:8000/categories
```
------------------------------------------------------------------------

## Output

You will see a **nested category tree** like:

<img width="1832" height="1074" alt="Screenshot 2026-02-17 110301" src="https://github.com/user-attachments/assets/9781d4af-92af-4732-bfaf-6aaf0eff86aa" />



------------------------------------------------------------------------

## Project Structure

```
PHP_Laravel12_Adhacency_List/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── CategoryController.php
│   │
│   └── Models/
│       └── Category.php
│
├── database/
│   ├── migrations/
│   │   └── xxxx_create_categories_table.php
│   │
│   └── seeders/
│       ├── CategorySeeder.php
│       └── DatabaseSeeder.php
│
├── resources/
│   └── views/
│       └── categories/
│           ├── index.blade.php
│           └── partials/
│               └── children.blade.php
│
├── routes/
│   └── web.php
│
├── .env
├── composer.json
└── artisan
```

------------------------------------------------------------------------

Your **PHP_Laravel12_Adhacency_List** Project is now ready!




