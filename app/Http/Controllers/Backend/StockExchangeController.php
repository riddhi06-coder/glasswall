<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StockExchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockExchangeController extends Controller
{
    public function index()
    {
        $record = StockExchange::firstOrCreate([], [
            'banner_heading' => 'Stock Exchange',
            'created_by'     => Auth::id(),
        ]);

        return view('backend.stock_exchange.settings', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = StockExchange::findOrFail($id);

        $data = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'page_heading'   => 'nullable|string|max:255',
            'banner_image'   => 'nullable|file|mimes:jpg,jpeg,webp,svg|max:2048',
        ], [
            'banner_image.mimes' => 'The banner must be a jpg, jpeg, webp or svg.',
            'banner_image.max'   => 'The banner image may not be larger than 2 MB.',
        ]);

        if ($request->hasFile('banner_image')) {
            $this->deleteUpload($record->banner_image);
            $data['banner_image'] = $this->storeUpload($request->file('banner_image'));
        }

        $data['updated_by'] = Auth::id();
        $record->update($data);

        return redirect()->route('manage-stock-exchange.index')->with('message', 'Stock Exchange page settings updated successfully.');
    }

    // ------------------------------------------------------------------
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
