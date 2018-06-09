<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Show site dashboard.
     *
     * @return Response
     */
    public function dashboard()
    {
        return view('backend.site.dashboard');
    }


    
}
