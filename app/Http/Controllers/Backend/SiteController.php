<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function dashboard()
    {
        return view('backend.site.dashboard');
    }

    
}
