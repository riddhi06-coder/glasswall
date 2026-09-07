<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductListController extends Controller
{
    /** Image upload directory under /public. */
    private const IMG_DIR = 'product-listings';

    public function index()
    {
        $categories = ProductCategory::orderBy('priority')->orderBy('name')->get();

        $products = ProductListing::with('category')
            ->orderBy('product_category_id')
            ->orderBy('priority')
            ->orderBy('name')
            ->get();

        return view('backend.products.listing.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();

        return view('backend.products.listing.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name'                => 'required|string|max:255',
            'image'               => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'           => 'required|in:0,1',
            'priority'            => 'nullable|integer|min:0',
        ], $this->messages());

        ProductListing::create([
            'product_category_id' => $validated['product_category_id'],
            'name'                => $validated['name'],
            'slug'                => $this->generateUniqueSlug($validated['name']),
            'image'               => $this->storeImage($request->file('image')),
            'is_active'           => $validated['is_active'],
            'priority'            => $validated['priority'] ?? 0,
            'created_by'          => Auth::id(),
        ]);

        return redirect()->route('manage-product-list.index')->with('message', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product    = ProductListing::findOrFail($id);
        $categories = ProductCategory::orderBy('name')->get();

        return view('backend.products.listing.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = ProductListing::findOrFail($id);

        $validated = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name'                => 'required|string|max:255',
            'image'               => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'           => 'required|in:0,1',
            'priority'            => 'nullable|integer|min:0',
        ], $this->messages());

        if ($product->name !== $validated['name']) {
            $product->slug = $this->generateUniqueSlug($validated['name'], $product->id);
        }

        $product->product_category_id = $validated['product_category_id'];
        $product->name                = $validated['name'];
        $product->is_active           = $validated['is_active'];
        $product->priority            = $validated['priority'] ?? 0;

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $product->image = $this->storeImage($request->file('image'));
        }

        $product->updated_by = Auth::id();
        $product->save();

        return redirect()->route('manage-product-list.index')->with('message', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = ProductListing::findOrFail($id);
        $this->deleteImage($product->image);
        $product->delete();

        return redirect()->route('manage-product-list.index')->with('message', 'Product deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function messages(): array
    {
        return [
            'product_category_id.required' => 'Please select a product category.',
            'product_category_id.exists'   => 'The selected category is invalid.',
            'name.required'                => 'The product name is required.',
            'image.required'               => 'The product image is required.',
            'image.mimes'                  => 'Image must be jpg, jpeg, png or webp.',
            'image.max'                    => 'Image may not be larger than 2 MB.',
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (ProductListing::withTrashed()
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
