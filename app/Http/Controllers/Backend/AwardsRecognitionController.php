<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AwardsCategory;
use App\Models\AwardsRecognition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AwardsRecognitionController extends Controller
{
    /** Upload directory under /public (not "awards-recognition" — that collides with the /awards-recognition route). */
    private const DIR = 'awards-uploads';

    /** Image file fields (excluding the first-record banner). */
    private const IMAGE_FIELDS = ['thumbnail_image', 'main_image'];

    public function index()
    {
        $awards = AwardsRecognition::with('category')->orderBy('id')->get();

        return view('backend.overview.awards.listing.index', compact('awards'));
    }

    public function create()
    {
        $isFirst    = AwardsRecognition::count() === 0;
        $categories = AwardsCategory::orderBy('name')->get();

        return view('backend.overview.awards.listing.create', compact('isFirst', 'categories'));
    }

    public function store(Request $request)
    {
        $isFirst = AwardsRecognition::count() === 0;

        $data = $request->validate($this->rules($isFirst), $this->messages());

        foreach (self::IMAGE_FIELDS as $field) {
            $data[$field] = $this->storeImage($request->file($field));
        }

        if ($isFirst) {
            $data['banner_image'] = $this->storeImage($request->file('banner_image'));
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['created_by'] = Auth::id();
        AwardsRecognition::create($data);

        return redirect()->route('manage-awards-recognition.index')->with('message', 'Award added successfully.');
    }

    public function edit($id)
    {
        $award      = AwardsRecognition::findOrFail($id);
        $isFirst    = $award->id === AwardsRecognition::orderBy('id')->value('id');
        $categories = AwardsCategory::orderBy('name')->get();

        return view('backend.overview.awards.listing.edit', compact('award', 'isFirst', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $award   = AwardsRecognition::findOrFail($id);
        $isFirst = $award->id === AwardsRecognition::orderBy('id')->value('id');

        $data = $request->validate($this->rules($isFirst, $award->id), $this->messages());

        foreach (self::IMAGE_FIELDS as $field) {
            unset($data[$field]);
            if ($request->hasFile($field)) {
                $this->deleteImage($award->$field);
                $data[$field] = $this->storeImage($request->file($field));
            }
        }

        if ($isFirst) {
            unset($data['banner_image']);
            if ($request->hasFile('banner_image')) {
                $this->deleteImage($award->banner_image);
                $data['banner_image'] = $this->storeImage($request->file('banner_image'));
            }
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['updated_by'] = Auth::id();
        $award->update($data);

        return redirect()->route('manage-awards-recognition.index')->with('message', 'Award updated successfully.');
    }

    public function destroy($id)
    {
        $award = AwardsRecognition::findOrFail($id);
        $this->deleteImage($award->thumbnail_image);
        $this->deleteImage($award->main_image);
        $this->deleteImage($award->banner_image);
        $award->delete();

        return redirect()->route('manage-awards-recognition.index')->with('message', 'Award deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(bool $isFirst, ?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        $rules = [
            'awards_category_id' => 'required|exists:awards_categories,id',
            'title'              => 'required|string|max:255',
            'subject'            => 'required|string|max:255',
            'year'               => 'nullable|string|max:50',
            'thumbnail_image'    => "{$req}|file|mimes:jpg,jpeg,png,webp|max:2048",
            'main_image'         => "{$req}|file|mimes:jpg,jpeg,png,webp|max:2048",
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
            'awards_category_id.required' => 'Please select an award category.',
            'awards_category_id.exists'   => 'The selected category is invalid.',
            'title.required'              => 'The title is required.',
            'subject.required'            => 'The subject is required.',
            'thumbnail_image.required'    => 'The thumbnail image is required.',
            'thumbnail_image.max'         => 'Thumbnail may not be larger than 2 MB.',
            'main_image.required'         => 'The main image is required.',
            'main_image.max'              => 'Main image may not be larger than 2 MB.',
            'banner_heading.required'     => 'The banner heading is required.',
            'banner_image.required'       => 'The banner image is required.',
            'banner_image.max'            => 'Banner image may not be larger than 2 MB.',
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
