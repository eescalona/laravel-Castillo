<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Repositories\BlogRepository;
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

class BlogController extends AppBaseController
{
    const BLOGS_IMAGES = '/public/images/files/shares/Blog/';

    /** @var  BlogRepository */
    private $blogRepository;

    public function __construct(BlogRepository $blogRepo)
    {
        $this->blogRepository = $blogRepo;
    }

    /**
     * Display a listing of the Blog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->blogRepository->pushCriteria(new RequestCriteria($request));
        $blogs = $this->blogRepository->orderBy('id', 'DESC')->paginate(25);

        return view('blogs.index')
            ->with('blogs', $blogs);
    }

    /**
     * Show the form for creating a new Blog.
     *
     * @return Response
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created Blog in storage.
     *
     * @param CreateBlogRequest $request
     *
     * @return Response
     */
    public function store(CreateBlogRequest $request)
    {
        $input = $request->all();

        $new_blog = $this->blogRepository->create($input);
        $blog_path = sprintf("%04d",$new_blog->id).'/';
        $url = self::BLOGS_IMAGES.$blog_path;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
            $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
            $slug = $slug.'.'.$extension;
            $urlThumb = $url.'/thumbs/';

            // create folder Blog
            File::makeDirectory(base_path().$url, $mode = 0755, $recursive = true, $force = false);

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
            $new_blog->image_id = $new_file->id;
        }else{
            Flash::error('Imagen Obligatoria.');
            return redirect(route('blogs.create'))->withInput($request->all());
        }

        // Update promotion with image_id and Pdf
        $new_blog->save();

        Flash::success('Blog saved successfully.');

        return redirect(route('blogs.index'));
    }

    /**
     * Display the specified Blog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        return view('blogs.show')->with('blog', $blog);
    }

    /**
     * Show the form for editing the specified Blog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        return view('blogs.edit')->with('blog', $blog);
    }

    /**
     * Update the specified Blog in storage.
     *
     * @param  int              $id
     * @param UpdateBlogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBlogRequest $request)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        $blog = $this->blogRepository->update($request->all(), $id);

        Flash::success('Blog updated successfully.');

        return redirect(route('blogs.index'));
    }

    /**
     * Remove the specified Blog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        $this->blogRepository->delete($id);

        Flash::success('Blog deleted successfully.');

        return redirect(route('blogs.index'));
    }
}
