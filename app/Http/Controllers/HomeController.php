<?php

namespace App\Http\Controllers;


use App\Models\Project as Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    /**
     * Generate Image upload View
     *
     * @return void
     */
    public function dropzone()
    {
        return view('dropzone');
    }

    /**
     * Image Upload Code
     *
     * @return void
     */
    public function dropzoneStore(Request $request)
    {


        $image = $request->file('file');
        $imageName = time().$image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);




        return response()->json(['success'=>$imageName]);
    }
}
