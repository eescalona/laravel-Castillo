<?php
namespace App\Models;

use Eloquent as Model;

class Options extends Model
{
    public $table = 'options';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'combination_id',
        'title',
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'combination_id',
        'title',
        'slug'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function combination()
    {
        return $this->hasOne(Combination::class,'id','combination_id');
    }
}