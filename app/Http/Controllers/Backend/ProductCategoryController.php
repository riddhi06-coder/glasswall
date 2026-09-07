<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /** Image upload directory under /public. */
    private const IMG_DIR = 'product-categories';

    public function index()
    {
        $categories = ProductCategory::orderBy('priority')->orderBy('name')->get();

        return view('backend.products.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.products.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'image'             => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string|max:1000',
            'is_active'         => 'required|in:0,1',
            'priority'          => 'nullable|integer|min:0',
        ], $this->messages());

        ProductCategory::create([
            'name'              => $validated['name'],
            'slug'              => $this->generateUniqueSlug($validated['name']),
            'image'             => $this->storeImage($request->file('image')),
            'short_description' => $validated['short_description'] ?? null,
            'is_active'         => $validated['is_active'],
            'priority'          => $validated['priority'] ?? 0,
            'created_by'        => Auth::id(),
        ]);

        return redirect()->route('manage-product-category.index')->with('message', 'Product category added successfully.');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);

        return view('backend.products.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'image'             => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string|max:1000',
            'is_active'         => 'required|in:0,1',
            'priority'          => 'nullable|integer|min:0',
        ], $this->messages());

        if ($category->name !== $validated['name']) {
            $category->slug = $this->generateUniqueSlug($validated['name'], $category->id);
        }

        $category->name              = $validated['name'];
        $category->short_description = $validated['short_description'] ?? null;
        $category->is_active         = $validated['is_active'];
        $category->priority          = $validated['priority'] ?? 0;

        if ($request->hasFile('image')) {
            $this->deleteImage($category->image);
            $category->image = $this->storeImage($request->file('image'));
        }

        $category->updated_by = Auth::id();
        $category->save();

        return redirect()->route('manage-product-category.index')->with('message', 'Product category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $this->deleteImage($category->image);
        $category->delete();

        return redirect()->route('manage-product-category.index')->with('message', 'Product category deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function messages(): array
    {
        return [
            'name.required'  => 'The category name is required.',
            'image.required' => 'The thumbnail image is required.',
            'image.mimes'    => 'Image must be jpg, jpeg, png or webp.',
            'image.max'      => 'Image may not be larger than 2 MB.',
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (ProductCategory::withTrashed()
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
