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

        return view('backend.investors.ipo.create', compact('isFirst'));
    }

    public function store(Request $request)
    {
        $isFirst = IpoDocument::count() === 0;

        $data = $request->validate($this->rules($isFirst), $this->messages());

        $data['pdf'] = $this->storeUpload($request->file('pdf'));

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

        return view('backend.investors.ipo.edit', compact('report', 'isFirst'));
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
        $req = $ignoreId ? 'nullable' : 'required';

        $rules = [
            'title'     => 'required|string|max:255',
            'group'     => 'nullable|string|max:255',
            'pdf'       => "{$req}|file|mimes:pdf,mp4,webm|max:20480",
            'is_active' => 'required|in:0,1',
            'priority'  => 'nullable|integer|min:0',
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
            'pdf.required'            => 'The PDF file is required.',
            'pdf.mimes'               => 'The file must be a PDF or MP4.',
            'pdf.max'                 => 'The PDF may not be larger than 20 MB.',
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
