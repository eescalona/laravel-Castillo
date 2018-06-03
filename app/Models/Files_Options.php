<?php
namespace App\Models;

use Eloquent as Model;

class Files_Options extends Model
{
    public $table = 'files_options';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'file_id',
        'option_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'file_id',
        'option_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function files()
    {
        return $this->hasOne(MyFile::class,'id','file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function options()
    {
        return $this->hasOne(Options::class,'id','option_id');
    }
}