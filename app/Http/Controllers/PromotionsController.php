<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePromotionsRequest;
use App\Http\Requests\UpdatePromotionsRequest;
use App\Repositories\PromotionsRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\MyFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use URL;
use Html;

class PromotionsController extends AppBaseController
{
    const PROMOTIONS_IMAGES = '/public/images/files/shares/Promotions/';

    /** @var  PromotionsRepository */
    private $promotionsRepository;

    public function __construct(PromotionsRepository $promotionsRepo)
    {
        $this->promotionsRepository = $promotionsRepo;
    }

    /**
     * Display a listing of the Promotions.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->promotionsRepository->pushCriteria(new RequestCriteria($request));
        $promotions = $this->promotionsRepository->orderBy('id', 'DESC')->paginate(25);

        return view('promotions.index')
            ->with('promotions', $promotions);
    }

    /**
     * Show the form for creating a new Promotions.
     *
     * @return Response
     */
    public function create()
    {
        return view('promotions.create');
    }

    /**
     * Store a newly created Promotions in storage.
     *
     * @param CreatePromotionsRequest $request
     *
     * @return Response
     */
    public function store(CreatePromotionsRequest $request)
    {
        $input = $request->all();

        $input['pdf'] = '';
        $new_promotion = $this->promotionsRepository->create($input);
        $promotion_path = sprintf("%04d",$new_promotion->id).'-'.$new_promotion->title.'/';
        $url = self::PROMOTIONS_IMAGES.$promotion_path;

        if($request->hasFile('filePdf')) {

            $file = $request->file('filePdf');
            $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
            $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
            $slug = $slug.'.'.$extension;
            // create folder Promotions
            File::makeDirectory(base_path().$url, $mode = 0755, $recursive = true, $force = false);

            // create image
            $file->move(base_path().$url,$slug);

//            $input['pdf'] = URL::to($url.$slug);
            $new_promotion->pdf = URL::to($url.$slug);
        }else{
            Flash::error('Pdf Obligatoria.');
            return redirect(route('promotions.create'))->withInput($request->all());
        }
        if($request->hasFile('image')){
            $file = $request->file('image');
            $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
            $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
            $slug = $slug.'.'.$extension;
            $urlThumb = $url.'/thumbs/';

            // create image     // Folder create  at filePdf
            $file->move(base_path().$url,$slug);

            // create folder thumb
            File::makeDirectory(base_path().$urlThumb, $mode = 0755, $recursive = true, $force = false);



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
            $new_promotion->image_id = $new_file->id;
        }else{
            Flash::error('Imagen Obligatoria.');
            return redirect(route('promotions.create'))->withInput($request->all());
        }

        // Update promotion with image_id and Pdf
        $new_promotion->save();

        Flash::success('Promotions saved successfully.');

        return redirect(route('promotions.index'));
    }

    /**
     * Display the specified Promotions.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $promotions = $this->promotionsRepository->findWithoutFail($id);

        if (empty($promotions)) {
            Flash::error('Promotions not found');

            return redirect(route('promotions.index'));
        }

        return view('promotions.show')->with('promotions', $promotions);
    }

    /**
     * Show the form for editing the specified Promotions.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $promotions = $this->promotionsRepository->findWithoutFail($id);

        if (empty($promotions)) {
            Flash::error('Promotions not found');

            return redirect(route('promotions.index'));
        }

        return view('promotions.edit')->with('promotions', $promotions);
    }

    /**
     * Update the specified Promotions in storage.
     *
     * @param  int              $id
     * @param UpdatePromotionsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePromotionsRequest $request)
    {
        $promotions = $this->promotionsRepository->findWithoutFail($id);

        if (empty($promotions)) {
            Flash::error('Promotions not found');

            return redirect(route('promotions.index'));
        }

        $promotions = $this->promotionsRepository->update($request->all(), $id);

        Flash::success('Promotions updated successfully.');

        return redirect(route('promotions.index'));
    }

    /**
     * Remove the specified Promotions from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $promotions = $this->promotionsRepository->findWithoutFail($id);

        if (empty($promotions)) {
            Flash::error('Promotions not found');

            return redirect(route('promotions.index'));
        }

        // delete folder
        $id= sprintf("%04d",$promotions->id); // add the zero if it's less than 4 characters.
        $urlPromotion = self::PROMOTIONS_IMAGES.$id.'-'.$promotions->title;
        File::deleteDirectory(base_path().$urlPromotion, $preserve = false);

        // delete file on db
        $old_file = MyFile::where('id','=',$promotions->image_id)->first();
        $old_file->delete();

        // delete promotion
        $this->promotionsRepository->delete($id);

        Flash::success('Promotions deleted successfully.');

        return redirect(route('promotions.index'));
    }
}
