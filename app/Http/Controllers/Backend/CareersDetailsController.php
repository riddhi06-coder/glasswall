<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CareerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareersDetailsController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'careers-uploads';

    /** Image file fields (jpg/png/webp/svg, max 2 MB). */
    private const IMAGE_FIELDS = ['banner_image', 'section_image'];

    public function index()
    {
        $careers = CareerDetail::latest()->get();

        return view('backend.career.page_details.index', compact('careers'));
    }

    public function create()
    {
        // Singleton: only one record allowed.
        if ($existing = CareerDetail::first()) {
            return redirect()->route('manage-careers-details.edit', $existing->id)
                ->with('message', 'Career page details already exist. You can edit them here.');
        }

        return view('backend.career.page_details.create');
    }

    public function store(Request $request)
    {
        if ($existing = CareerDetail::first()) {
            return redirect()->route('manage-careers-details.edit', $existing->id);
        }

        $data = $request->validate($this->rules(), $this->messages());

        foreach (self::IMAGE_FIELDS as $field) {
            $data[$field] = $this->storeUpload($request->file($field));
        }

        $data['created_by'] = Auth::id();
        CareerDetail::create($data);

        return redirect()->route('manage-careers-details.index')->with('message', 'Career page details added successfully.');
    }

    public function edit($id)
    {
        $career = CareerDetail::findOrFail($id);

        return view('backend.career.page_details.edit', compact('career'));
    }

    public function update(Request $request, $id)
    {
        $career = CareerDetail::findOrFail($id);

        $data = $request->validate($this->rules($career->id), $this->messages());

        // Files handled explicitly — keep existing when none uploaded.
        foreach (self::IMAGE_FIELDS as $field) {
            unset($data[$field]);
            if ($request->hasFile($field)) {
                $this->deleteUpload($career->$field);
                $data[$field] = $this->storeUpload($request->file($field));
            }
        }

        $data['updated_by'] = Auth::id();
        $career->update($data);

        return redirect()->route('manage-careers-details.index')->with('message', 'Career page details updated successfully.');
    }

    public function destroy($id)
    {
        $career = CareerDetail::findOrFail($id);

        foreach (self::IMAGE_FIELDS as $field) {
            $this->deleteUpload($career->$field);
        }
        $career->delete();

        return redirect()->route('manage-careers-details.index')->with('message', 'Career page details deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        return [
            'banner_heading'      => 'required|string|max:255',
            'banner_image'        => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'section_heading'     => 'required|string|max:255',
            'section_image'       => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'description'         => 'required|string',
            'job_section_heading' => 'required|string|max:255',
        ];
    }

    private function messages(): array
    {
        return [
            'banner_image.required'  => 'The banner image is required.',
            'section_image.required' => 'The section image is required.',
            '*.mimes'                => 'Images must be jpg, jpeg, png, webp or svg.',
            '*.max'                  => 'Images may not be larger than 2 MB.',
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
