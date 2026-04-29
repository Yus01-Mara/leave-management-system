<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('staff_id')->nullable()->unique();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['role', 'department_id', 'phone', 'staff_id']);
        });
    }
};