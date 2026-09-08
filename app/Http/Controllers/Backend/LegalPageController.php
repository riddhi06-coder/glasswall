<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LegalPageController extends Controller
{
    public function index()
    {
        $pages = LegalPage::orderBy('id')->get();

        return view('backend.legal.index', compact('pages'));
    }

    public function edit($id)
    {
        $page = LegalPage::findOrFail($id);

        return view('backend.legal.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = LegalPage::findOrFail($id);

        $data = $request->validate([
            'heading'      => 'required|string|max:255',
            'content'      => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'banner_image.image' => 'The banner must be an image.',
            'banner_image.mimes' => 'The banner must be a jpg, jpeg, png or webp.',
            'banner_image.max'   => 'The banner image may not be larger than 2 MB.',
        ]);

        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($page->banner_image);
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        } else {
            unset($data['banner_image']);
        }

        $data['updated_by'] = Auth::id();
        $page->update($data);

        return redirect()->route('manage-legal-pages.index')->with('message', $page->heading.' updated successfully.');
    }

    // ------------------------------------------------------------------
    private function storeUpload($file): string
    {
        $folder = public_path(LegalPage::DIR);
        if (! is_dir($folder)) {
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

        $path = public_path(LegalPage::DIR.'/'.$fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
