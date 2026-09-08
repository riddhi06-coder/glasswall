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
use App\Models\BoardDirector;
use App\Models\Innovation;
use App\Models\Media;
use App\Models\AwardsCategory;
use App\Models\AwardsRecognition;
use App\Models\Esg;
use App\Models\ProductCategory;
use App\Models\ProductListing;
use App\Models\CareerDetail;
use App\Models\CareerJob;
use App\Models\DesignEngineering;
use App\Models\ProjectManagement;
use App\Models\Facility;
use App\Models\AnnualReport;
use App\Models\InvestorResource;
use App\Models\GovernanceDocument;
use App\Models\IpoDocument;
use App\Models\IpoDrhp;
use App\Models\LegalPage;
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

        $productCategories = ProductCategory::where('is_active', true)
            ->orderBy('priority')
            ->orderBy('name')
            ->get();

        $homeProjects = ProjectListing::with('category')
            ->where('is_active', true)
            ->where('show_on_home', true)
            ->orderBy('priority')
            ->orderBy('id')
            ->get();

        return view('frontend.index', compact('banners', 'about', 'clientele', 'blog', 'categories', 'productCategories', 'homeProjects'));
    }

    // Projects landing — lists all project categories (like the products landing)
    public function projects_category_listing()
    {
        $categories = ProjectCategory::orderBy('priority')->orderBy('name')->get();

        return view('frontend.projects_listing', compact('categories'));
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

    // Board of Directors page
    public function board_of_directors()
    {
        $directors = BoardDirector::orderBy('id')->get();
        $banner    = $directors->first(); // banner fields live on the first record

        return view('frontend.board_of_directors', compact('directors', 'banner'));
    }

    // Innovation page
    public function innovation()
    {
        $innovations = Innovation::orderBy('id')->get();
        $banner      = $innovations->first(); // banner fields live on the first record

        return view('frontend.innovation', compact('innovations', 'banner'));
    }

    // Media page
    public function media()
    {
        $media  = Media::orderBy('id')->get();
        $banner = $media->first(); // banner fields live on the first record

        return view('frontend.media', compact('media', 'banner'));
    }

    // ESG page
    public function esg()
    {
        $esg = Esg::with(['innovationFeatures', 'drivingCounts', 'impacts', 'wasteFeatures'])->first();

        return view('frontend.esg', compact('esg'));
    }

    // Awards & Recognition page
    public function awards_recognition()
    {
        $categories  = AwardsCategory::orderBy('id')->get();
        $awardsByCat = AwardsRecognition::with('category')->orderBy('id')->get()->groupBy('awards_category_id');
        $banner      = AwardsRecognition::orderBy('id')->first(); // banner lives on the first record

        return view('frontend.awards_recognition', compact('categories', 'awardsByCat', 'banner'));
    }

    // Products landing — lists all active product categories
    public function products_category_listing()
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('priority')
            ->orderBy('name')
            ->get();

        return view('frontend.products', compact('categories'));
    }

    // Products of a single category (slug-bound)
    public function products_category(ProductCategory $category)
    {
        abort_if(! $category->is_active, 404);

        $products = $category->productListings()
            ->where('is_active', true)
            ->orderBy('priority')
            ->orderBy('name')
            ->get();

        return view('frontend.products_category', compact('category', 'products'));
    }

    // Careers page
    public function careers()
    {
        $career = CareerDetail::first();
        $jobs   = CareerJob::where('is_active', true)->orderBy('id')->get();

        return view('frontend.careers', compact('career', 'jobs'));
    }

    // Infrastructure — Design & Engineering page
    public function design_and_engineering()
    {
        $design = DesignEngineering::with('features')->first();

        return view('frontend.design_and_engineering', compact('design'));
    }

    // Infrastructure — Project Management page
    public function project_management()
    {
        $pm = ProjectManagement::with('pointers')->first();

        return view('frontend.project_management', compact('pm'));
    }

    // Infrastructure — Facility page
    public function facility()
    {
        $facility = Facility::with(['features', 'counters', 'galleries', 'strengths'])->first();

        return view('frontend.facility', compact('facility'));
    }

    // Investors Relations — Annual Reports page
    public function annual_report()
    {
        $reports = AnnualReport::where('is_active', true)->orderBy('priority')->orderBy('id')->get();
        $banner  = AnnualReport::orderBy('id')->first(); // banner fields live on the first record

        return view('frontend.annual_report', compact('reports', 'banner'));
    }

    // Investors Relations — Investor Resources page
    public function investor_resources()
    {
        $resource = InvestorResource::first();

        return view('frontend.investor_resources', compact('resource'));
    }

    // Investors Relations — Corporate Governance page
    public function corporate_governance()
    {
        $docs   = GovernanceDocument::where('is_active', true)->orderBy('priority')->orderBy('id')->get();
        $banner = GovernanceDocument::orderBy('id')->first();

        $standalone = $docs->filter(fn ($d) => blank($d->group))->values();
        $groups     = $docs->filter(fn ($d) => filled($d->group))->groupBy('group');

        return view('frontend.corporate_governance', compact('banner', 'standalone', 'groups'));
    }

    // Investors Relations — IPO page (documents + groups + DRHP disclaimer flow)
    public function ipo()
    {
        $docs   = IpoDocument::where('is_active', true)->orderBy('priority')->orderBy('id')->get();
        $banner = IpoDocument::orderBy('id')->first();
        $drhp   = IpoDrhp::first();

        // Standalone documents (no group, and not a group-header row)
        $standalone = $docs->filter(fn ($d) => blank($d->group) && ! $d->is_group_header)->values();

        // Grouped documents -> group -> subgroup -> docs; plus optional group-header PDF link
        $grouped = $docs->filter(fn ($d) => filled($d->group) && ! $d->is_group_header)
            ->groupBy('group')
            ->map(fn ($items) => $items->groupBy(fn ($d) => $d->subgroup ?: ''));

        $headers = $docs->filter(fn ($d) => $d->is_group_header)->keyBy('group');

        return view('frontend.ipo', compact('banner', 'drhp', 'standalone', 'grouped', 'headers'));
    }

    // Legal pages (Privacy Policy / Terms & Conditions) — slug-driven singleton content
    public function legal_page(string $slug)
    {
        $page = LegalPage::where('slug', $slug)->firstOrFail();

        return view('frontend.legal_page', compact('page'));
    }

    // IPO — DRHP disclaimer page 1 ("Continue" -> page 2)
    public function ipo_disclaimer()
    {
        $drhp = IpoDrhp::first();

        return view('frontend.ipo_disclaimer', compact('drhp'));
    }

    // IPO — DRHP disclaimer page 2 ("I Confirm" -> DRHP.pdf)
    public function ipo_disclaimer_confirm()
    {
        $drhp = IpoDrhp::first();

        return view('frontend.ipo_disclaimer_confirm', compact('drhp'));
    }

    // Header search — Project & Product categories and listings (JSON)
    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }

        $like    = '%'.$q.'%';
        $results = [];

        // Project categories
        foreach (ProjectCategory::where('name', 'like', $like)->orderBy('priority')->orderBy('name')->limit(6)->get() as $c) {
            $results[] = [
                'label' => $c->name,
                'type'  => 'Project Category',
                'group' => 'project',
                'url'   => route('frontend.projects', $c->slug),
            ];
        }

        // Project listings
        foreach (ProjectListing::with('category')->where('is_active', true)->where('name', 'like', $like)->orderBy('name')->limit(8)->get() as $p) {
            if (! $p->category) {
                continue;
            }
            $results[] = [
                'label' => $p->name,
                'type'  => 'Project',
                'group' => 'project',
                'url'   => route('frontend.projects_details', [$p->category->slug, $p->slug]),
            ];
        }

        // Product categories
        foreach (ProductCategory::where('is_active', true)->where('name', 'like', $like)->orderBy('priority')->orderBy('name')->limit(6)->get() as $c) {
            $results[] = [
                'label' => $c->name,
                'type'  => 'Product Category',
                'group' => 'product',
                'url'   => route('frontend.products_category', $c->slug),
            ];
        }

        // Product listings (products have no detail page — link to their category page)
        foreach (ProductListing::with('category')->where('is_active', true)->where('name', 'like', $like)->orderBy('name')->limit(8)->get() as $p) {
            if (! $p->category) {
                continue;
            }
            $results[] = [
                'label' => $p->name,
                'type'  => 'Product',
                'group' => 'product',
                'url'   => route('frontend.products_category', $p->category->slug),
            ];
        }

        return response()->json($results);
    }


    // Thankyou page
    public function contact_thank_you()
    {
        return view('frontend.contact_thank_you',);
    }

    public function career_thank_you()
    {
        return view('frontend.career_thank_you',);
    }

}