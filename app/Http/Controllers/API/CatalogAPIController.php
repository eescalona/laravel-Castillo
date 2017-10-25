<?php

namespace App\Http\Controllers\API;

use App\Repositories\CatalogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\File;

/**
 * Class CatalogController
 * @package App\Http\Controllers\API
 */

class CatalogAPIController extends AppBaseController
{
    /** @var  CatalogRepository */
    private $catalogRepository;

    public function __construct(CatalogRepository $catalogRepo)
    {
        $this->catalogRepository = $catalogRepo;
    }

    /**
     * Display a listing of the Catalog.
     * GET|HEAD /catalogs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->catalogRepository->pushCriteria(new RequestCriteria($request));
        $this->catalogRepository->pushCriteria(new LimitOffsetCriteria($request));

        $catalogs = $this->catalogRepository->all();

        $catalogs->transform(function ($catalog, $key) {
            if(isset($catalog->image)){
                $catalog->image_url = $catalog->image->url;
            }else{
                $catalog->image_url = '';
            }
            $catalog->extension = File::extension($catalog->url);

            return $catalog;
        });

        return $this->sendResponse($catalogs->toArray(), 'Catalogs retrieved successfully');
    }

}
