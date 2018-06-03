<?php
namespace App\Models;
use Eloquent as Model;
use Cviebrock\EloquentSluggable\Sluggable;
/**
 * Class MyFile
 * @package App\Models
 * @version September 19, 2017, 7:07 pm UTC
 *
 * @property integer project_id
 * @property string title
 * @property string slug
 * @property string url
 * @property string name
 */
class MyFile extends Model
{
    public $table = 'files';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = [];
    public $fillable = [
        'project_id',
        'title',
        'slug',
        'url'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'project_id' => 'integer',
        'title' => 'string',
        'name' => 'string',
        'slug' => 'string',
        'url' => 'string',
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];
    use Sluggable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function options()
    {
        return $this->hasMany(Options::class);
    }

}