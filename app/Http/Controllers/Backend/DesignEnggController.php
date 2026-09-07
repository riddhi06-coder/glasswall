<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DesignEngineering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignEnggController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'design-engg';

    public function index()
    {
        $records = DesignEngineering::latest()->get();

        return view('backend.infra.design_engg.index', compact('records'));
    }

    public function create()
    {
        // Singleton: only one record allowed.
        if ($existing = DesignEngineering::first()) {
            return redirect()->route('manage-design-engg.edit', $existing->id)
                ->with('message', 'Design & Engineering details already exist. You can edit them here.');
        }

        return view('backend.infra.design_engg.create');
    }

    public function store(Request $request)
    {
        if ($existing = DesignEngineering::first()) {
            return redirect()->route('manage-design-engg.edit', $existing->id);
        }

        $data = $request->validate($this->rules(), $this->messages());

        $record = DesignEngineering::create([
            'banner_heading'   => $data['banner_heading'],
            'banner_image'     => $this->storeUpload($request->file('banner_image')),
            'section_heading'  => $data['section_heading'],
            'description'      => $data['description'],
            'features_heading' => $data['features_heading'],
            'features_image'   => $this->storeUpload($request->file('features_image')),
            'created_by'       => Auth::id(),
        ]);

        $this->syncFeatures($record, $data['features']);

        return redirect()->route('manage-design-engg.index')->with('message', 'Design & Engineering details added successfully.');
    }

    public function edit($id)
    {
        $record = DesignEngineering::with('features')->findOrFail($id);

        return view('backend.infra.design_engg.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = DesignEngineering::findOrFail($id);

        $data = $request->validate($this->rules($record->id), $this->messages());

        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($record->banner_image);
            $record->banner_image = $this->storeUpload($request->file('banner_image'));
        }

        if ($request->hasFile('features_image')) {
            $this->deleteUpload($record->features_image);
            $record->features_image = $this->storeUpload($request->file('features_image'));
        }

        $record->banner_heading   = $data['banner_heading'];
        $record->section_heading  = $data['section_heading'];
        $record->description      = $data['description'];
        $record->features_heading = $data['features_heading'];
        $record->updated_by       = Auth::id();
        $record->save();

        $this->syncFeatures($record, $data['features']);

        return redirect()->route('manage-design-engg.index')->with('message', 'Design & Engineering details updated successfully.');
    }

    public function destroy($id)
    {
        $record = DesignEngineering::findOrFail($id);
        $this->deleteUpload($record->banner_image);
        $this->deleteUpload($record->features_image);
        $record->features()->delete();
        $record->delete();

        return redirect()->route('manage-design-engg.index')->with('message', 'Design & Engineering details deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        return [
            'banner_heading'          => 'required|string|max:255',
            'banner_image'            => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'section_heading'         => 'required|string|max:255',
            'description'             => 'required|string',
            'features_heading'        => 'required|string|max:255',
            'features_image'          => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'features'                => 'required|array|min:1',
            'features.*.feature'      => 'required|string|max:255',
            'features.*.description'  => 'required|string',
        ];
    }

    private function messages(): array
    {
        return [
            'banner_image.required'         => 'The banner image is required.',
            'banner_image.mimes'            => 'Banner image must be jpg, jpeg, png, webp or svg.',
            'banner_image.max'              => 'Banner image may not be larger than 2 MB.',
            'features.required'             => 'Add at least one feature.',
            'features.*.feature.required'   => 'Feature name is required.',
            'features.*.description.required' => 'Feature description is required.',
        ];
    }

    private function syncFeatures(DesignEngineering $record, array $features): void
    {
        $record->features()->delete();

        $order = 0;
        foreach ($features as $row) {
            $feature = trim($row['feature'] ?? '');
            $desc    = $row['description'] ?? '';
            if ($feature === '') {
                continue;
            }
            $record->features()->create([
                'feature'     => $feature,
                'description' => $desc,
                'sort_order'  => $order++,
            ]);
        }
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
