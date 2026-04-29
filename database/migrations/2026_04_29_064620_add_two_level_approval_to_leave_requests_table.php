<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('ketua_pegawai_id')->nullable();
            $table->string('ketua_pegawai_status')->nullable();
            $table->text('ketua_pegawai_remark')->nullable();
            $table->timestamp('ketua_pegawai_approved_at')->nullable();

            $table->unsignedBigInteger('penolong_pengarah_id')->nullable();
            $table->string('penolong_pengarah_status')->nullable();
            $table->text('penolong_pengarah_remark')->nullable();
            $table->timestamp('penolong_pengarah_approved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn([
                'ketua_pegawai_id',
                'ketua_pegawai_status',
                'ketua_pegawai_remark',
                'ketua_pegawai_approved_at',
                'penolong_pengarah_id',
                'penolong_pengarah_status',
                'penolong_pengarah_remark',
                'penolong_pengarah_approved_at',
            ]);
        });
    }
};