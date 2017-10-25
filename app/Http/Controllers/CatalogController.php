<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use App\Repositories\CatalogRepository;
use Illuminate\Http\Request;
use App\Models\MyFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Response;
use URL;
use Html;

class CatalogController extends AppBaseController
{
    const CATALOGS_IMAGES = '/public/images/files/shares/Catalogs/';

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
            $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
            $slug = $slug.'.'.$extension;
            $url = self::CATALOGS_IMAGES;
            $urlThumb = $url.'thumbs/';

            // create folder catalog if not exist
            $result = File::exists(base_path().$url);
            if ($result ==='false')
            {
                File::makeDirectory(base_path().$url, $mode = 0755, $recursive = true, $force = false);
            }

            // create image
            $file->move(base_path().$url,$slug);

            // create folder thumb if not exist
            $result = File::exists(base_path().$urlThumb);
            if (!$result)
            {
                File::makeDirectory(base_path().$urlThumb, $mode = 0755, $recursive = true, $force = false);
            }

            // create thumb image
            Image::make(base_path().$url.$slug)
                ->fit(config('lfm.thumb_img_width', 200), config('lfm.thumb_img_height', 200))
                ->save(base_path().$urlThumb.$slug);

            // create MyFile
            $new_file = new MyFile();
            $new_file->title  = $request->get('title');
            $new_file->name  = $name;
            $new_file->slug  = $slug;
            $new_file->url = URL::to($url.$slug);
            $new_file->save();
            $input['image_id'] = $new_file->id;
        }else{
            Flash::error('Imagen Obligatoria.');
            return redirect(route('catalogs.create'))->withInput($request->all());
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



        $url = self::CATALOGS_IMAGES;
        $urlThumb = $url.'/thumbs/';
        $old_file = MyFile::where('id','=',$catalog->image_id)->first();

        // Delete the images files
        File::delete(base_path().$url.$old_file->slug);
        File::delete(base_path().$urlThumb.$old_file->slug);

        $old_file->delete();

        $this->catalogRepository->delete($id);

        Flash::success('Catalog deleted successfully.');

        return redirect(route('catalogs.index'));
    }
}
