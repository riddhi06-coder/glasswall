<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{

    public function index()
    {
        return view('backend.products.category.index');
    }

    public function create()
    {
        return view('backend.products.category.create');
    }

}