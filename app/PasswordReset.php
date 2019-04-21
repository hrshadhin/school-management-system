<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model {
    /**
     * Define primary key for delete() function works.
     */
    protected $primaryKey = 'email';
    protected $table = 'password_resets';
}
