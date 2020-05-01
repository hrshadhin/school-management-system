<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {
    /**
     * Define primary key for delete() function works.
     */
    protected $primaryKey = 'email';
    protected $table = 'password_resets';
}
