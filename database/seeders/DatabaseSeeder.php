<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Domain\User\Models\User;
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
      User::create([
       'name' => 'Hardik',
       'email' => 'admin@gmail.com',
       'password' => bcrypt('123456'),
      ]);
    }
}
