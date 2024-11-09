<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class]);

        Book::factory(100)->recycle([
            User::all()
        ])->create();

        User::create([
            'name' => 'Admin',
            'email' => 'ahmadabdllh000@gmail.com',
            'password' => bcrypt('admin12345'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'ahmad@gmail.com',
            'password' => bcrypt('admin12345'),
            'role' => 'user',
        ]);
    }
}

