<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StockExchange;
use App\Models\StockExchangeTab;
use Illuminate\Http\Request;

class StockExchangeTabController extends Controller
{
    public function index()
    {
        $records = StockExchangeTab::withCount('items')->orderBy('sort_order')->orderBy('id')->get();

        return view('backend.stock_exchange.tabs.index', compact('records'));
    }

    public function create()
    {
        return view('backend.stock_exchange.tabs.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $tab = StockExchangeTab::create([
            'label'      => $data['label'],
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active'  => $request->boolean('is_active'),
        ]);

        $this->syncItems($tab, $request);

        return redirect()->route('manage-stock-exchange-tabs.index')->with('message', 'Tab added successfully.');
    }

    public function edit($id)
    {
        $record = StockExchangeTab::with('items')->findOrFail($id);

        return view('backend.stock_exchange.tabs.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $tab  = StockExchangeTab::findOrFail($id);
        $data = $this->validateData($request);

        $tab->update([
            'label'      => $data['label'],
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active'  => $request->boolean('is_active'),
        ]);

        $this->syncItems($tab, $request);

        return redirect()->route('manage-stock-exchange-tabs.index')->with('message', 'Tab updated successfully.');
    }

    public function destroy($id)
    {
        $tab = StockExchangeTab::with('items')->findOrFail($id);
        foreach ($tab->items as $item) {
            $this->deleteUpload($item->file);
        }
        $tab->items()->delete();
        $tab->delete();

        return redirect()->route('manage-stock-exchange-tabs.index')->with('message', 'Tab deleted successfully.');
    }

    // ------------------------------------------------------------------
    private function syncItems(StockExchangeTab $tab, Request $request): void
    {
        $rows    = (array) $request->input('items', []);
        $keptIds = array_filter(array_column($rows, 'id'));

        foreach ($tab->items()->whereNotIn('id', $keptIds ?: [0])->get() as $stale) {
            $this->deleteUpload($stale->file);
            $stale->delete();
        }

        $order = 0;
        foreach ($rows as $key => $r) {
            $number = trim($r['number'] ?? '');
            $title  = trim($r['title'] ?? '');
            $url    = trim($r['url'] ?? '');
            $file   = $request->file("items.$key.file");

            if (empty($r['id']) && ! $file && $title === '' && $url === '' && $number === '') {
                continue;
            }

            if (! empty($r['id'])) {
                $item = $tab->items()->where('id', $r['id'])->first();
                if (! $item) { continue; }
                if ($file) {
                    $this->deleteUpload($item->file);
                    $item->file = $this->storeUpload($file);
                }
                $item->number     = $number ?: null;
                $item->title      = $title ?: null;
                $item->url        = $url ?: null;
                $item->sort_order = $order++;
                $item->save();
                continue;
            }

            $tab->items()->create([
                'number'     => $number ?: null,
                'title'      => $title ?: null,
                'url'        => $url ?: null,
                'file'       => $file ? $this->storeUpload($file) : null,
                'sort_order' => $order++,
            ]);
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'label'         => 'required|string|max:100',
            'sort_order'    => 'nullable|integer',
            'items'         => 'nullable|array',
            'items.*.number' => 'nullable|string|max:20',
            'items.*.title'  => 'nullable|string',
            'items.*.url'    => 'nullable|string|max:500',
            'items.*.file'   => 'nullable|file|mimes:pdf,doc,docx,zip|max:5120',
        ], [
            'items.*.file.mimes' => 'Documents must be a PDF, DOC, DOCX or ZIP file.',
            'items.*.file.max'   => 'Each document may not be larger than 5 MB.',
        ]);
    }

    private function storeUpload($file): string
    {
        $folder = public_path(StockExchange::DIR);
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
        $path = public_path(StockExchange::DIR.'/'.$fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
