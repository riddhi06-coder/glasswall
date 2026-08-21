<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Innovation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InnovationController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'innovation';

    public function index()
    {
        $innovations = Innovation::orderBy('id')->get();

        return view('backend.overview.innovation.index', compact('innovations'));
    }

    public function create()
    {
        $isFirst = Innovation::count() === 0;

        return view('backend.overview.innovation.create', compact('isFirst'));
    }

    public function store(Request $request)
    {
        $isFirst = Innovation::count() === 0;

        $data = $request->validate($this->rules($isFirst), $this->messages());

        $data['image'] = $this->storeImage($request->file('image'));

        if ($isFirst) {
            $data['banner_image'] = $this->storeImage($request->file('banner_image'));
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['created_by'] = Auth::id();
        Innovation::create($data);

        return redirect()->route('manage-innovation.index')->with('message', 'Innovation added successfully.');
    }

    public function edit($id)
    {
        $innovation = Innovation::findOrFail($id);
        $isFirst    = $innovation->id === Innovation::orderBy('id')->value('id');

        return view('backend.overview.innovation.edit', compact('innovation', 'isFirst'));
    }

    public function update(Request $request, $id)
    {
        $innovation = Innovation::findOrFail($id);
        $isFirst    = $innovation->id === Innovation::orderBy('id')->value('id');

        $data = $request->validate($this->rules($isFirst, $innovation->id), $this->messages());

        unset($data['image']);
        if ($request->hasFile('image')) {
            $this->deleteImage($innovation->image);
            $data['image'] = $this->storeImage($request->file('image'));
        }

        if ($isFirst) {
            unset($data['banner_image']);
            if ($request->hasFile('banner_image')) {
                $this->deleteImage($innovation->banner_image);
                $data['banner_image'] = $this->storeImage($request->file('banner_image'));
            }
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['updated_by'] = Auth::id();
        $innovation->update($data);

        return redirect()->route('manage-innovation.index')->with('message', 'Innovation updated successfully.');
    }

    public function destroy($id)
    {
        $innovation = Innovation::findOrFail($id);
        $this->deleteImage($innovation->image);
        $this->deleteImage($innovation->banner_image);
        $innovation->delete();

        return redirect()->route('manage-innovation.index')->with('message', 'Innovation deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(bool $isFirst, ?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        $rules = [
            'heading' => 'required|string|max:255',
            'image'   => "{$req}|file|mimes:jpg,jpeg,png,webp|max:2048",
            'feature' => 'required|string',
        ];

        if ($isFirst) {
            $rules['banner_heading'] = 'required|string|max:255';
            $rules['banner_image']   = "{$req}|file|mimes:jpg,jpeg,png,webp|max:2048";
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'heading.required'        => 'The heading is required.',
            'image.required'          => 'The image is required.',
            'image.max'               => 'Image may not be larger than 2 MB.',
            'feature.required'        => 'The feature is required.',
            'banner_heading.required' => 'The banner heading is required.',
            'banner_image.required'   => 'The banner image is required.',
            'banner_image.max'        => 'Banner image may not be larger than 2 MB.',
        ];
    }

    private function storeImage($file): string
    {
        $folder = public_path(self::DIR);
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

        $path = public_path(self::DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
