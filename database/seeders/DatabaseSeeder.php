<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'QAO',
            'password' => Hash::make('123'),
            'office_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Supe R. Admin',
        ]);
    }
}
