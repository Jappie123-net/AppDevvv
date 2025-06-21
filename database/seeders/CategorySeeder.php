<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // ← this line is important

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Snacks', 'Drinks', 'Toiletries', 'Canned Goods', 'Stationery'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
