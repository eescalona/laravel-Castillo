<?php
/**
 * Created by PhpStorm.
 * User: Ernes
 * Date: 10/11/2017
 * Time: 00:26
 */

namespace App\Http\Controllers\API;

use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\File;

class BlogAPIController extends AppBaseController
{
    /** @var  BlogRepository */
    private $blogRepository;

    public function __construct(BlogRepository $blogRepo)
    {
        $this->blogRepository = $blogRepo;
    }

    /**
     * Display a listing of the Promotion.
     * GET|HEAD /promotions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->blogRepository->pushCriteria(new RequestCriteria($request));
        $this->blogRepository->pushCriteria(new LimitOffsetCriteria($request));

        $blogs = $this->blogRepository->orderBy('id', 'DESC')->all();

        $blogs->transform(function ($blog, $key) {
            if(isset($blog->image)){
                $blog->image_url = $blog->image->url;
            }else{
                $blog->image_url = '';
            }
            return $blog;
        });

        return $this->sendResponse($blogs->toArray(), 'Blog retrieved successfully');
    }
}