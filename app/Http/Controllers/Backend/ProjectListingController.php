<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use App\Models\ProjectListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $validated = $request->validate(
            $this->rules($request, 'required|file|mimes:jpg,jpeg,png,webp|max:2048'),
            $this->messages()
        );

        $showOnHome = (bool) $validated['show_on_home'];

        ProjectListing::create([
            'project_category_id' => $validated['project_category_id'],
            'name'                => $validated['name'],
            'slug'                => $this->generateUniqueSlug($validated['name']),
            'thumbnail'           => $this->storeThumbnail($request->file('thumbnail')),
            'location'            => $validated['location'],
            'is_active'           => $validated['is_active'],
            'priority'            => $validated['priority'],
            'show_on_home'        => $showOnHome,
            'home_priority'       => $showOnHome ? $validated['home_priority'] : null,
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

        $validated = $request->validate(
            $this->rules($request, 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048', $listing->id),
            $this->messages()
        );

        if ($listing->name !== $validated['name']) {
            $listing->slug = $this->generateUniqueSlug($validated['name'], $listing->id);
        }

        $showOnHome = (bool) $validated['show_on_home'];

        $listing->project_category_id = $validated['project_category_id'];
        $listing->name                = $validated['name'];
        $listing->location            = $validated['location'];
        $listing->is_active           = $validated['is_active'];
        $listing->priority            = $validated['priority'];
        $listing->show_on_home        = $showOnHome;
        $listing->home_priority       = $showOnHome ? $validated['home_priority'] : null;

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

    /**
     * AJAX toggle: show this project's image on the home page or not.
     * Switching on assigns the next free home priority within the category; switching off clears it.
     */
    public function toggleHome($id)
    {
        $listing = ProjectListing::findOrFail($id);
        $listing->show_on_home  = ! $listing->show_on_home;
        $listing->home_priority = $listing->show_on_home
            ? $this->nextHomePriority($listing->project_category_id)
            : null;
        $listing->updated_by    = Auth::id();
        $listing->save();

        return response()->json([
            'success'       => true,
            'show_on_home'  => $listing->show_on_home,
            'home_priority' => $listing->home_priority,
        ]);
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(Request $request, string $thumbnailRule, ?int $ignoreId = null): array
    {
        $categoryId = $request->input('project_category_id');

        return [
            'project_category_id' => 'required|exists:project_categories,id',
            'name'                => 'required|string|max:255',
            'thumbnail'           => $thumbnailRule,
            'location'            => 'required|string|max:255',
            'is_active'           => 'required|boolean',
            'priority'            => [
                'required', 'integer', 'min:0',
                Rule::unique('project_listings', 'priority')
                    ->where('project_category_id', $categoryId)
                    ->whereNull('deleted_at')
                    ->ignore($ignoreId),
            ],
            'show_on_home'        => 'required|boolean',
            'home_priority'       => [
                'nullable', 'required_if:show_on_home,1', 'integer', 'min:1',
                Rule::unique('project_listings', 'home_priority')
                    ->where('project_category_id', $categoryId)
                    ->where('show_on_home', true)
                    ->whereNull('deleted_at')
                    ->ignore($ignoreId),
            ],
        ];
    }

    private function nextHomePriority(int $categoryId): int
    {
        return (int) ProjectListing::where('project_category_id', $categoryId)
            ->where('show_on_home', true)
            ->max('home_priority') + 1;
    }

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
            'priority.unique'              => 'This priority is already used by another project in the selected category.',
            'home_priority.required_if'    => 'The home priority is required when the project is shown on the home page.',
            'home_priority.integer'        => 'The home priority must be a number.',
            'home_priority.min'            => 'The home priority must be at least 1.',
            'home_priority.unique'         => 'This home priority is already used by another home-page project in the selected category.',
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
