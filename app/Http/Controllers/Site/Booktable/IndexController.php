<?php

namespace App\Http\Controllers\Site\Booktable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Rezervasyon';
        return view('site.book-table.index', compact('page_title'));
    }
}
