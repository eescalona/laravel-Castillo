<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\File as MyFile;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use URL;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Html;
use File;

class ProjectController extends AppBaseController
{
    const PROJECTS_IMAGES = '/public/images/projects/';
    /** @var  ProjectRepository */
    private $projectRepository;


    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepository = $projectRepo;
    }

    /**
     * Display a listing of the Project.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //return "mi test";
        $this->projectRepository->pushCriteria(new RequestCriteria($request));
        $projects = $this->projectRepository->orderBy('id', 'DESC')->paginate(25);

        return view('projects.index')
            ->with('projects', $projects);
    }

    /**
     * Show the form for creating a new Project.
     *
     * @return Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param CreateProjectRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectRequest $request)
    {
        // TODO try - catch con transaccion de base de datos
        $input = $request->all();
        $this->validate($request,Project::$rules);
        if($request->hasFile('image')){
            $file = $request->file('image');
            $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
            $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
            $url = self::PROJECTS_IMAGES;

            $new_file = new MyFile();
            $new_file->title  = $request->get('title');
            $new_file->name  = $name;
            $new_file->url = URL::to($url.$slug.'.'.$extension);

            $request->file('image')->move(base_path().$url,$slug.'.'.$extension);
            $new_file->save();
            $input['image_id'] = $new_file->id;
        }

        $project = $this->projectRepository->create($input);
        if($request->hasFile('image')) {
            $new_file->project_id = $project->id;
            $new_file->save();
        }
        Flash::success('Project saved successfully.');

        return redirect(route('projects.index'));
    }

    /**
     * Display the specified Project.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        return view('projects.show')->with('project', $project);
    }

    /**
     * Show the form for editing the specified Project.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $project = $this->projectRepository->findWithoutFail($id);
        $image = $project->image;

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        return view('projects.edit',['project' => $project , 'image' => $image]);
    }

    /**
     * Update the specified Project in storage.
     *
     * @param  int              $id
     * @param UpdateProjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectRequest $request)
    {
        // TODO try - catch con transaccion de base de datos
        $input = $request->all();

        if($request->hasFile('image')){
            $file = $request->file('image');

            $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
            $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
            $url = self::PROJECTS_IMAGES;

            $new_file = new MyFile();
            $new_file->title  = $request->get('title');
            $new_file->name  = $name;
            $new_file->url = URL::to($url.$slug.'.'.$extension);

            $request->file('image')->move(base_path().$url,$slug.'.'.$extension);
            $new_file->save();
            $input['image_id'] = $new_file->id;
        }

        $project = $this->projectRepository->findWithoutFail($id);
        $file_delete = $project->image;
        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        $project = $this->projectRepository->update($input, $id);
        if($request->hasFile('image')){
            //File::delete($file_delete->slug);
            unlink ($file_delete->url);
            $file_delete->delete();
        }
        Flash::success('Project updated successfully.');

        return redirect(route('projects.index'));
    }

    /**
     * Remove the specified Project from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        $this->projectRepository->delete($id);

        Flash::success('Project deleted successfully.');

        return redirect(route('projects.index'));
    }

    public function galleryView($id){
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        return view('projects.gallery')->with('project', $project);
    }
}
