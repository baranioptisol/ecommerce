<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
class Users extends Authenticatable
{
    use EntrustUserTrait;
    /**
     * The database used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'is_active', 'is_deleted', 'created_by', 'updated_by', 'remember_token','address','telephone','first_name', 'last_name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
