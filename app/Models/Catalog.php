<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Catalog
 * @package App\Models
 * @version September 16, 2017, 4:32 pm UTC
 *
 * @property string title
 * @property integer image
 * @property string url
 */
class Catalog extends Model
{
    public $table = 'catalogs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'title',
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
