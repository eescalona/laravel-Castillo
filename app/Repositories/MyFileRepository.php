<?php
namespace App\Repositories;
use App\Models\MyFile;
use InfyOm\Generator\Common\BaseRepository;
/**
 * Class MyFileRepository
 * @package App\Repositories
 * @version September 19, 2017, 7:07 pm UTC
 *
 * @method MyFile findWithoutFail($id, $columns = ['*'])
 * @method MyFile find($id, $columns = ['*'])
 * @method MyFile first($columns = ['*'])
 */
class MyFileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'project_id',
        'title',
        'slug',
        'url',
        'name'
    ];
    /**
     * Configure the Model
     **/
    public function model()
    {
        return MyFile::class;
    }
}