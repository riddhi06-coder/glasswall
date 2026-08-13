<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeBannerController extends Controller
{
    /** Media upload directory under /public. */
    private const MEDIA_DIR = 'home/bannerimagevideo';

    /** Max upload size per media type, in bytes. */
    private const MAX_IMAGE_BYTES = 2 * 1024 * 1024; // 2 MB
    private const MAX_VIDEO_BYTES = 5 * 1024 * 1024; // 5 MB

    /**
     * Closure rule enforcing a different size limit per media type:
     * images up to 2 MB, videos up to 5 MB.
     */
    private function mediaSizeRule(): callable
    {
        return function (string $attribute, $value, callable $fail) {
            if (! $value) {
                return;
            }

            $isVideo = str_starts_with((string) $value->getMimeType(), 'video');
            $limit   = $isVideo ? self::MAX_VIDEO_BYTES : self::MAX_IMAGE_BYTES;

            if ($value->getSize() > $limit) {
                $fail($isVideo
                    ? 'The video may not be larger than 5 MB.'
                    : 'The image may not be larger than 2 MB.');
            }
        };
    }

    public function index()
    {
        $banners = HomeBanner::latest()->get();

        return view('backend.home.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('backend.home.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banner_heading' => 'required|string|max:5000',
            'banner_title'   => 'required|string|max:255',
            'banner_media'   => ['required', 'file', 'mimes:jpg,jpeg,png,webp,mp4,webm', $this->mediaSizeRule()],
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_title.required'   => 'The banner title is required.',
            'banner_media.required'   => 'Please upload a banner image or video.',
            'banner_media.mimes'      => 'Allowed formats: jpg, jpeg, png, webp, mp4, webm.',
        ]);

        [$fileName, $mediaType] = $this->storeMedia($request->file('banner_media'));

        HomeBanner::create([
            'banner_heading' => $validated['banner_heading'],
            'banner_title'   => $validated['banner_title'],
            'banner_media'   => $fileName,
            'media_type'     => $mediaType,
            'created_by'     => Auth::id(),
        ]);

        return redirect()->route('banner-details.index')->with('message', 'Banner added successfully.');
    }

    public function edit($id)
    {
        $banner = HomeBanner::findOrFail($id);

        return view('backend.home.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = HomeBanner::findOrFail($id);

        $validated = $request->validate([
            'banner_heading' => 'required|string|max:5000',
            'banner_title'   => 'required|string|max:255',
            'banner_media'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,webm', $this->mediaSizeRule()],
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_title.required'   => 'The banner title is required.',
            'banner_media.mimes'      => 'Allowed formats: jpg, jpeg, png, webp, mp4, webm.',
        ]);

        $banner->banner_heading = $validated['banner_heading'];
        $banner->banner_title   = $validated['banner_title'];

        // Replace media only when a new file is uploaded.
        if ($request->hasFile('banner_media')) {
            $this->deleteMedia($banner->banner_media);
            [$fileName, $mediaType] = $this->storeMedia($request->file('banner_media'));
            $banner->banner_media = $fileName;
            $banner->media_type   = $mediaType;
        }

        $banner->updated_by = Auth::id();
        $banner->save();

        return redirect()->route('banner-details.index')->with('message', 'Banner updated successfully.');
    }

    public function destroy($id)
    {
        $banner = HomeBanner::findOrFail($id);
        $banner->delete(); // soft delete; TracksDeletedBy stamps deleted_by

        return redirect()->route('banner-details.index')->with('message', 'Banner deleted successfully.');
    }

    /**
     * Move an uploaded file into the media directory and return
     * [filename, media_type].
     */
    private function storeMedia($file): array
    {
        $mediaType = str_starts_with((string) $file->getMimeType(), 'video') ? 'video' : 'image';

        $folder = public_path(self::MEDIA_DIR);
        if (! file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($folder, $fileName);

        return [$fileName, $mediaType];
    }

    /** Remove a media file from disk if it exists. */
    private function deleteMedia(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path(self::MEDIA_DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
