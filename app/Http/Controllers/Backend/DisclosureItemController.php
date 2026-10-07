<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Disclosure;
use App\Models\DisclosureLink;
use App\Models\DisclosureRow;
use Illuminate\Http\Request;

class DisclosureItemController extends Controller
{
    public function index()
    {
        $records = DisclosureRow::withCount(['links', 'tabs'])
            ->orderBy('sort_order')->orderBy('id')->get();

        return view('backend.disclosures.items.index', compact('records'));
    }

    public function create()
    {
        return view('backend.disclosures.items.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $row = DisclosureRow::create([
            'number'     => $data['number'] ?? null,
            'title'      => $data['title'] ?? null,
            'type'       => $data['type'],
            'year'       => $data['year'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active'  => $request->boolean('is_active'),
        ]);

        $this->syncLinks($row, $request);
        $this->syncTabs($row, $request);

        return redirect()->route('manage-disclosure-items.index')->with('message', 'Disclosure item added successfully.');
    }

    public function edit($id)
    {
        $record = DisclosureRow::with(['links', 'tabs'])->findOrFail($id);

        return view('backend.disclosures.items.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $row  = DisclosureRow::findOrFail($id);
        $data = $this->validateData($request);

        $row->update([
            'number'     => $data['number'] ?? null,
            'title'      => $data['title'] ?? null,
            'type'       => $data['type'],
            'year'       => $data['year'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active'  => $request->boolean('is_active'),
        ]);

        $this->syncLinks($row, $request);
        $this->syncTabs($row, $request);

        return redirect()->route('manage-disclosure-items.index')->with('message', 'Disclosure item updated successfully.');
    }

    public function destroy($id)
    {
        $row = DisclosureRow::with('links')->findOrFail($id);
        foreach ($row->links as $link) {
            $this->deleteUpload($link->file);
        }
        $row->links()->delete();
        $row->tabs()->delete();
        $row->delete();

        return redirect()->route('manage-disclosure-items.index')->with('message', 'Disclosure item deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Children sync
    // ------------------------------------------------------------------

    /** Links are used by "links" rows and "financial" sub-items. Tabs rows have none. */
    private function syncLinks(DisclosureRow $row, Request $request): void
    {
        if ($row->type === 'tabs') {
            foreach ($row->links as $link) {
                $this->deleteUpload($link->file);
            }
            $row->links()->delete();
            return;
        }

        $rows    = (array) $request->input('links', []);
        $keptIds = array_filter(array_column($rows, 'id'));

        // Delete removed links (and their files).
        foreach ($row->links()->whereNotIn('id', $keptIds ?: [0])->get() as $stale) {
            $this->deleteUpload($stale->file);
            $stale->delete();
        }

        $order = 0;
        foreach ($rows as $key => $r) {
            $label = trim($r['label'] ?? '');
            $name  = trim($r['name'] ?? '');
            $url   = trim($r['url'] ?? '');
            $file  = $request->file("links.$key.file");

            // Skip genuinely empty new rows.
            if (empty($r['id']) && ! $file && $url === '' && $name === '' && $label === '') {
                continue;
            }

            if (! empty($r['id'])) {
                $link = $row->links()->where('id', $r['id'])->first();
                if (! $link) { continue; }
                if ($file) {
                    $this->deleteUpload($link->file);
                    $link->file = $this->storeUpload($file);
                }
                $link->name       = $name ?: null;
                $link->label      = $label ?: 'View';
                $link->url        = $url ?: null;
                $link->sort_order = $order++;
                $link->save();
                continue;
            }

            $row->links()->create([
                'name'       => $name ?: null,
                'label'      => $label ?: 'View',
                'url'        => $url ?: null,
                'file'       => $file ? $this->storeUpload($file) : null,
                'sort_order' => $order++,
            ]);
        }
    }

    private function syncTabs(DisclosureRow $row, Request $request): void
    {
        if ($row->type !== 'tabs') {
            $row->tabs()->delete();
            return;
        }

        $rows    = (array) $request->input('tabs', []);
        $keptIds = array_filter(array_column($rows, 'id'));

        $row->tabs()->whereNotIn('id', $keptIds ?: [0])->delete();

        $order = 0;
        foreach ($rows as $r) {
            $label   = trim($r['label'] ?? '');
            $content = $r['content'] ?? '';
            if (empty($r['id']) && $label === '' && trim(strip_tags($content)) === '') {
                continue;
            }

            if (! empty($r['id'])) {
                $tab = $row->tabs()->where('id', $r['id'])->first();
                if (! $tab) { continue; }
                $tab->update(['label' => $label ?: 'Tab', 'content' => $content, 'sort_order' => $order++]);
                continue;
            }

            $row->tabs()->create(['label' => $label ?: 'Tab', 'content' => $content, 'sort_order' => $order++]);
        }
    }

    // ------------------------------------------------------------------
    private function validateData(Request $request): array
    {
        return $request->validate([
            'number'          => 'nullable|string|max:20',
            'title'           => 'nullable|string',
            'type'            => 'required|in:links,financial,tabs',
            'year'            => 'nullable|string|max:50',
            'sort_order'      => 'nullable|integer',
            'links'           => 'nullable|array',
            'links.*.name'    => 'nullable|string',
            'links.*.label'   => 'nullable|string|max:100',
            'links.*.url'     => 'nullable|string|max:500',
            'links.*.file'    => 'nullable|file|mimes:pdf,doc,docx,zip|max:5120',
            'tabs'            => 'nullable|array',
            'tabs.*.label'    => 'nullable|string|max:100',
            'tabs.*.content'  => 'nullable|string',
        ], [
            'links.*.file.mimes' => 'Documents must be a PDF, DOC, DOCX or ZIP file.',
            'links.*.file.max'   => 'Each document may not be larger than 5 MB.',
        ]);
    }

    private function storeUpload($file): string
    {
        $folder = public_path(Disclosure::DIR);
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
        $path = public_path(Disclosure::DIR.'/'.$fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
