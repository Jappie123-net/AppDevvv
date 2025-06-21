<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = ['Sari-Sari Wholesale', 'Puregold', 'NCCC', 'SM Supplier', 'Local Vendor'];

        foreach ($suppliers as $name) {
            Supplier::create(['name' => $name]);
        }
    }
}
