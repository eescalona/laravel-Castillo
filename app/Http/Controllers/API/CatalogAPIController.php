<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCatalogAPIRequest;
use App\Http\Requests\API\UpdateCatalogAPIRequest;
use App\Models\Catalog;
use App\Repositories\CatalogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

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
            return $catalog;
        });

        return $this->sendResponse($catalogs->toArray(), 'Catalogs retrieved successfully');
    }

    /**
     * Store a newly created Catalog in storage.
     * POST /catalogs
     *
     * @param CreateCatalogAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCatalogAPIRequest $request)
    {
        $input = $request->all();

        $catalogs = $this->catalogRepository->create($input);

        return $this->sendResponse($catalogs->toArray(), 'Catalog saved successfully');
    }

    /**
     * Display the specified Catalog.
     * GET|HEAD /catalogs/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Catalog $catalog */
        $catalog = $this->catalogRepository->findWithoutFail($id);

        if (empty($catalog)) {
            return $this->sendError('Catalog not found');
        }

        return $this->sendResponse($catalog->toArray(), 'Catalog retrieved successfully');
    }

    /**
     * Update the specified Catalog in storage.
     * PUT/PATCH /catalogs/{id}
     *
     * @param  int $id
     * @param UpdateCatalogAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatalogAPIRequest $request)
    {
        $input = $request->all();

        /** @var Catalog $catalog */
        $catalog = $this->catalogRepository->findWithoutFail($id);

        if (empty($catalog)) {
            return $this->sendError('Catalog not found');
        }

        $catalog = $this->catalogRepository->update($input, $id);

        return $this->sendResponse($catalog->toArray(), 'Catalog updated successfully');
    }

    /**
     * Remove the specified Catalog from storage.
     * DELETE /catalogs/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Catalog $catalog */
        $catalog = $this->catalogRepository->findWithoutFail($id);

        if (empty($catalog)) {
            return $this->sendError('Catalog not found');
        }

        $catalog->delete();

        return $this->sendResponse($id, 'Catalog deleted successfully');
    }
}
