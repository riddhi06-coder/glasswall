<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IpoDrhp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpoDrhpController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'ipo-docs';

    public function index()
    {
        $drhps = IpoDrhp::latest()->get();

        return view('backend.investors.ipo_drhp.index', compact('drhps'));
    }

    public function create()
    {
        // Singleton: only one record allowed.
        if ($existing = IpoDrhp::first()) {
            return redirect()->route('manage-ipo-drhp.edit', $existing->id)
                ->with('message', 'DRHP disclaimer already exists. You can edit it here.');
        }

        return view('backend.investors.ipo_drhp.create');
    }

    public function store(Request $request)
    {
        if ($existing = IpoDrhp::first()) {
            return redirect()->route('manage-ipo-drhp.edit', $existing->id);
        }

        $data = $request->validate($this->rules(), $this->messages());

        $data['pdf'] = $this->storeUpload($request->file('pdf'));
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        }
        if ($request->hasFile('banner_image_2')) {
            $data['banner_image_2'] = $this->storeUpload($request->file('banner_image_2'));
        }
        $data['created_by'] = Auth::id();
        IpoDrhp::create($data);

        return redirect()->route('manage-ipo-drhp.index')->with('message', 'DRHP disclaimer added successfully.');
    }

    public function edit($id)
    {
        $drhp = IpoDrhp::findOrFail($id);

        return view('backend.investors.ipo_drhp.edit', compact('drhp'));
    }

    public function update(Request $request, $id)
    {
        $drhp = IpoDrhp::findOrFail($id);

        $data = $request->validate($this->rules($drhp->id), $this->messages());

        unset($data['pdf'], $data['banner_image'], $data['banner_image_2']);
        if ($request->hasFile('pdf')) {
            $this->deleteUpload($drhp->pdf);
            $data['pdf'] = $this->storeUpload($request->file('pdf'));
        }
        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($drhp->banner_image);
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        }
        if ($request->hasFile('banner_image_2')) {
            $this->deleteUpload($drhp->banner_image_2);
            $data['banner_image_2'] = $this->storeUpload($request->file('banner_image_2'));
        }

        $data['updated_by'] = Auth::id();
        $drhp->update($data);

        return redirect()->route('manage-ipo-drhp.index')->with('message', 'DRHP disclaimer updated successfully.');
    }

    public function destroy($id)
    {
        $drhp = IpoDrhp::findOrFail($id);
        $this->deleteUpload($drhp->pdf);
        $this->deleteUpload($drhp->banner_image);
        $this->deleteUpload($drhp->banner_image_2);
        $drhp->delete();

        return redirect()->route('manage-ipo-drhp.index')->with('message', 'DRHP disclaimer deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        return [
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'page1_heading'  => 'required|string|max:255',
            'page1_content' => 'required|string',
            'page2_heading' => 'required|string|max:255',
            'page2_content' => 'required|string',
            'pdf'           => "{$req}|file|mimes:pdf|max:20480",
        ];
    }

    private function messages(): array
    {
        return [
            'banner_image.image' => 'The banner must be an image.',
            'banner_image.mimes' => 'The banner must be a jpg, jpeg, png or webp.',
            'banner_image.max'   => 'The banner image may not be larger than 2 MB.',
            'pdf.required'       => 'The DRHP PDF is required.',
            'pdf.mimes'          => 'The file must be a PDF.',
            'pdf.max'            => 'The PDF may not be larger than 20 MB.',
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
