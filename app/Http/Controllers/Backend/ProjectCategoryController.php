<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectCategoryController extends Controller
{
    /** Thumbnail upload directory under /public. */
    private const THUMB_DIR = 'project/categories';

    public function index()
    {
        $categories = ProjectCategory::orderBy('priority')->orderBy('id')->get();

        return view('backend.project.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.project.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'priority'  => 'required|integer|min:0',
        ], $this->messages());

        ProjectCategory::create([
            'name'       => $validated['name'],
            'slug'       => $this->generateUniqueSlug($validated['name']),
            'thumbnail'  => $this->storeThumbnail($request->file('thumbnail')),
            'priority'   => $validated['priority'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('manage-project-category.index')->with('message', 'Category added successfully.');
    }

    public function edit($id)
    {
        $category = ProjectCategory::findOrFail($id);

        return view('backend.project.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = ProjectCategory::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'priority'  => 'required|integer|min:0',
        ], $this->messages());

        // Keep the slug in sync with the (possibly renamed) category.
        if ($category->name !== $validated['name']) {
            $category->slug = $this->generateUniqueSlug($validated['name'], $category->id);
        }

        $category->name     = $validated['name'];
        $category->priority = $validated['priority'];

        if ($request->hasFile('thumbnail')) {
            $this->deleteThumbnail($category->thumbnail);
            $category->thumbnail = $this->storeThumbnail($request->file('thumbnail'));
        }

        $category->updated_by = Auth::id();
        $category->save();

        return redirect()->route('manage-project-category.index')->with('message', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ProjectCategory::findOrFail($id);
        $this->deleteThumbnail($category->thumbnail);
        $category->delete();

        return redirect()->route('manage-project-category.index')->with('message', 'Category deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function messages(): array
    {
        return [
            'name.required'      => 'The category name is required.',
            'thumbnail.required' => 'The thumbnail image is required.',
            'thumbnail.mimes'    => 'Thumbnail must be jpg, jpeg, png or webp.',
            'thumbnail.max'      => 'Thumbnail may not be larger than 2 MB.',
            'priority.required'  => 'The priority is required.',
            'priority.integer'   => 'The priority must be a number.',
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (ProjectCategory::withTrashed()
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
