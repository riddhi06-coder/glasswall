<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityTestingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilityController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'facility-uploads';

    public function index()
    {
        $records = Facility::latest()->get();

        return view('backend.infra.facility.index', compact('records'));
    }

    public function create()
    {
        if ($existing = Facility::first()) {
            return redirect()->route('manage-facility.edit', $existing->id)
                ->with('message', 'Facility details already exist. You can edit them here.');
        }

        return view('backend.infra.facility.create');
    }

    public function store(Request $request)
    {
        if ($existing = Facility::first()) {
            return redirect()->route('manage-facility.edit', $existing->id);
        }

        $data = $request->validate($this->rules(), $this->messages());

        $facility = Facility::create([
            'banner_heading'      => $data['banner_heading'],
            'banner_image'        => $this->storeUpload($request->file('banner_image')),
            'about_heading'       => $data['about_heading'],
            'about_description'   => $data['about_description'],
            'counter_image'       => $request->hasFile('counter_image') ? $this->storeUpload($request->file('counter_image')) : null,
            'process_heading'     => $data['process_heading'],
            'process_description' => $data['process_description'],
            'created_by'          => Auth::id(),
        ]);

        $this->applyTestingSection($facility, $request, $data);
        $this->syncFeatures($facility, $request);
        $this->syncCounters($facility, $request);
        $this->syncGalleries($facility, $request);
        $this->syncStrengths($facility, $request);

        return redirect()->route('manage-facility.index')->with('message', 'Facility details added successfully.');
    }

    public function edit($id)
    {
        $record = Facility::with(['features', 'counters', 'galleries', 'strengths', 'testingImages'])->findOrFail($id);

        return view('backend.infra.facility.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $data = $request->validate($this->rules($facility->id), $this->messages());

        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($facility->banner_image);
            $facility->banner_image = $this->storeUpload($request->file('banner_image'));
        }
        if ($request->hasFile('counter_image')) {
            $this->deleteUpload($facility->counter_image);
            $facility->counter_image = $this->storeUpload($request->file('counter_image'));
        }

        $facility->banner_heading      = $data['banner_heading'];
        $facility->about_heading       = $data['about_heading'];
        $facility->about_description   = $data['about_description'];
        $facility->process_heading     = $data['process_heading'];
        $facility->process_description = $data['process_description'];
        $facility->updated_by          = Auth::id();
        $facility->save();

        $this->applyTestingSection($facility, $request, $data);
        $this->syncFeatures($facility, $request);
        $this->syncCounters($facility, $request);
        $this->syncGalleries($facility, $request);
        $this->syncStrengths($facility, $request);

        return redirect()->route('manage-facility.index')->with('message', 'Facility details updated successfully.');
    }

    public function destroy($id)
    {
        $facility = Facility::with(['features', 'galleries'])->findOrFail($id);
        $this->deleteUpload($facility->banner_image);
        $this->deleteUpload($facility->counter_image);
        foreach (['testing_image1', 'testing_image2', 'testing2_image1', 'testing2_image2', 'nabl_image', 'mockup_image1', 'mockup_image2'] as $img) {
            $this->deleteUpload($facility->$img);
        }
        foreach ($facility->testingImages as $ti) {
            $this->deleteUpload($ti->image);
        }
        $facility->testingImages()->delete();
        foreach ($facility->features as $f) { $this->deleteUpload($f->image); }
        foreach ($facility->galleries as $g) { $this->deleteUpload($g->image); }
        $facility->features()->delete();
        $facility->counters()->delete();
        $facility->galleries()->delete();
        $facility->strengths()->delete();
        $facility->delete();

        return redirect()->route('manage-facility.index')->with('message', 'Facility details deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Façade Testing Facility section (text + 7 images on the parent record)
    // ------------------------------------------------------------------
    private function applyTestingSection(Facility $facility, Request $request, array $data): void
    {
        foreach (['testing_heading', 'testing_content', 'testing2_content', 'nabl_heading', 'precision_heading', 'precision_content', 'mockup_caption'] as $field) {
            $facility->$field = $data[$field] ?? null;
        }

        foreach (['testing_image1', 'testing_image2', 'nabl_image'] as $img) {
            if ($request->hasFile($img)) {
                $this->deleteUpload($facility->$img);
                $facility->$img = $this->storeUpload($request->file($img));
            }
        }

        $facility->save();

        $this->syncTestingBlock2Images($facility, $request);
        $this->syncMockupImages($facility, $request);
    }

    /** Block 5 (Project Mock-ups): repeatable image + per-image caption rows. */
    private function syncMockupImages(Facility $facility, Request $request): void
    {
        $rows = (array) $request->input('mockup', []);

        // Existing ids that survived the submit (rows still present in the form).
        $keptIds = [];
        foreach ($rows as $row) {
            if (! empty($row['id'])) {
                $keptIds[] = (int) $row['id'];
            }
        }

        // Delete mockup rows the admin removed from the table.
        $stale = FacilityTestingImage::where('facility_id', $facility->id)
            ->where('block', 'mockup')
            ->when($keptIds, fn ($q) => $q->whereNotIn('id', $keptIds))
            ->get();
        foreach ($stale as $img) {
            $this->deleteUpload($img->image);
            $img->delete();
        }

        // Create / update rows in submit order.
        $order = 0;
        foreach ($rows as $key => $row) {
            $caption = trim($row['caption'] ?? '');
            $file    = $request->file("mockup.$key.image");

            if (! empty($row['id'])) {
                $img = FacilityTestingImage::where('facility_id', $facility->id)
                    ->where('block', 'mockup')->where('id', $row['id'])->first();
                if (! $img) { continue; }
                if ($file) {
                    $this->deleteUpload($img->image);
                    $img->image = $this->storeUpload($file);
                }
                $img->caption    = $caption;
                $img->sort_order = $order++;
                $img->save();
                continue;
            }

            // New row — needs an uploaded image to be meaningful.
            if ($file) {
                $facility->testingImages()->create([
                    'block'      => 'mockup',
                    'image'      => $this->storeUpload($file),
                    'caption'    => $caption,
                    'sort_order' => $order++,
                ]);
            }
        }
    }

    /** Block 2 (Calibration): remove checked images, add newly-uploaded ones (single multi-file input). */
    private function syncTestingBlock2Images(Facility $facility, Request $request): void
    {
        // Delete the images ticked for removal.
        foreach ((array) $request->input('testing2_delete', []) as $id) {
            $img = FacilityTestingImage::where('facility_id', $facility->id)->where('id', $id)->first();
            if ($img) {
                $this->deleteUpload($img->image);
                $img->delete();
            }
        }

        // Add newly uploaded images.
        $order = (int) FacilityTestingImage::where('facility_id', $facility->id)->where('block', 'calibration')->max('sort_order');
        foreach ((array) $request->file('testing2_images', []) as $file) {
            if ($file) {
                $facility->testingImages()->create([
                    'block'      => 'calibration',
                    'image'      => $this->storeUpload($file),
                    'sort_order' => ++$order,
                ]);
            }
        }
    }

    // ------------------------------------------------------------------
    // Child syncs
    // ------------------------------------------------------------------
    private function syncFeatures(Facility $facility, Request $request): void
    {
        $facility->features()->delete();
        $order = 0;
        foreach ($request->input('features', []) as $i => $row) {
            $title = trim($row['title'] ?? '');
            if ($title === '') { continue; }
            $image = $row['existing_image'] ?? null;
            if ($file = $request->file("features.$i.image")) {
                $image = $this->storeUpload($file);
            }
            $facility->features()->create([
                'image'       => $image,
                'title'       => $title,
                'description' => $row['description'] ?? '',
                'sort_order'  => $order++,
            ]);
        }
    }

    private function syncCounters(Facility $facility, Request $request): void
    {
        $facility->counters()->delete();
        $order = 0;
        foreach ($request->input('counters', []) as $row) {
            $label = trim($row['label'] ?? '');
            $count = trim($row['count'] ?? '');
            if ($label === '' && $count === '') { continue; }
            $facility->counters()->create([
                'count'      => $count,
                'suffix'     => $row['suffix'] ?? null,
                'label'      => $label,
                'sort_order' => $order++,
            ]);
        }
    }

    private function syncGalleries(Facility $facility, Request $request): void
    {
        $facility->galleries()->delete();
        $order = 0;
        foreach ($request->input('galleries', []) as $i => $row) {
            $image = $row['existing_image'] ?? null;
            if ($file = $request->file("galleries.$i.image")) {
                $image = $this->storeUpload($file);
            }
            if (! $image) { continue; }
            $facility->galleries()->create([
                'image'      => $image,
                'heading'    => $row['heading'] ?? null,
                'sort_order' => $order++,
            ]);
        }
    }

    private function syncStrengths(Facility $facility, Request $request): void
    {
        $facility->strengths()->delete();
        $order = 0;
        foreach ($request->input('strengths', []) as $row) {
            $title = trim($row['title'] ?? '');
            if ($title === '') { continue; }
            $facility->strengths()->create([
                'title'       => $title,
                'description' => $row['description'] ?? '',
                'sort_order'  => $order++,
            ]);
        }
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        return [
            'banner_heading'         => 'required|string|max:255',
            'banner_image'           => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'about_heading'          => 'required|string',
            'about_description'      => 'required|string',
            'counter_image'          => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'process_heading'        => 'required|string|max:255',
            'process_description'    => 'required|string',

            // Façade Testing Facility section (all optional)
            'testing_heading'        => 'nullable|string|max:255',
            'testing_content'        => 'nullable|string',
            'testing2_content'       => 'nullable|string',
            'testing2_images'        => 'nullable|array',
            'testing2_images.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'nabl_heading'           => 'nullable|string',
            'precision_heading'      => 'nullable|string|max:255',
            'precision_content'      => 'nullable|string',
            'mockup_caption'         => 'nullable|string|max:500',
            'testing_image1'         => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'testing_image2'         => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'testing2_image1'        => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'testing2_image2'        => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'nabl_image'             => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'mockup'                 => 'nullable|array',
            'mockup.*.caption'       => 'nullable|string|max:255',
            'mockup.*.image'         => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'features'               => 'required|array|min:1',
            'features.*.title'       => 'required|string|max:255',
            'features.*.description' => 'required|string',
            'features.*.image'       => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'counters'               => 'required|array|min:1',
            'counters.*.count'       => 'required|string|max:255',
            'counters.*.suffix'      => 'nullable|string|max:255',
            'counters.*.label'       => 'required|string|max:255',

            'galleries'              => 'nullable|array',
            'galleries.*.image'      => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'galleries.*.heading'    => 'nullable|string|max:255',

            'strengths'              => 'required|array|min:1',
            'strengths.*.title'      => 'required|string|max:255',
            'strengths.*.description' => 'required|string',
        ];
    }

    private function messages(): array
    {
        return [
            'banner_image.required' => 'The banner image is required.',
            '*.mimes'               => 'Images must be jpg, jpeg, png, webp or svg.',
            '*.max'                 => 'Images may not be larger than 2 MB.',
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
