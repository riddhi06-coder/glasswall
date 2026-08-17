<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use App\Models\ProjectListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectListingController extends Controller
{
    /** Thumbnail upload directory under /public. */
    private const THUMB_DIR = 'project/listings';

    public function index()
    {
        $listings = ProjectListing::with('category')
            ->orderBy('project_category_id')
            ->orderBy('priority')
            ->orderBy('id')
            ->get();

        $categories = ProjectCategory::orderBy('name')->get();

        return view('backend.project.listing.index', compact('listings', 'categories'));
    }

    public function create()
    {
        $categories = ProjectCategory::orderBy('priority')->orderBy('name')->get();

        return view('backend.project.listing.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_category_id' => 'required|exists:project_categories,id',
            'name'                => 'required|string|max:255',
            'thumbnail'           => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'location'            => 'required|string|max:255',
            'is_active'           => 'required|boolean',
            'priority'            => 'required|integer|min:0',
        ], $this->messages());

        ProjectListing::create([
            'project_category_id' => $validated['project_category_id'],
            'name'                => $validated['name'],
            'slug'                => $this->generateUniqueSlug($validated['name']),
            'thumbnail'           => $this->storeThumbnail($request->file('thumbnail')),
            'location'            => $validated['location'],
            'is_active'           => $validated['is_active'],
            'priority'            => $validated['priority'],
            'created_by'          => Auth::id(),
        ]);

        return redirect()->route('manage-project-listing.index')->with('message', 'Project added successfully.');
    }

    public function edit($id)
    {
        $listing    = ProjectListing::findOrFail($id);
        $categories = ProjectCategory::orderBy('priority')->orderBy('name')->get();

        return view('backend.project.listing.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $listing = ProjectListing::findOrFail($id);

        $validated = $request->validate([
            'project_category_id' => 'required|exists:project_categories,id',
            'name'                => 'required|string|max:255',
            'thumbnail'           => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'location'            => 'required|string|max:255',
            'is_active'           => 'required|boolean',
            'priority'            => 'required|integer|min:0',
        ], $this->messages());

        if ($listing->name !== $validated['name']) {
            $listing->slug = $this->generateUniqueSlug($validated['name'], $listing->id);
        }

        $listing->project_category_id = $validated['project_category_id'];
        $listing->name                = $validated['name'];
        $listing->location            = $validated['location'];
        $listing->is_active           = $validated['is_active'];
        $listing->priority            = $validated['priority'];

        if ($request->hasFile('thumbnail')) {
            $this->deleteThumbnail($listing->thumbnail);
            $listing->thumbnail = $this->storeThumbnail($request->file('thumbnail'));
        }

        $listing->updated_by = Auth::id();
        $listing->save();

        return redirect()->route('manage-project-listing.index')->with('message', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $listing = ProjectListing::findOrFail($id);
        $this->deleteThumbnail($listing->thumbnail);
        $listing->delete();

        return redirect()->route('manage-project-listing.index')->with('message', 'Project deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function messages(): array
    {
        return [
            'project_category_id.required' => 'Please select a category.',
            'project_category_id.exists'   => 'The selected category is invalid.',
            'name.required'                => 'The project name is required.',
            'thumbnail.required'           => 'The thumbnail image is required.',
            'thumbnail.mimes'              => 'Thumbnail must be jpg, jpeg, png or webp.',
            'thumbnail.max'                => 'Thumbnail may not be larger than 2 MB.',
            'location.required'            => 'The location is required.',
            'is_active.required'           => 'Please select a status.',
            'priority.required'            => 'The priority is required.',
            'priority.integer'             => 'The priority must be a number.',
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (ProjectListing::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }

    private function storeThumbnail($file): string
    {
        $folder = public_path(self::THUMB_DIR);
        if (! file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($folder, $fileName);

        return $fileName;
    }

    private function deleteThumbnail(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path(self::THUMB_DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
