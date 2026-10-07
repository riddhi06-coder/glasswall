<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SeoMetaController extends Controller
{
    public function index()
    {
        $records = SeoMeta::orderBy('url_path')->get();

        return view('backend.seo.index', compact('records'));
    }

    public function create()
    {
        return view('backend.seo.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['url_path']   = SeoMeta::normalizePath($data['url_path']);
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = Auth::id();

        SeoMeta::create($data);

        return redirect()->route('manage-seo.index')->with('message', 'SEO entry added successfully.');
    }

    public function edit($id)
    {
        $record = SeoMeta::findOrFail($id);

        return view('backend.seo.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = SeoMeta::findOrFail($id);

        $data = $this->validateData($request, $record->id);

        $data['url_path']   = SeoMeta::normalizePath($data['url_path']);
        $data['is_active']  = $request->boolean('is_active');
        $data['updated_by'] = Auth::id();

        $record->update($data);

        return redirect()->route('manage-seo.index')->with('message', 'SEO entry updated successfully.');
    }

    public function destroy($id)
    {
        $record = SeoMeta::findOrFail($id);
        $record->delete();

        return redirect()->route('manage-seo.index')->with('message', 'SEO entry deleted successfully.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'url_path'         => ['required', 'string', 'max:255', Rule::unique('seo_metas', 'url_path')->ignore($ignoreId)->whereNull('deleted_at')],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'canonical'        => ['nullable', 'string', 'max:500'],
            'hreflang'         => ['nullable', 'string'],
            'og_tag'           => ['nullable', 'string'],
            'twitter_card_tag' => ['nullable', 'string'],
        ], [
            'url_path.required' => 'The page URL / path is required.',
            'url_path.unique'   => 'An SEO entry for this URL already exists.',
        ]);
    }
}
