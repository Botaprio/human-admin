<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Fernando',
            'last_name' => 'Botasso',
            'email' => 'fbotasso@gmail.com',
            'rol' => 'admin',
            'password' => Hash::make('123123123'),
        ]);
    }
}
