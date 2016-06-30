<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    public $timestamps = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'email', 'token'];
}
