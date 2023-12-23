<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->create(['groups' => 'client']);
        User::factory(5)->create(['groups' => 'employee']);
        User::factory(5)->create(['groups' => 'client,employee']);
    }
}
