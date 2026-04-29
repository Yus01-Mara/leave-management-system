<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        LeaveType::insert([
            ['name' => 'Annual Leave', 'default_days' => 14, 'requires_attachment' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sick Leave', 'default_days' => 14, 'requires_attachment' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emergency Leave', 'default_days' => 3, 'requires_attachment' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Unpaid Leave', 'default_days' => 0, 'requires_attachment' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}