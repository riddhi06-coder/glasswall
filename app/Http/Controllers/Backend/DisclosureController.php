<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Disclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisclosureController extends Controller
{
    /** Settings form for the single Disclosures page record. */
    public function index()
    {
        $record = Disclosure::firstOrCreate([], [
            'banner_heading' => 'Disclosures',
            'created_by'     => Auth::id(),
        ]);

        return view('backend.disclosures.settings', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = Disclosure::findOrFail($id);

        $data = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'page_heading'   => 'nullable|string',
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'banner_image.image' => 'The banner must be an image.',
            'banner_image.mimes' => 'The banner must be a jpg, jpeg, png or webp.',
            'banner_image.max'   => 'The banner image may not be larger than 2 MB.',
        ]);

        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($record->banner_image);
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        }

        $data['updated_by'] = Auth::id();
        $record->update($data);

        return redirect()->route('manage-disclosures.index')->with('message', 'Disclosures page settings updated successfully.');
    }

    // ------------------------------------------------------------------
    private function storeUpload($file): string
    {
        $folder = public_path(Disclosure::DIR);
        if (! is_dir($folder)) {
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
        $path = public_path(Disclosure::DIR.'/'.$fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
