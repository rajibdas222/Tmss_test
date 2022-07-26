<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = Department::create([
            'name' => "English",
            'user_id' => User::all()->random()->id,
        ]);
        $department = Department::create([
            'name' => "BBA",
            'user_id' => User::all()->random()->id,
        ]);
        $department = Department::create([
            'name' => "CSE",
            'user_id' => User::all()->random()->id,
        ]);
        $department = Department::create([
            'name' => "EEE",
            'user_id' => User::all()->random()->id,
        ]);
        $department = Department::create([
            'name' => "Bangla",
            'user_id' => User::all()->random()->id,
        ]);
    }
}
