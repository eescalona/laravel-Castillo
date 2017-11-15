<?php

namespace App\Repositories;

use App\Models\Mail;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MailRepository
 * @package App\Repositories
 * @version November 14, 2017, 11:37 pm UTC
 *
 * @method Mail findWithoutFail($id, $columns = ['*'])
 * @method Mail find($id, $columns = ['*'])
 * @method Mail first($columns = ['*'])
*/
class MailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'mail',
        'phone',
        'subject',
        'body'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Mail::class;
    }
}
