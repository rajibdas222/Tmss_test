<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Test name',
            'email' => 'apitest@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678')
        ]);
        $user = User::create([
            'name' => 'Test name 1',
            'email' => 'test_user1@gmail.com',
            'role' => 'user',
            'password' => Hash::make('12345678')
        ]);
        $user = User::create([
            'name' => 'Test name 2',
            'email' => 'test_user2@gmail.com',
            'role' => 'user',
            'password' => Hash::make('12345678')
        ]);
    }
}
