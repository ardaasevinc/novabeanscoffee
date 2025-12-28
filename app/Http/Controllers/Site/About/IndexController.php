<?php

namespace App\Http\Controllers\Site\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('site.about.index');
    }
}
