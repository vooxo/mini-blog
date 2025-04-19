<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)
            ->admin()
            ->create();

        User::factory(20)->create();

        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
