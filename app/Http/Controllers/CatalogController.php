<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use App\Models\File;
use App\Repositories\CatalogRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use URL;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Html;

class CatalogController extends AppBaseController
{
    const PROJECTS_IMAGES = '/public/images/Catalogs/';
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
        // TODO try - catch con transaccion de base de datos
        $input = $request->all();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
            $slug = SlugService::createSlug(File::class, 'slug', $name);
            $url = self::PROJECTS_IMAGES;

            $new_file = new File();
            $new_file->title  = $request->get('title');
            $new_file->name  = $name;
            $new_file->url = URL::to($url.$slug.'.'.$extension);

            $request->file('image')->move(base_path().$url,$slug.'.'.$extension);
            $new_file->save();
            $input['image_id'] = $new_file->id;
        }
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
