<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\CategoryModel::factory(5)->create();
        \App\Models\ProductModel::factory(5)->create();
        // \App\Models\User::factory(10)->create();
    }
}
