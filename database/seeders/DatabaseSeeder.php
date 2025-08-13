<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            OwnerSeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            UpdateProductCoverImagesSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }
}
