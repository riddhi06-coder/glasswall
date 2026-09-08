<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IpoDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpoController extends Controller
{
    /** Upload directory under /public (plural — clear of any /annual-report route). */
    private const DIR = 'ipo-docs';

    public function index()
    {
        $reports = IpoDocument::orderBy('priority')->orderBy('id')->get();

        return view('backend.investors.ipo.index', compact('reports'));
    }

    public function create()
    {
        $isFirst = IpoDocument::count() === 0;

        return view('backend.investors.ipo.create', array_merge(
            compact('isFirst'),
            $this->classificationOptions()
        ));
    }

    public function store(Request $request)
    {
        $isFirst = IpoDocument::count() === 0;

        $data = $request->validate($this->rules($isFirst), $this->messages());

        $data['pdf'] = $request->hasFile('pdf') ? $this->storeUpload($request->file('pdf')) : null;

        if ($isFirst) {
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['priority']   = $data['priority'] ?? 0;
        $data['created_by'] = Auth::id();
        IpoDocument::create($data);

        return redirect()->route('manage-ipo.index')->with('message', 'IPO document added successfully.');
    }

    public function edit($id)
    {
        $report  = IpoDocument::findOrFail($id);
        $isFirst = $report->id === IpoDocument::orderBy('id')->value('id');

        return view('backend.investors.ipo.edit', array_merge(
            compact('report', 'isFirst'),
            $this->classificationOptions()
        ));
    }

    public function update(Request $request, $id)
    {
        $report  = IpoDocument::findOrFail($id);
        $isFirst = $report->id === IpoDocument::orderBy('id')->value('id');

        $data = $request->validate($this->rules($isFirst, $report->id), $this->messages());

        unset($data['pdf']);
        if ($request->hasFile('pdf')) {
            $this->deleteUpload($report->pdf);
            $data['pdf'] = $this->storeUpload($request->file('pdf'));
        }

        if ($isFirst) {
            unset($data['banner_image']);
            if ($request->hasFile('banner_image')) {
                $this->deleteUpload($report->banner_image);
                $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
            }
        } else {
            unset($data['banner_image'], $data['banner_heading']);
        }

        $data['priority']   = $data['priority'] ?? 0;
        $data['updated_by'] = Auth::id();
        $report->update($data);

        return redirect()->route('manage-ipo.index')->with('message', 'IPO document updated successfully.');
    }

    public function destroy($id)
    {
        $report = IpoDocument::findOrFail($id);
        $this->deleteUpload($report->pdf);
        $this->deleteUpload($report->banner_image);
        $report->delete();

        return redirect()->route('manage-ipo.index')->with('message', 'IPO document deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(bool $isFirst, ?int $ignoreId = null): array
    {
        // On create a source is required — either an uploaded file OR an external URL.
        $pdfRule = $ignoreId ? 'nullable' : 'required_without:external_url';

        $rules = [
            'title'        => 'required|string|max:255',
            'group'        => 'nullable|string|max:255',
            'subgroup'     => 'nullable|string|max:255',
            'pdf'          => "{$pdfRule}|file|mimes:pdf,mp4,webm|max:20480",
            'external_url' => 'nullable|url|max:2048',
            'is_active'    => 'required|in:0,1',
            'priority'     => 'nullable|integer|min:0',
        ];

        if ($isFirst) {
            $rules['banner_heading'] = 'required|string|max:255';
            $rules['banner_image']   = "{$req}|file|mimes:jpg,jpeg,png,webp,svg|max:2048";
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'title.required'          => 'The report title is required.',
            'pdf.required_without'    => 'Provide a PDF/MP4 file or an External URL.',
            'pdf.mimes'               => 'The file must be a PDF or MP4.',
            'pdf.max'                 => 'The file may not be larger than 20 MB.',
            'external_url.url'        => 'The external URL must be a valid link (https://…).',
            'banner_heading.required' => 'The banner heading is required.',
            'banner_image.required'   => 'The banner image is required.',
            'banner_image.max'        => 'Banner image may not be larger than 2 MB.',
        ];
    }

    /** Distinct existing group / subgroup values for the form datalists. */
    private function classificationOptions(): array
    {
        return [
            'groupOptions'    => IpoDocument::whereNotNull('group')->distinct()->orderBy('group')->pluck('group'),
            'subgroupOptions' => IpoDocument::whereNotNull('subgroup')->distinct()->orderBy('subgroup')->pluck('subgroup'),
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
