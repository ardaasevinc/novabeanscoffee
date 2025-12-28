<?php

namespace App\Http\Controllers\Site\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('site.services.index');
    }
}
