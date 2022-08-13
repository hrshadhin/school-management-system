<?php

namespace App\Models;

 use Illuminate\Notifications\Notifiable;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Permissions\HasPermissionsTrait;


class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, UserstampsTrait, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'phone_no', 'password', 'status', 'force_logout'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function role()
    {
        return $this->hasOne(UserRole::class);
    }

    public function teacher()
    {
        return $this->hasOne(Employee::class);
    }
}
