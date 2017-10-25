<?php

namespace App\Repositories;

use App\Models\Promotions;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PromotionsRepository
 * @package App\Repositories
 * @version October 20, 2017, 11:40 pm UTC
 *
 * @method Promotion findWithoutFail($id, $columns = ['*'])
 * @method Promotion find($id, $columns = ['*'])
 * @method Promotion first($columns = ['*'])
*/
class PromotionsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'image_id',
        'pdf'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Promotions::class;
    }
}
