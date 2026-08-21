<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BoardDirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardDirectorController extends Controller
{
    /** Upload directory under /public. */
    private const DIR = 'board';

    public function index()
    {
        $directors = BoardDirector::orderBy('id')->get();

        return view('backend.overview.board_of_directors.index', compact('directors'));
    }

    public function create()
    {
        // The banner block is only captured on the very first record.
        $isFirst = BoardDirector::count() === 0;

        return view('backend.overview.board_of_directors.create', compact('isFirst'));
    }

    public function store(Request $request)
    {
        $isFirst = BoardDirector::count() === 0;

        $data = $request->validate($this->rules($isFirst), $this->messages());

        $data['image'] = $this->storeImage($request->file('image'));

        if ($isFirst) {
            $data['banner_image'] = $this->storeImage($request->file('banner_image'));
        } else {
            unset($data['banner_image'], $data['banner_heading'], $data['banner_description']);
        }

        $data['created_by'] = Auth::id();
        BoardDirector::create($data);

        return redirect()->route('manage-board-of-directors.index')->with('message', 'Director added successfully.');
    }

    public function edit($id)
    {
        $director = BoardDirector::findOrFail($id);
        $isFirst  = $director->id === BoardDirector::orderBy('id')->value('id');

        return view('backend.overview.board_of_directors.edit', compact('director', 'isFirst'));
    }

    public function update(Request $request, $id)
    {
        $director = BoardDirector::findOrFail($id);
        $isFirst  = $director->id === BoardDirector::orderBy('id')->value('id');

        $data = $request->validate($this->rules($isFirst, $director->id), $this->messages());

        // Director image.
        unset($data['image']);
        if ($request->hasFile('image')) {
            $this->deleteImage($director->image);
            $data['image'] = $this->storeImage($request->file('image'));
        }

        // Banner (first record only).
        if ($isFirst) {
            unset($data['banner_image']);
            if ($request->hasFile('banner_image')) {
                $this->deleteImage($director->banner_image);
                $data['banner_image'] = $this->storeImage($request->file('banner_image'));
            }
        } else {
            unset($data['banner_image'], $data['banner_heading'], $data['banner_description']);
        }

        $data['updated_by'] = Auth::id();
        $director->update($data);

        return redirect()->route('manage-board-of-directors.index')->with('message', 'Director updated successfully.');
    }

    public function destroy($id)
    {
        $director = BoardDirector::findOrFail($id);
        $this->deleteImage($director->image);
        $this->deleteImage($director->banner_image);
        $director->delete();

        return redirect()->route('manage-board-of-directors.index')->with('message', 'Director deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(bool $isFirst, ?int $ignoreId = null): array
    {
        $req = $ignoreId ? 'nullable' : 'required';

        $rules = [
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image'       => "{$req}|file|mimes:jpg,jpeg,png,webp|max:2048",
            'info'        => 'required|string',
        ];

        if ($isFirst) {
            $rules['banner_heading']     = 'required|string|max:255';
            $rules['banner_description'] = 'required|string';
            $rules['banner_image']       = "{$req}|file|mimes:jpg,jpeg,png,webp|max:2048";
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'name.required'            => 'The name is required.',
            'designation.required'     => 'The designation is required.',
            'image.required'           => 'The director image is required.',
            'image.max'                => 'Image may not be larger than 2 MB.',
            'info.required'            => 'The info is required.',
            'banner_heading.required'  => 'The banner heading is required.',
            'banner_description.required' => 'The banner description is required.',
            'banner_image.required'    => 'The banner image is required.',
            'banner_image.max'         => 'Banner image may not be larger than 2 MB.',
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
