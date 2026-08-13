<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeClientele;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeClienteleController extends Controller
{
    /** Client image upload directory under /public. */
    private const IMAGE_DIR = 'home/clienteleimages';

    public function index()
    {
        $clienteles = HomeClientele::with('images')->latest()->get();

        return view('backend.home.clientele.index', compact('clienteles'));
    }

    public function create()
    {
        return view('backend.home.clientele.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(true), $this->messages());

        $clientele = HomeClientele::create($this->payload($validated) + ['created_by' => Auth::id()]);

        foreach ($request->clients ?? [] as $i => $row) {
            $fileName = $this->storeImage($request->file("clients.$i.image"));
            $clientele->images()->create(['image' => $fileName, 'sort_order' => $i]);
        }

        return redirect()->route('home-clientele.index')->with('message', 'Clientele section added successfully.');
    }

    public function edit($id)
    {
        $clientele = HomeClientele::with('images')->findOrFail($id);

        return view('backend.home.clientele.edit', compact('clientele'));
    }

    public function update(Request $request, $id)
    {
        $clientele = HomeClientele::with('images')->findOrFail($id);

        $validated = $request->validate($this->rules(false), $this->messages());

        $clientele->update($this->payload($validated) + ['updated_by' => Auth::id()]);

        // Rebuild client image rows, preserving existing images unless replaced.
        $oldImages  = $clientele->images->pluck('image')->all();
        $keptImages = [];

        $clientele->images()->delete();

        foreach ($request->clients ?? [] as $i => $row) {
            $fileName = $row['existing_image'] ?? null;

            if ($request->hasFile("clients.$i.image")) {
                $fileName = $this->storeImage($request->file("clients.$i.image"));
            }

            if (! $fileName) {
                continue;
            }

            $clientele->images()->create(['image' => $fileName, 'sort_order' => $i]);
            $keptImages[] = $fileName;
        }

        foreach (array_diff($oldImages, $keptImages) as $orphan) {
            $this->deleteImage($orphan);
        }

        return redirect()->route('home-clientele.index')->with('message', 'Clientele section updated successfully.');
    }

    public function destroy($id)
    {
        $clientele = HomeClientele::with('images')->findOrFail($id);

        foreach ($clientele->images as $img) {
            $this->deleteImage($img->image);
        }
        $clientele->images()->delete();

        $clientele->delete();

        return redirect()->route('home-clientele.index')->with('message', 'Clientele section deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Validation
    // ------------------------------------------------------------------
    private function rules(bool $creating): array
    {
        $rules = [
            'product_section_heading'       => 'required|string|max:255',
            'work_section_heading'          => 'required|string|max:255',
            'project_section_heading'       => 'required|string|max:255',
            'clientele_section_heading'     => 'required|string|max:255',
            'clientele_section_desc'        => 'required|string',
            'collaboration_section_heading' => 'required|string|max:255',
            'collaboration_section_title'   => 'required|string|max:255',
            'clients'                       => ($creating ? 'required|' : '').'array'.($creating ? '|min:1' : ''),
            'clients.*.image'               => ($creating ? 'required' : 'nullable').'|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ];

        return $rules;
    }

    private function messages(): array
    {
        return [
            'clients.required'        => 'Please add at least one client image.',
            'clients.min'             => 'Please add at least one client image.',
            'clients.*.image.required'=> 'Each client row needs an image.',
            'clients.*.image.mimes'   => 'Client image must be jpg, jpeg, png, webp or svg.',
            'clients.*.image.max'     => 'Client image may not be larger than 2 MB.',
        ];
    }

    private function payload(array $v): array
    {
        return [
            'product_section_heading'       => $v['product_section_heading'],
            'work_section_heading'          => $v['work_section_heading'],
            'project_section_heading'       => $v['project_section_heading'],
            'clientele_section_heading'     => $v['clientele_section_heading'],
            'clientele_section_desc'        => $v['clientele_section_desc'],
            'collaboration_section_heading' => $v['collaboration_section_heading'],
            'collaboration_section_title'   => $v['collaboration_section_title'],
        ];
    }

    // ------------------------------------------------------------------
    // File helpers
    // ------------------------------------------------------------------
    private function storeImage($file): string
    {
        $folder = public_path(self::IMAGE_DIR);
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

        $path = public_path(self::IMAGE_DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
