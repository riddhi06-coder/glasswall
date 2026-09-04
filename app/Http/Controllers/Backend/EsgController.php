<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Esg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EsgController extends Controller
{
    /** Upload directory under /public (not "esg" — keeps clear of any /esg route). */
    private const DIR = 'esg-uploads';

    /** Singleton image fields on the main record. */
    private const SINGLE_IMAGES = [
        'banner_image', 'director_image', 'innovation_bg_image',
        'dev_image', 'driving_bg_image', 'stakeholder_image',
    ];

    /** Repeatable child tables: input key => [relation, text fields]. */
    private const CHILD_TABLES = [
        'innovation_features' => ['relation' => 'innovationFeatures', 'text' => ['feature', 'description']],
        'driving_counts'      => ['relation' => 'drivingCounts',      'text' => ['count', 'feature']],
        'impacts'             => ['relation' => 'impacts',            'text' => ['year', 'impact', 'description']],
        'waste_features'      => ['relation' => 'wasteFeatures',      'text' => ['feature', 'description']],
    ];

    public function index()
    {
        $esgs = Esg::latest()->get();

        return view('backend.overview.esg.index', compact('esgs'));
    }

    public function create()
    {
        // Only one ESG record is allowed.
        if ($existing = Esg::first()) {
            return redirect()->route('manage-esg.edit', $existing->id)
                ->with('message', 'An ESG page already exists — edit the existing one.');
        }

        return view('backend.overview.esg.create');
    }

    public function store(Request $request)
    {
        // Guard against a second record (only one ESG record is allowed).
        if ($existing = Esg::first()) {
            return redirect()->route('manage-esg.edit', $existing->id)
                ->with('message', 'An ESG page already exists — edit the existing one.');
        }

        $data = $request->validate($this->rules(), $this->messages());

        foreach (self::SINGLE_IMAGES as $field) {
            $data[$field] = $this->storeImage($request->file($field));
        }

        $data = $this->onlyMainFields($data);
        $data['created_by'] = Auth::id();
        $esg = Esg::create($data);

        foreach (self::CHILD_TABLES as $key => $cfg) {
            $this->syncChildRows($esg, $cfg['relation'], $request, $key, $cfg['text']);
        }

        return redirect()->route('manage-esg.index')->with('message', 'ESG page added successfully.');
    }

    public function edit($id)
    {
        $esg = Esg::with(['innovationFeatures', 'drivingCounts', 'impacts', 'wasteFeatures'])->findOrFail($id);

        return view('backend.overview.esg.edit', compact('esg'));
    }

    public function update(Request $request, $id)
    {
        $esg = Esg::findOrFail($id);

        $data = $request->validate($this->rules($esg->id), $this->messages());

        foreach (self::SINGLE_IMAGES as $field) {
            unset($data[$field]);
            if ($request->hasFile($field)) {
                $this->deleteImage($esg->$field);
                $data[$field] = $this->storeImage($request->file($field));
            }
        }

        $data = $this->onlyMainFields($data);
        $data['updated_by'] = Auth::id();
        $esg->update($data);

        foreach (self::CHILD_TABLES as $key => $cfg) {
            $this->syncChildRows($esg, $cfg['relation'], $request, $key, $cfg['text']);
        }

        return redirect()->route('manage-esg.index')->with('message', 'ESG page updated successfully.');
    }

    public function destroy($id)
    {
        $esg = Esg::with(['innovationFeatures', 'drivingCounts', 'impacts', 'wasteFeatures'])->findOrFail($id);

        foreach (self::SINGLE_IMAGES as $field) {
            $this->deleteImage($esg->$field);
        }
        foreach (self::CHILD_TABLES as $cfg) {
            foreach ($esg->{$cfg['relation']} as $row) {
                $this->deleteImage($row->image);
            }
            $esg->{$cfg['relation']}()->delete();
        }

        $esg->delete();

        return redirect()->route('manage-esg.index')->with('message', 'ESG page deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function onlyMainFields(array $data): array
    {
        // Strip child-table arrays before writing to the main record.
        foreach (array_keys(self::CHILD_TABLES) as $key) {
            unset($data[$key]);
        }

        return $data;
    }

    private function rules(?int $ignoreId = null): array
    {
        $img = ($ignoreId ? 'nullable' : 'required').'|file|mimes:jpg,jpeg,png,webp,svg|max:2048';

        $rules = [
            // Banner
            'banner_heading' => 'required|string|max:255',
            'banner_image'   => $img,
            // Director Message
            'director_image'    => $img,
            'director_heading'  => 'required|string|max:255',
            'director_desc'     => 'required|string',
            'director_name'     => 'required|string|max:255',
            'director_position' => 'required|string|max:255',
            // Innovation
            'innovation_heading'  => 'required|string|max:255',
            'innovation_bg_image' => $img,
            // Development Goals
            'dev_heading' => 'required|string|max:255',
            'dev_image'   => $img,
            'dev_desc'    => 'required|string',
            // Driving Change
            'driving_heading'  => 'required|string|max:255',
            'driving_bg_image' => $img,
            // Impact
            'impact_heading' => 'required|string|max:255',
            // Stakeholder
            'stakeholder_heading' => 'required|string|max:255',
            'stakeholder_image'   => $img,
            'stakeholder_desc'    => 'required|string',
            // Waste
            'waste_heading' => 'required|string|max:255',
            'waste_desc'    => 'required|string',
            // Environmental Declarations
            'env_heading'            => 'required|string|max:255',
            'env_short_desc'         => 'required|string',
            'env_specification_desc' => 'required|string',
        ];

        // Child tables — optional; each added row must be complete.
        foreach (self::CHILD_TABLES as $key => $cfg) {
            $rules[$key] = 'nullable|array';
            $rules["{$key}.*.image"] = 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048';
            foreach ($cfg['text'] as $f) {
                $rules["{$key}.*.{$f}"] = 'required|string';
            }
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            '*.required'      => 'This field is required.',
            '*.image.mimes'   => 'Images must be jpg, jpeg, png or webp.',
            '*.image.max'     => 'Images may not be larger than 2 MB.',
            '*.max'           => 'Images may not be larger than 2 MB.',
        ];
    }

    /** Rebuild a repeatable child table from the submitted rows. */
    private function syncChildRows(Esg $esg, string $relation, Request $request, string $key, array $textFields): void
    {
        $oldImages = $esg->{$relation}()->pluck('image')->all();
        $esg->{$relation}()->delete();

        $keptImages = [];

        foreach ((array) $request->input($key, []) as $i => $row) {
            $image = $row['existing_image'] ?? null;

            if ($request->hasFile("{$key}.{$i}.image")) {
                $image = $this->storeImage($request->file("{$key}.{$i}.image"));
            }

            if (! $image) {
                continue; // every row needs an image
            }

            $payload = ['image' => $image, 'sort_order' => $i];
            foreach ($textFields as $f) {
                $payload[$f] = $row[$f] ?? '';
            }

            $esg->{$relation}()->create($payload);
            $keptImages[] = $image;
        }

        foreach (array_diff($oldImages, $keptImages) as $orphan) {
            $this->deleteImage($orphan);
        }
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
