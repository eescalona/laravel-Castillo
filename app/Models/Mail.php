<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Mail
 * @package App\Models
 * @version November 14, 2017, 11:37 pm UTC
 *
 * @property string name
 * @property string mail
 * @property integer phone
 * @property string subject
 * @property string body
 */
class Mail extends Model
{
    public $table = 'mail';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'mail',
        'phone',
        'subject',
        'body'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'mail' => 'string',
        'phone' => 'integer',
        'subject' => 'string',
        'body' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
