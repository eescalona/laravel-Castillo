<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Promotions
 * @package App\Models
 * @version October 20, 2017, 11:40 pm UTC
 *
 * @property integer id
 * @property string title
 * @property integer image_id
 * @property string pdf
 */
class Promotions extends Model
{
    public $table = 'promotions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'image_id',
        'pdf'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'image_id' => 'integer',
        'pdf' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'image' => 'required',
        'filePdf' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function image()
    {
        return $this->hasOne(\App\Models\MyFile::class,'id','image_id');
    }
}
