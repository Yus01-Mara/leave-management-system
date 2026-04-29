<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'ketua_pegawai_id',
        'ketua_pegawai_status',
        'ketua_pegawai_remark',
        'ketua_pegawai_approved_at',
        'penolong_pengarah_id',
        'penolong_pengarah_status',
        'penolong_pengarah_remark',
        'penolong_pengarah_approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
    
    public function ketuaPegawai()
    {
        return $this->belongsTo(User::class, 'ketua_pegawai_id');
    }

    public function penolongPengarah()
    {
        return $this->belongsTo(User::class, 'penolong_pengarah_id');
    }
}