<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Repositories\ProjectRepository;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use App\Models\MyFile;
use Intervention\Image\Facades\Image;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Response;
use URL;
use Html;
use App\Models\Project;
use Illuminate\Support\Facades\File;

class ProjectController extends AppBaseController
{
    const PROJECTS_IMAGES = '/public/images/files/shares/Projects/';

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
        $this->projectRepository->pushCriteria(new RequestCriteria($request));
        $projects = $this->projectRepository->orderBy('id', 'DESC')->paginate(25);

        return view('projects.index')
            ->with('projects', $projects);
    }

    /**
     * Display a listing of the Project.
     *
     * @param Request $request
     * @return Response
     */
    public function filtered(Request $request,$category)
    {
        $this->projectRepository->pushCriteria(new RequestCriteria($request));
        switch ($category){
            case 'cocinas': $projects_filter = Project::where('category_id','=',1); break;
            case 'armarios': $projects_filter = Project::where('category_id','=',2); break;
            default:
                $this->projectRepository->pushCriteria(new RequestCriteria($request));
                $projects = $this->projectRepository->orderBy('id', 'DESC')->paginate(25);
                return view('projects.index')->with('projects', $projects);
            break;
        }
        $projects = $projects_filter->orderBy('id', 'DESC')->paginate(25);

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

        // validate if exist file
        if(!$request->hasFile('image')) {
            Flash::error('Imagen Obligatoria.');
            return redirect(route('projects.create'))->withInput($request->all());
        }

        // get info for MyFile
        $file = $request->file('image');
        $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
        $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
        $slug = $slug.'.'.$extension;

        // create MyFile
        $new_file = new MyFile();
        $new_file->title  = $request->get('title');
        $new_file->name  = $name;
        $new_file->slug = $slug;
        $new_file->url = $slug; // url must be not null, after we update it.
        $new_file->save();

        // create Project
        $input['image_id'] = $new_file->id;
        $project = $this->projectRepository->create($input);

        // create folder project
        $id= sprintf("%04d",$project->id);
        $urlProject = self::PROJECTS_IMAGES.$id.'-'.$project->title;
        File::makeDirectory(base_path().$urlProject, $mode = 0755, $recursive = true, $force = false);

        // create folder principal
        $urlPrincipal = $urlProject.'/Principal/';
        File::makeDirectory(base_path().$urlPrincipal, $mode = 0755, $recursive = true, $force = false);

        // create principal image
        $request->file('image')->move(base_path().$urlPrincipal,$slug);

        // create folder thumb if not exist
        $urlThumb = $urlPrincipal.'thumbs/';
        File::makeDirectory(base_path().$urlThumb, $mode = 0755, $recursive = true, $force = false);

        // create thumb image
        Image::make(base_path().$urlPrincipal.$slug)
            ->fit(config('lfm.thumb_img_width', 200), config('lfm.thumb_img_height', 200))
            ->save(base_path().$urlThumb.$slug);

        // Update MyFile
        $new_file->url = URL::to($urlPrincipal.$slug);
        $new_file->project_id = $project->id;
        $new_file->save();

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
        // TODO try - catch con transaccion de base de datos.

        $old_project = $this->projectRepository->findWithoutFail($id);

        if($request->hasFile('image'))
        {
            $file = $request->file('image');

            $name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo( $file->getClientOriginalName(), PATHINFO_EXTENSION);
            $slug = SlugService::createSlug(MyFile::class, 'slug', $name);
            $slug = $slug.'.'.$extension;
            $id= sprintf("%04d",$old_project->id);
            $urlProject = self::PROJECTS_IMAGES.$id.'-'.$old_project->title;

            // delete folder principal
            $urlPrincipal = $urlProject.'/Principal/';
            File::deleteDirectory(base_path().$urlPrincipal, $preserve = false);

            // create folder principal
            $urlPrincipal = $urlProject.'/Principal/';
            File::makeDirectory(base_path().$urlPrincipal, $mode = 0755, $recursive = true, $force = false);

            // create principal image
            $request->file('image')->move(base_path().$urlPrincipal,$slug);

            // create folder thumb if not exist
            $urlThumb = $urlPrincipal.'thumbs/';
            File::makeDirectory(base_path().$urlThumb, $mode = 0755, $recursive = true, $force = false);

            // create thumb image
            Image::make(base_path().$urlPrincipal.$slug)
                ->fit(config('lfm.thumb_img_width', 200), config('lfm.thumb_img_height', 200))
                ->save(base_path().$urlThumb.$slug);

            $old_file = MyFile::where('id','=',$old_project->image->id)->first();
            $old_file->name  = $name;
            $old_file->slug  = $slug;
            $old_file->url = URL::to($urlPrincipal.$slug);
            $old_file->save();
        }

        $input = $request->all();
        $project = $this->projectRepository->update($input, $id);

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

        // delete folder project
        $id= sprintf("%04d",$project->id);
        $urlProject = self::PROJECTS_IMAGES.$id.'-'.$project->title;
        File::deleteDirectory(base_path().$urlProject, $preserve = false);

        $this->projectRepository->delete($id);

        Flash::success('Project deleted successfully.');

        return redirect(route('projects.index'));
    }
}
