<?php

namespace App\Repositories;

use App\Models\Catalog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CatalogRepository
 * @package App\Repositories
 * @version September 16, 2017, 4:32 pm UTC
 *
 * @method Catalog findWithoutFail($id, $columns = ['*'])
 * @method Catalog find($id, $columns = ['*'])
 * @method Catalog first($columns = ['*'])
*/
class CatalogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'image',
        'url'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Catalog::class;
    }
}
