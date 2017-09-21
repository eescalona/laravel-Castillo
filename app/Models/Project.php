<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * Class Project
 * @package App\Models
 * @version September 1, 2017, 8:08 pm UTC
 *
 * @property \App\Models\Category category
 * @property \App\Models\Style style
 * @property \Illuminate\Database\Eloquent\Collection File
 * @property string title
 * @property integer year
 * @property integer category_id
 * @property integer style_id
 * @property string price
 * @property string description
 * @property string address
 * @property integer 'image'
 */
class Project extends Model
{
    use SoftDeletes;

    public $table = 'projects';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'year',
        'category_id',
        'style',
        'price',
        'description',
        'address',
        'image_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'year' => 'integer',
        'category_id' => 'integer',
        'style' => 'string',
        'price' => 'string',
        'description' => 'string',
        'address' => 'string',
        'image_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'image' => 'required',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function image()
    {
        return $this->hasOne(\App\Models\File::class,'id','image_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function files()
    {
        return $this->hasMany(\App\Models\MyFile::class);
    }
}
