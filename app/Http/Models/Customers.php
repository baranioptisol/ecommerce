<?php
/**
   * Customers Model 
   * 
   * @package    Laravel
   * @subpackage Controller
   * @author     Barani <barani.p@optisolbusiness.com>
   */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    /**
     * The database used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'name','company','street_no', 'street1', 'street2', 'city', 'state', 'zip', 'country', 'email', 'password', 'is_residential','is_active', 'is_deleted', 'created_by', 'updated_by', 'remember_token','telephone','username'
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
