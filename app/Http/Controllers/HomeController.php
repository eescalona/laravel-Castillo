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
     * Show register view
     *
     * @return void
     */
    public function register(){
        return view('auth.register');
    }
}
