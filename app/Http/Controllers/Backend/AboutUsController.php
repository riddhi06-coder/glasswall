<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutUsController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'about';

    /** Image file fields (jpg/png/webp/svg, max 2 MB). */
    private const IMAGE_FIELDS = [
        'section_image', 'vision_logo', 'vision_image',
        'mission_logo', 'mission_image', 'core_image',
    ];

    /** Video file field (max 20 MB). */
    private const VIDEO_FIELD = 'banner_video';

    public function index()
    {
        $abouts = AboutUs::latest()->get();

        return view('backend.overview.about_us.index', compact('abouts'));
    }

    public function create()
    {
        return view('backend.overview.about_us.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        foreach ($this->fileFields() as $field) {
            $data[$field] = $this->storeUpload($request->file($field));
        }

        $data['created_by'] = Auth::id();
        AboutUs::create($data);

        return redirect()->route('manage-about-us.index')->with('message', 'About Us added successfully.');
    }

    public function edit($id)
    {
        $about = AboutUs::findOrFail($id);

        return view('backend.overview.about_us.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = AboutUs::findOrFail($id);

        $data = $request->validate($this->rules($about->id), $this->messages());

        // Files are handled explicitly — keep existing when none uploaded.
        foreach ($this->fileFields() as $field) {
            unset($data[$field]);
            if ($request->hasFile($field)) {
                $this->deleteUpload($about->$field);
                $data[$field] = $this->storeUpload($request->file($field));
            }
        }

        $data['updated_by'] = Auth::id();
        $about->update($data);

        return redirect()->route('manage-about-us.index')->with('message', 'About Us updated successfully.');
    }

    public function destroy($id)
    {
        $about = AboutUs::findOrFail($id);

        foreach ($this->fileFields() as $field) {
            $this->deleteUpload($about->$field);
        }
        $about->delete();

        return redirect()->route('manage-about-us.index')->with('message', 'About Us deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function fileFields(): array
    {
        return array_merge(self::IMAGE_FIELDS, [self::VIDEO_FIELD]);
    }

    private function rules(?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        $rules = [
            // Banner / top section
            'banner_heading'  => 'required|string|max:255',
            'banner_video'    => "{$req}|file|mimes:mp4,webm,ogg,mov|max:30720",
            'section_heading' => 'required|string|max:255',
            'section_image'   => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'description'     => 'required|string',

            // Vision section wrapper
            'vision_section_heading'     => 'required|string|max:255',
            'vision_section_description' => 'required|string',

            // Vision block
            'vision_logo'    => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'vision_heading' => 'required|string|max:255',
            'vision_title'   => 'required|string|max:255',
            'vision_desc'    => 'required|string',
            'vision_image'   => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",

            // Mission block
            'mission_logo'    => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'mission_heading' => 'required|string|max:255',
            'mission_title'   => 'required|string|max:255',
            'mission_desc'    => 'required|string',
            'mission_image'   => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",

            // Core values section
            'core_title'       => 'required|string|max:255',
            'core_description' => 'required|string',
            'core_image'       => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
        ];

        return $rules;
    }

    private function messages(): array
    {
        return [
            'banner_video.mimes' => 'Banner video must be mp4, webm, ogg or mov.',
            'banner_video.max'   => 'Banner video may not be larger than 30 MB.',
            '*.image.mimes'      => 'Images must be jpg, jpeg, png, webp or svg.',
            '*.max'              => 'Images may not be larger than 2 MB.',
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
