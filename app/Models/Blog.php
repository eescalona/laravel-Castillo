<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Blog
 * @package App\Models
 * @version November 9, 2017, 9:36 pm UTC
 *
 * @property string title
 * @property string description
 * @property string tags
 * @property integer image_id
 * @property string url
 */
class Blog extends Model
{
    public $table = 'blogs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'title',
        'description',
        'tags',
        'image_id',
        'url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'tags' => 'string',
        'image_id' => 'integer',
        'url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'title' => 'required',
        'description' => 'required',
        'url' => 'required',
        'image' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function image()
    {
        return $this->hasOne(\App\Models\MyFile::class,'id','image_id');
    }
}
