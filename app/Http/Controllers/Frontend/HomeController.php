<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Models\HomeAbout;
use App\Models\HomeClientele;
use App\Models\HomeBlog;
use App\Models\ProjectCategory;
use App\Models\ProjectListing;
use App\Models\ContactDetail;
use App\Models\AboutUs;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{

    // Home Page
    public function index()
    {
        $banners    = HomeBanner::orderBy('id')->get();
        $about      = HomeAbout::with('milestones')->latest()->first();
        $clientele  = HomeClientele::latest()->first();
        $blog       = HomeBlog::latest()->first();
        $categories = ProjectCategory::orderBy('priority')->orderBy('name')->get();

        $homeProjects = ProjectListing::with('category')
            ->where('is_active', true)
            ->where('show_on_home', true)
            ->orderBy('priority')
            ->orderBy('id')
            ->get();

        return view('frontend.index', compact('banners', 'about', 'clientele', 'blog', 'categories', 'homeProjects'));
    }

    // Projects listing by category (slug-bound)
    public function projects(ProjectCategory $category)
    {
        $projects = $category->listings()
            ->where('is_active', true)
            ->orderBy('priority')
            ->orderBy('id')
            ->get();

        return view('frontend.projects', compact('category', 'projects'));
    }

    // Single project detail page (category slug + project slug)
    public function projects_details(ProjectCategory $category, ProjectListing $project)
    {
        // Ensure the project actually belongs to this category.
        abort_if($project->project_category_id !== $category->id, 404);

        $detail = $project->detail()->first();

        return view('frontend.project-details', compact('category', 'project', 'detail'));
    }

    // Contact Us page
    public function contact_us()
    {
        $contact = ContactDetail::latest()->first();

        return view('frontend.contact_us', compact('contact'));
    }

    // About Us page
    public function about_us()
    {
        $about = AboutUs::latest()->first();

        return view('frontend.about_us', compact('about'));
    }

}