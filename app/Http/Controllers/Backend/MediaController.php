<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    /** Upload directory under /public (not "media" — keeps clear of any /media route). */
    private const DIR = 'media-uploads';

    public function index()
    {
        $media = Media::orderBy('id')->get();

        return view('backend.overview.media.index', compact('media'));
    }

    public function create()
    {
        $isFirst = Media::count() === 0;

        return view('backend.overview.media.create', compact('isFirst'));
    }

    public function store(Request $request)
    {
        $isFirst = Media::count() === 0;

        $data = $request->validate($this->rules($isFirst), $this->messages());

        $data['video'] = $this->storeUpload($request->file('video'));

        if ($isFirst) {
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['created_by'] = Auth::id();
        Media::create($data);

        return redirect()->route('manage-media.index')->with('message', 'Media added successfully.');
    }

    public function edit($id)
    {
        $media   = Media::findOrFail($id);
        $isFirst = $media->id === Media::orderBy('id')->value('id');

        return view('backend.overview.media.edit', compact('media', 'isFirst'));
    }

    public function update(Request $request, $id)
    {
        $media   = Media::findOrFail($id);
        $isFirst = $media->id === Media::orderBy('id')->value('id');

        $data = $request->validate($this->rules($isFirst, $media->id), $this->messages());

        unset($data['video']);
        if ($request->hasFile('video')) {
            $this->deleteUpload($media->video);
            $data['video'] = $this->storeUpload($request->file('video'));
        }

        if ($isFirst) {
            unset($data['banner_image']);
            if ($request->hasFile('banner_image')) {
                $this->deleteUpload($media->banner_image);
                $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
            }
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['updated_by'] = Auth::id();
        $media->update($data);

        return redirect()->route('manage-media.index')->with('message', 'Media updated successfully.');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $this->deleteUpload($media->video);
        $this->deleteUpload($media->banner_image);
        $media->delete();

        return redirect()->route('manage-media.index')->with('message', 'Media deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(bool $isFirst, ?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        $rules = [
            'video' => "{$req}|file|mimes:mp4,webm,ogg,mov|max:30720",
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
            'video.required'          => 'The video is required.',
            'video.mimes'             => 'Video must be mp4, webm, ogg or mov.',
            'video.max'               => 'Video may not be larger than 30 MB.',
            'banner_heading.required' => 'The banner heading is required.',
            'banner_image.required'   => 'The banner image is required.',
            'banner_image.max'        => 'Banner image may not be larger than 2 MB.',
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
