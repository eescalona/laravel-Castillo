<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProjectAPIRequest;
use App\Http\Requests\API\UpdateProjectAPIRequest;
use App\Models\Category;
use App\Models\MyFile;
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
     * Display a listing of the Project filter by category.
     * GET|HEAD /projects
     *
     * @param Request $request, $category_slug
     * @return Response
     */
    public function index(Request $request,$category_slug = NULL)
    {
        $this->projectRepository->pushCriteria(new RequestCriteria($request));
        $this->projectRepository->pushCriteria(new LimitOffsetCriteria($request));

        if($category_slug == NULL){
            $projects = $this->projectRepository->All();
        } else{
            $category = Category::whereSlug($category_slug)->first();
            if(is_null($category)){
                return $this->sendResponse(NULL, 'Category not found');
            }
            $projects = Project::whereCategoryId($category->id)->orderBy('id', 'DESC')->get();

            $projects->transform(function ($project, $key) {
                if(isset($project->image)){
                    $project->image_url = $project->image->url;
                }else{
                    $project->image_url = '';
                }
                $list=Project::whereCategoryId($project->category_id)->orderBy('id', 'DESC')->get();
                $maxItem=$list->count()-2;
                if($key>$maxItem){
                    $project->next_id = 0;
                }else{
                    $project->next_id = $list[$key+1]->id;
                }

                if($key==0){
                    $project->prev_id = 0;
                }else{
                    $project->prev_id = $list[$key-1]->id;
                }

                return $project;
            });
        }

        return $this->sendResponse($projects->toArray(), 'Projects retrieved successfully');
    }

    /**
     * Display a listing of the Project.
     * GET|HEAD /projects
     *
     * @param Request $request
     * @return Response
     */
    public function gallery(Request $request, $project_id){
        $principal_image = Project::whereId($project_id)->first()->image;
        $all_files = MyFile::whereProjectId($project_id)
            ->where('id', '<>',$principal_image->id)
            ->get();
        $all_files->prepend($principal_image);
        return $this->sendResponse($all_files, 'Gallery retrieved successfully');

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
        }else{
            if(isset($project->image)){
                $project->image_url = $project->image->url;
            }else{
                $project->image_url = '';
            }
        }

        // get next and previous item on the list
        $list=Project::whereCategoryId($project->category_id)->orderBy('id', 'DESC')->get();
        $project_pos =-1;
        $list->filter(function($collection) use ($project, &$project_pos) {
            $project_pos++;
            if ($collection->id === $project->id) {
                return true;
            }
            return false;
        });
        $project_pos--;
        $maxItem = $list->count()-1;
        if ($project_pos == $maxItem) {
            $project->next_id = 0;
        } else {
            $project->next_id = $list[$project_pos+1]->id;
        }

        if ($project_pos == 0) {
            $project->prev_id = 0;
        } else {
            $project->prev_id = $list[$project_pos-1]->id;
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
