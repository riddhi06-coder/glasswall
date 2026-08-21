<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AwardsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AwardsCategoryController extends Controller
{
    /** Image upload directory under /public. */
    private const IMG_DIR = 'awards-categories';

    public function index()
    {
        $categories = AwardsCategory::orderBy('name')->get();

        return view('backend.overview.awards.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.overview.awards.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        ], $this->messages());

        AwardsCategory::create([
            'name'       => $validated['name'],
            'slug'       => $this->generateUniqueSlug($validated['name']),
            'image'      => $this->storeImage($request->file('image')),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('manage-awards-category.index')->with('message', 'Award category added successfully.');
    }

    public function edit($id)
    {
        $category = AwardsCategory::findOrFail($id);

        return view('backend.overview.awards.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = AwardsCategory::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ], $this->messages());

        if ($category->name !== $validated['name']) {
            $category->slug = $this->generateUniqueSlug($validated['name'], $category->id);
        }

        $category->name = $validated['name'];

        if ($request->hasFile('image')) {
            $this->deleteImage($category->image);
            $category->image = $this->storeImage($request->file('image'));
        }

        $category->updated_by = Auth::id();
        $category->save();

        return redirect()->route('manage-awards-category.index')->with('message', 'Award category updated successfully.');
    }

    public function destroy($id)
    {
        $category = AwardsCategory::findOrFail($id);
        $this->deleteImage($category->image);
        $category->delete();

        return redirect()->route('manage-awards-category.index')->with('message', 'Award category deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function messages(): array
    {
        return [
            'name.required'  => 'The category name is required.',
            'image.required' => 'The category image is required.',
            'image.mimes'    => 'Image must be jpg, jpeg, png or webp.',
            'image.max'      => 'Image may not be larger than 2 MB.',
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (AwardsCategory::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
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
