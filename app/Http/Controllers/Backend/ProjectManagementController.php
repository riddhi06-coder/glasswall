<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectManagementController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'project-mgmt';

    public function index()
    {
        $records = ProjectManagement::latest()->get();

        return view('backend.infra.project_management.index', compact('records'));
    }

    public function create()
    {
        // Singleton: only one record allowed.
        if ($existing = ProjectManagement::first()) {
            return redirect()->route('manage-project-management.edit', $existing->id)
                ->with('message', 'Project Management details already exist. You can edit them here.');
        }

        return view('backend.infra.project_management.create');
    }

    public function store(Request $request)
    {
        if ($existing = ProjectManagement::first()) {
            return redirect()->route('manage-project-management.edit', $existing->id);
        }

        $data = $request->validate($this->rules(), $this->messages());

        $record = ProjectManagement::create([
            'banner_heading' => $data['banner_heading'],
            'banner_image'   => $this->storeUpload($request->file('banner_image')),
            'description'    => $data['description'],
            'created_by'     => Auth::id(),
        ]);

        $this->syncPointers($record, $request);

        return redirect()->route('manage-project-management.index')->with('message', 'Project Management details added successfully.');
    }

    public function edit($id)
    {
        $record = ProjectManagement::with('pointers')->findOrFail($id);

        return view('backend.infra.project_management.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = ProjectManagement::findOrFail($id);

        $data = $request->validate($this->rules($record->id), $this->messages());

        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($record->banner_image);
            $record->banner_image = $this->storeUpload($request->file('banner_image'));
        }

        $record->banner_heading = $data['banner_heading'];
        $record->description    = $data['description'];
        $record->updated_by     = Auth::id();
        $record->save();

        $this->syncPointers($record, $request);

        return redirect()->route('manage-project-management.index')->with('message', 'Project Management details updated successfully.');
    }

    public function destroy($id)
    {
        $record = ProjectManagement::findOrFail($id);
        $this->deleteUpload($record->banner_image);
        $record->pointers()->delete();
        $record->delete();

        return redirect()->route('manage-project-management.index')->with('message', 'Project Management details deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        return [
            'banner_heading'     => 'required|string|max:255',
            'banner_image'       => "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048",
            'description'        => 'required|string',
            'pointers'           => 'required|array|min:1',
            'pointers.*.pointer' => 'required|string|max:1000',
            'pointers.*.image'   => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ];
    }

    private function messages(): array
    {
        return [
            'banner_image.required'      => 'The banner image is required.',
            'banner_image.mimes'         => 'Banner image must be jpg, jpeg, png, webp or svg.',
            'banner_image.max'           => 'Banner image may not be larger than 2 MB.',
            'pointers.required'          => 'Add at least one pointer.',
            'pointers.*.pointer.required' => 'Pointer text is required.',
        ];
    }

    private function syncPointers(ProjectManagement $record, Request $request): void
    {
        $rows = $request->input('pointers', []);

        // Keep track of images still in use so removed ones can be cleaned up.
        $kept = [];

        $record->pointers()->delete();

        $order = 0;
        foreach ($rows as $i => $row) {
            $text = trim($row['pointer'] ?? '');
            if ($text === '') {
                continue;
            }

            // New upload for this row wins; otherwise keep the existing image.
            $image = $row['existing_image'] ?? null;
            if ($file = $request->file("pointers.$i.image")) {
                $image = $this->storeUpload($file);
            }
            if ($image) {
                $kept[] = $image;
            }

            $record->pointers()->create([
                'pointer'    => $text,
                'image'      => $image,
                'sort_order' => $order++,
            ]);
        }
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
