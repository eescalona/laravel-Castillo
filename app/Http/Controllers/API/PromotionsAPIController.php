<?php

namespace App\Http\Controllers\API;

use App\Repositories\PromotionsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\File;

/**
 * Class PromotionAPIController
 * @package App\Http\Controllers\API
 */

class PromotionsAPIController extends AppBaseController
{
    /** @var  PromotionsRepository */
    private $promotionsRepository;

    public function __construct(PromotionsRepository $promotionRepo)
    {
        $this->promotionsRepository = $promotionRepo;
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
        $this->promotionsRepository->pushCriteria(new RequestCriteria($request));
        $this->promotionsRepository->pushCriteria(new LimitOffsetCriteria($request));

        $promotions = $this->promotionsRepository->all();

        $promotions->transform(function ($promotion, $key) {
            if(isset($promotion->image)){
                $promotion->image_url = $promotion->image->url;
            }else{
                $promotion->image_url = '';
            }
            $promotion->extension = File::extension($promotion->pdf);
            $promotion->url = $promotion->pdf;
            return $promotion;
        });

        return $this->sendResponse($promotions->toArray(), 'Promotion retrieved successfully');
    }

}
