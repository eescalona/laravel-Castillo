<?php

namespace App\Repositories;

use App\Models\Blog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BlogRepository
 * @package App\Repositories
 * @version November 9, 2017, 9:36 pm UTC
 *
 * @method Blog findWithoutFail($id, $columns = ['*'])
 * @method Blog find($id, $columns = ['*'])
 * @method Blog first($columns = ['*'])
*/
class BlogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description',
        'tags',
        'image_id',
        'url'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Blog::class;
    }
}
