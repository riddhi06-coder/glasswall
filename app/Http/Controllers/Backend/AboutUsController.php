<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutUsController extends Controller
{
    public function index()
    {
        return view('backend.overview.about_us.index');
    }

    public function create()
    {
        return view('backend.overview.about_us.create');
    }
}