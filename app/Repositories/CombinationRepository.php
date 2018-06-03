<?php

namespace App\Repositories;

use App\Models\Combination;
use InfyOm\Generator\Common\BaseRepository;


class CombinationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'project_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Combination::class;
    }
}