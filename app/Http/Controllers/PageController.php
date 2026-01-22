<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showSubPage($name)
    {
        if (view()->exists("pages.dashboard.$name"))
            {
                return view("pages.dashboard.$name");
            }
        abort(404);
    }
}
