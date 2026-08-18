<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectDetailsController extends Controller
{
    /** Image upload directory under /public. */
    private const IMG_DIR = 'project/details';

    public function index()
    {
        $details = ProjectDetail::with('listing.category')
            ->get()
            ->sortBy([
                fn ($a, $b) => strcmp(
                    optional(optional($a->listing)->category)->name ?? '',
                    optional(optional($b->listing)->category)->name ?? ''
                ),
            ])
            ->values();

        return view('backend.project.details.index', compact('details'));
    }

    public function create()
    {
        $categories = ProjectCategory::orderBy('priority')->orderBy('name')->get();

        return view('backend.project.details.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        ProjectDetail::create([
            'project_listing_id' => $validated['project_listing_id'],
            'banner_image'       => $this->storeImage($request->file('banner_image')),
            'image'              => $this->storeImage($request->file('image')),
            'client'             => $validated['client'],
            'architect'          => $validated['architect'],
            'consultant'         => $validated['consultant'],
            'project_area'       => $validated['project_area'],
            'floors'             => $validated['floors'],
            'scope_of_work'      => array_values(array_filter($validated['scope_of_work'])),
            'created_by'         => Auth::id(),
        ]);

        return redirect()->route('manage-project-details.index')->with('message', 'Project details added successfully.');
    }

    public function edit($id)
    {
        $detail     = ProjectDetail::with('listing.category')->findOrFail($id);
        $categories = ProjectCategory::orderBy('priority')->orderBy('name')->get();
        $listings   = ProjectListing::where('project_category_id', optional($detail->listing)->project_category_id)
            ->orderBy('name')->get();

        return view('backend.project.details.edit', compact('detail', 'categories', 'listings'));
    }

    public function update(Request $request, $id)
    {
        $detail = ProjectDetail::findOrFail($id);

        $validated = $request->validate($this->rules($detail->id), $this->messages());

        if ($request->hasFile('banner_image')) {
            $this->deleteImage($detail->banner_image);
            $detail->banner_image = $this->storeImage($request->file('banner_image'));
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($detail->image);
            $detail->image = $this->storeImage($request->file('image'));
        }

        $detail->project_listing_id = $validated['project_listing_id'];
        $detail->client             = $validated['client'];
        $detail->architect          = $validated['architect'];
        $detail->consultant         = $validated['consultant'];
        $detail->project_area       = $validated['project_area'];
        $detail->floors             = $validated['floors'];
        $detail->scope_of_work      = array_values(array_filter($validated['scope_of_work']));
        $detail->updated_by         = Auth::id();
        $detail->save();

        return redirect()->route('manage-project-details.index')->with('message', 'Project details updated successfully.');
    }

    public function destroy($id)
    {
        $detail = ProjectDetail::findOrFail($id);
        $this->deleteImage($detail->banner_image);
        $this->deleteImage($detail->image);
        $detail->delete();

        return redirect()->route('manage-project-details.index')->with('message', 'Project details deleted successfully.');
    }

    /** AJAX: return the active project listings for a given category. */
    public function listingsByCategory($category)
    {
        $listings = ProjectListing::where('project_category_id', $category)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($listings);
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        return [
            'project_category_id' => 'required|exists:project_categories,id',
            'project_listing_id'  => [
                'required',
                'exists:project_listings,id',
                Rule::unique('project_details', 'project_listing_id')
                    ->ignore($ignoreId)
                    ->whereNull('deleted_at'),
            ],
            'banner_image'    => ($ignoreId ? 'nullable' : 'required').'|file|mimes:jpg,jpeg,png,webp|max:2048',
            'image'           => ($ignoreId ? 'nullable' : 'required').'|file|mimes:jpg,jpeg,png,webp|max:2048',
            'client'          => 'required|string|max:255',
            'architect'       => 'required|string|max:255',
            'consultant'      => 'required|string|max:255',
            'project_area'    => 'required|string|max:255',
            'floors'          => 'required|string|max:255',
            'scope_of_work'   => 'required|array|min:1',
            'scope_of_work.*' => 'required|string|max:255',
        ];
    }

    private function messages(): array
    {
        return [
            'project_category_id.required' => 'Please select a category.',
            'project_listing_id.required'  => 'Please select a project.',
            'project_listing_id.unique'    => 'Details for this project already exist.',
            'banner_image.required'        => 'The banner image is required.',
            'banner_image.max'             => 'Banner image may not be larger than 2 MB.',
            'image.required'               => 'The image is required.',
            'image.max'                    => 'Image may not be larger than 2 MB.',
            'client.required'              => 'The client is required.',
            'architect.required'           => 'The architect is required.',
            'consultant.required'          => 'The consultant is required.',
            'project_area.required'        => 'The project area is required.',
            'floors.required'              => 'The number of floors is required.',
            'scope_of_work.required'       => 'Add at least one scope of work.',
            'scope_of_work.*.required'     => 'Scope of work rows cannot be empty.',
        ];
    }

    private function storeImage($file): string
    {
        $folder = public_path(self::IMG_DIR);
        if (! file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($folder, $fileName);

        return $fileName;
    }

    private function deleteImage(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path(self::IMG_DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
