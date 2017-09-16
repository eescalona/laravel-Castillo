<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use App\Repositories\CatalogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CatalogController extends AppBaseController
{
    /** @var  CatalogRepository */
    private $catalogRepository;

    public function __construct(CatalogRepository $catalogRepo)
    {
        $this->catalogRepository = $catalogRepo;
    }

    /**
     * Display a listing of the Catalog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->catalogRepository->pushCriteria(new RequestCriteria($request));
        $catalogs = $this->catalogRepository->paginate(25);

        return view('catalogs.index')
            ->with('catalogs', $catalogs);
    }

    /**
     * Show the form for creating a new Catalog.
     *
     * @return Response
     */
    public function create()
    {
        return view('catalogs.create');
    }

    /**
     * Store a newly created Catalog in storage.
     *
     * @param CreateCatalogRequest $request
     *
     * @return Response
     */
    public function store(CreateCatalogRequest $request)
    {
        $input = $request->all();

        $catalog = $this->catalogRepository->create($input);

        Flash::success('Catalog saved successfully.');

        return redirect(route('catalogs.index'));
    }

    /**
     * Display the specified Catalog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $catalog = $this->catalogRepository->findWithoutFail($id);

        if (empty($catalog)) {
            Flash::error('Catalog not found');

            return redirect(route('catalogs.index'));
        }

        return view('catalogs.show')->with('catalog', $catalog);
    }

    /**
     * Show the form for editing the specified Catalog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $catalog = $this->catalogRepository->findWithoutFail($id);

        if (empty($catalog)) {
            Flash::error('Catalog not found');

            return redirect(route('catalogs.index'));
        }

        return view('catalogs.edit')->with('catalog', $catalog);
    }

    /**
     * Update the specified Catalog in storage.
     *
     * @param  int              $id
     * @param UpdateCatalogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatalogRequest $request)
    {
        $catalog = $this->catalogRepository->findWithoutFail($id);

        if (empty($catalog)) {
            Flash::error('Catalog not found');

            return redirect(route('catalogs.index'));
        }

        $catalog = $this->catalogRepository->update($request->all(), $id);

        Flash::success('Catalog updated successfully.');

        return redirect(route('catalogs.index'));
    }

    /**
     * Remove the specified Catalog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $catalog = $this->catalogRepository->findWithoutFail($id);

        if (empty($catalog)) {
            Flash::error('Catalog not found');

            return redirect(route('catalogs.index'));
        }

        $this->catalogRepository->delete($id);

        Flash::success('Catalog deleted successfully.');

        return redirect(route('catalogs.index'));
    }
}
