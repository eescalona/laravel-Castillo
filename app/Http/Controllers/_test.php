<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalog;

class _test extends Controller
{
    function catalog(){
        $catalogos = Catalog::all();


        dd($catalogos->first()->image);
    }
}
