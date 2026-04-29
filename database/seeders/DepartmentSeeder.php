<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::insert([
            ['name' => 'Human Resource', 'description' => 'HR Department', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Information Technology', 'description' => 'IT Department', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'description' => 'Finance Department', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}