<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('Home/Index/index');
    }

    public function show()
    {
        echo route('Home#i_show'),'<br/>';
        return 'this is route as name';
    }

}
