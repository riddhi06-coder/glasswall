<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InvestorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorResourceController extends Controller
{
    /** Upload directory under /public (clear of any /investor-resources route). */
    private const DIR = 'investor-uploads';

    public function index()
    {
        $resources = InvestorResource::latest()->get();

        return view('backend.investors.investor_resource.index', compact('resources'));
    }

    public function create()
    {
        // Singleton: only one record allowed.
        if ($existing = InvestorResource::first()) {
            return redirect()->route('manage-investor-resource.edit', $existing->id)
                ->with('message', 'Investor resource already exists. You can edit it here.');
        }

        return view('backend.investors.investor_resource.create');
    }

    public function store(Request $request)
    {
        if ($existing = InvestorResource::first()) {
            return redirect()->route('manage-investor-resource.edit', $existing->id);
        }

        $data = $request->validate($this->rules(), $this->messages());

        $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        $data['created_by']   = Auth::id();
        InvestorResource::create($data);

        return redirect()->route('manage-investor-resource.index')->with('message', 'Investor resource added successfully.');
    }

    public function edit($id)
    {
        $resource = InvestorResource::findOrFail($id);

        return view('backend.investors.investor_resource.edit', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $resource = InvestorResource::findOrFail($id);

        $data = $request->validate($this->rules($resource->id), $this->messages());

        unset($data['banner_image']);
        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($resource->banner_image);
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        }

        $data['updated_by'] = Auth::id();
        $resource->update($data);

        return redirect()->route('manage-investor-resource.index')->with('message', 'Investor resource updated successfully.');
    }

    public function destroy($id)
    {
        $resource = InvestorResource::findOrFail($id);
        $this->deleteUpload($resource->banner_image);
        $resource->delete();

        return redirect()->route('manage-investor-resource.index')->with('message', 'Investor resource deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        return [
            'banner_heading' => 'required|string|max:255',
            'banner_image'   => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'name'           => 'required|string|max:255',
            'designation'    => 'required|string|max:255',
            'phone'          => 'required|string|max:50',
            'email'          => 'required|email|max:255',
            'company_name'   => 'required|string|max:255',
            'address'        => 'required|string|max:1000',
        ];
    }

    private function messages(): array
    {
        return [
            'banner_image.required' => 'The banner image is required.',
            'banner_image.mimes'    => 'Banner image must be jpg, jpeg, png, webp or svg.',
            'banner_image.max'      => 'Banner image may not be larger than 2 MB.',
            'email.email'           => 'Enter a valid email address.',
        ];
    }

    private function storeUpload($file): string
    {
        $folder = public_path(self::DIR);
        if (! file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($folder, $fileName);

        return $fileName;
    }

    private function deleteUpload(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path(self::DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
