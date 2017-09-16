<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProjectAPIRequest;
use App\Http\Requests\API\UpdateProjectAPIRequest;
use App\Models\Category;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use PhpParser\Node\Name;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProjectController
 * @package App\Http\Controllers\API
 */

class ProjectAPIController extends AppBaseController
{
    /** @var  ProjectRepository */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepository = $projectRepo;
    }

    /**
     * Display a listing of the Project.
     * GET|HEAD /projects
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request,$category_id = NULL)
    {
        $this->projectRepository->pushCriteria(new RequestCriteria($request));
        $this->projectRepository->pushCriteria(new LimitOffsetCriteria($request));

        if($category_id == NULL){
            $projects = $this->projectRepository->All();
        } else{
            $category = Category::whereSlug($category_id)->first();
            if(is_null($category)){
                return $this->sendResponse(NULL, 'Category not found');
            }
            $projects = Project::whereCategoryId($category->id)->get();

            $projects->transform(function ($proyect, $key) {
                if(isset($proyect->image)){
                    $proyect->image_url = $proyect->image->url;
                }else{
                    $proyect->image_url = '';
                }
                return $proyect;
            });
        }

        return $this->sendResponse($projects->toArray(), 'Projects retrieved successfully');
    }

    public function test(Request $request, string $input, integer $id = null){
        return $this->sendResponse($input.$id, 'Projects retrieved successfully');

    }

    /**
     * Store a newly created Project in storage.
     * POST /projects
     *
     * @param CreateProjectAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectAPIRequest $request)
    {
        $input = $request->all();

        $projects = $this->projectRepository->create($input);

        return $this->sendResponse($projects->toArray(), 'Project saved successfully');
    }

    /**
     * Display the specified Project.
     * GET|HEAD /projects/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Project $project */
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        return $this->sendResponse($project->toArray(), 'Project retrieved successfully');
    }

    /**
     * Update the specified Project in storage.
     * PUT/PATCH /projects/{id}
     *
     * @param  int $id
     * @param UpdateProjectAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectAPIRequest $request)
    {
        $input = $request->all();

        /** @var Project $project */
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $project = $this->projectRepository->update($input, $id);

        return $this->sendResponse($project->toArray(), 'Project updated successfully');
    }

    /**
     * Remove the specified Project from storage.
     * DELETE /projects/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Project $project */
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $project->delete();

        return $this->sendResponse($id, 'Project deleted successfully');
    }
}
