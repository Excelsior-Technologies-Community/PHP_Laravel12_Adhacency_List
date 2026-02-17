<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $electronics = Category::create(['name' => 'Electronics']);

        $laptop = Category::create([
            'name' => 'Laptop',
            'parent_id' => $electronics->id
        ]);

        $mobile = Category::create([
            'name' => 'Mobile',
            'parent_id' => $electronics->id
        ]);

        Category::create(['name' => 'Gaming Laptop', 'parent_id' => $laptop->id]);
        Category::create(['name' => 'Ultrabook', 'parent_id' => $laptop->id]);

        Category::create(['name' => 'Android', 'parent_id' => $mobile->id]);
        Category::create(['name' => 'iPhone', 'parent_id' => $mobile->id]);
    }
}
