<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Disclosure;
use App\Models\DisclosureRow;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'title'      => $data['title'] ?? null,
            'type'       => $data['type'],
            'year'       => $data['year'] ?? null,
            'is_active'  => $request->boolean('is_active'),
        ]);

        $row->slug = $this->uniqueSlug($data['title'] ?? 'item', $row->id);
        $row->save();

        $this->syncLinks($row, $request);
        $this->syncTabs($row, $request);

        return redirect()->route('manage-disclosure-items.index')->with('message', 'Disclosure item added successfully.');
    }

    public function edit($id)
    {
        $record = DisclosureRow::with(['links', 'tabs.tabItems'])->findOrFail($id);

        return view('backend.disclosures.items.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $row  = DisclosureRow::findOrFail($id);
        $data = $this->validateData($request);

        $row->update([
            'title'      => $data['title'] ?? null,
            'type'       => $data['type'],
            'year'       => $data['year'] ?? null,
            'is_active'  => $request->boolean('is_active'),
        ]);

        $row->slug = $this->uniqueSlug($data['title'] ?? 'item', $row->id);
        $row->save();

        $this->syncLinks($row, $request);
        $this->syncTabs($row, $request);

        return redirect()->route('manage-disclosure-items.index')->with('message', 'Disclosure item updated successfully.');
    }

    public function destroy($id)
    {
        $row = DisclosureRow::with(['links', 'tabs.tabItems'])->findOrFail($id);
        foreach ($row->links as $link) {
            $this->deleteUpload($link->file);
        }
        foreach ($row->tabs as $tab) {
            foreach ($tab->tabItems as $it) { $this->deleteUpload($it->file); }
            $tab->tabItems()->delete();
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

    /** Tabs rows: each tab holds a list of documents (title + URL/file). Empty tab => "Coming Soon". */
    private function syncTabs(DisclosureRow $row, Request $request): void
    {
        if ($row->type !== 'tabs') {
            foreach ($row->tabs as $tab) {
                foreach ($tab->tabItems as $it) { $this->deleteUpload($it->file); }
                $tab->tabItems()->delete();
            }
            $row->tabs()->delete();
            return;
        }

        $tabsInput  = (array) $request->input('tabs', []);
        $keptTabIds = array_filter(array_column($tabsInput, 'id'));

        // Remove deleted tabs (and their documents + files).
        foreach ($row->tabs()->whereNotIn('id', $keptTabIds ?: [0])->get() as $staleTab) {
            foreach ($staleTab->tabItems as $it) { $this->deleteUpload($it->file); }
            $staleTab->tabItems()->delete();
            $staleTab->delete();
        }

        $tabOrder = 0;
        foreach ($tabsInput as $tabKey => $t) {
            $label = trim($t['label'] ?? '');
            $items = (array) ($t['items'] ?? []);
            if (empty($t['id']) && $label === '' && ! $items) {
                continue;
            }

            if (! empty($t['id'])) {
                $tab = $row->tabs()->where('id', $t['id'])->first();
                if (! $tab) { continue; }
                $tab->update(['label' => $label ?: 'Tab', 'sort_order' => $tabOrder++]);
            } else {
                $tab = $row->tabs()->create(['label' => $label ?: 'Tab', 'sort_order' => $tabOrder++]);
            }

            $this->syncTabItems($tab, $items, $request, $tabKey);
        }
    }

    private function syncTabItems($tab, array $items, Request $request, $tabKey): void
    {
        $keptIds = array_filter(array_column($items, 'id'));

        foreach ($tab->tabItems()->whereNotIn('id', $keptIds ?: [0])->get() as $stale) {
            $this->deleteUpload($stale->file);
            $stale->delete();
        }

        $order = 0;
        foreach ($items as $itKey => $it) {
            $title = trim($it['title'] ?? '');
            $file  = $request->file("tabs.$tabKey.items.$itKey.file");

            if (empty($it['id']) && ! $file && $title === '') {
                continue;
            }

            if (! empty($it['id'])) {
                $item = $tab->tabItems()->where('id', $it['id'])->first();
                if (! $item) { continue; }
                if ($file) {
                    $this->deleteUpload($item->file);
                    $item->file = $this->storeUpload($file);
                }
                $item->title      = $title ?: null;
                $item->sort_order = $order++;
                $item->save();
                continue;
            }

            $tab->tabItems()->create([
                'title'      => $title ?: null,
                'file'       => $file ? $this->storeUpload($file) : null,
                'sort_order' => $order++,
            ]);
        }
    }

    /** Unique slug for the tabs detail page URL, derived from the title. */
    private function uniqueSlug(?string $source, int $ignoreId): string
    {
        $base = Str::slug(strip_tags((string) $source)) ?: 'item';
        $slug = $base;
        $i    = 2;
        while (DisclosureRow::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    // ------------------------------------------------------------------
    private function validateData(Request $request): array
    {
        return $request->validate([
            'title'                 => 'nullable|string',
            'type'                  => 'required|in:links,financial,tabs',
            'year'                  => 'nullable|string|max:50',
            'links'                 => 'nullable|array',
            'links.*.name'          => 'nullable|string',
            'links.*.label'         => 'nullable|string|max:100',
            'links.*.url'           => 'nullable|string|max:500',
            'links.*.file'          => 'nullable|file|mimes:pdf,doc,docx,zip|max:5120',
            'tabs'                  => 'nullable|array',
            'tabs.*.label'          => 'nullable|string|max:100',
            'tabs.*.items'          => 'nullable|array',
            'tabs.*.items.*.title'  => 'nullable|string',
            'tabs.*.items.*.file'   => 'nullable|file|mimes:pdf,doc,docx,zip|max:5120',
        ], [
            'links.*.file.mimes'        => 'Documents must be a PDF, DOC, DOCX or ZIP file.',
            'links.*.file.max'          => 'Each document may not be larger than 5 MB.',
            'tabs.*.items.*.file.mimes' => 'Documents must be a PDF, DOC, DOCX or ZIP file.',
            'tabs.*.items.*.file.max'   => 'Each document may not be larger than 5 MB.',
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
