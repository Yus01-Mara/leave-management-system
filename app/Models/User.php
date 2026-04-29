<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'department_id',
    'phone',
    'staff_id',
];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function department()
{
    return $this->belongsTo(Department::class);
}

public function leaveRequests()
{
    return $this->hasMany(LeaveRequest::class);
}

public function leaveBalances()
{
    return $this->hasMany(LeaveBalance::class);
}
}
