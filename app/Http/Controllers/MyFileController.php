<?php
namespace App\Http\Controllers;
use App\Http\Requests\CreateMyFileRequest;
use App\Http\Requests\UpdateMyFileRequest;
use App\Repositories\MyFileRepository;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
class MyFileController extends AppBaseController
{
    /** @var  MyFileRepository */
    private $myFileRepository;
    public function __construct(MyFileRepository $myFileRepo)
    {
        $this->myFileRepository = $myFileRepo;
    }
    /**
     * Display a listing of the MyFile.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->myFileRepository->pushCriteria(new RequestCriteria($request));
        $myFiles = $this->myFileRepository->paginate(25);
        return view('my_files.index')
            ->with('myFiles', $myFiles);
    }
    /**
     * Show the form for creating a new MyFile.
     *
     * @return Response
     */
    public function create()
    {
        return view('my_files.create');
    }
    /**
     * Store a newly created MyFile in storage.
     *
     * @param CreateMyFileRequest $request
     *
     * @return Response
     */
    public function store(CreateMyFileRequest $request)
    {
        $input = $request->all();
        $myFile = $this->myFileRepository->create($input);
        Flash::success('My File saved successfully.');
        return redirect(route('myFiles.index'));
    }
    /**
     * Display the specified MyFile.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $myFile = $this->myFileRepository->findWithoutFail($id);
        if (empty($myFile)) {
            Flash::error('My File not found');
            return redirect(route('myFiles.index'));
        }
        return view('my_files.show')->with('myFile', $myFile);
    }
    /**
     * Show the form for editing the specified MyFile.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $myFile = $this->myFileRepository->findWithoutFail($id);
        if (empty($myFile)) {
            Flash::error('My File not found');
            return redirect(route('myFiles.index'));
        }
        return view('my_files.edit')->with('myFile', $myFile);
    }
    /**
     * Update the specified MyFile in storage.
     *
     * @param  int              $id
     * @param UpdateMyFileRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMyFileRequest $request)
    {
        $myFile = $this->myFileRepository->findWithoutFail($id);
        if (empty($myFile)) {
            Flash::error('My File not found');
            return redirect(route('myFiles.index'));
        }
        $myFile = $this->myFileRepository->update($request->all(), $id);
        Flash::success('My File updated successfully.');
        return redirect(route('myFiles.index'));
    }
    /**
     * Remove the specified MyFile from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        echo "okkk";
        $myFile = $this->myFileRepository->findWithoutFail($id);
        if (empty($myFile)) {
            Flash::error('My File not found');
            return redirect(route('myFiles.index'));
        }
        $this->myFileRepository->delete($id);
        Flash::success('My File deleted successfully.');
        return redirect(route('myFiles.index'));
    }
    /**
     * Image Upload Code
     *
     * @return void
     */
    public function dropzoneTEST(Request $request)
    {
        return view('dropzone_test');
    }
    public function deleteUpload(Request $request)
    {
        return response()->json(['success'=>$request->file('file')]);
        echo "okkk";
    }
}