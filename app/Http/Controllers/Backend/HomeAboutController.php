<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeAboutController extends Controller
{
    /** Icon upload directory under /public. */
    private const ICON_DIR = 'home/aboutmilestones';

    public function index()
    {
        $abouts = HomeAbout::with('milestones')->latest()->get();

        return view('backend.home.about.index', compact('abouts'));
    }

    public function create()
    {
        return view('backend.home.about.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'            => 'required|string',
            'milestones'             => 'array',
            'milestones.*.icon'      => 'required|file|mimes:svg,png,jpg,jpeg,webp|max:2048',
            'milestones.*.count'     => 'required|string|max:255',
            'milestones.*.milestone' => 'required|string|max:255',
        ], [
            'description.required'          => 'The description is required.',
            'milestones.*.icon.required'    => 'Each milestone needs an icon.',
            'milestones.*.icon.mimes'       => 'Icon must be svg, png, jpg, jpeg or webp.',
            'milestones.*.icon.max'         => 'Icon may not be larger than 2 MB.',
            'milestones.*.count.required'   => 'Each milestone needs a count.',
            'milestones.*.milestone.required' => 'Each milestone needs a label.',
        ]);

        $about = HomeAbout::create([
            'description' => $validated['description'],
            'created_by'  => Auth::id(),
        ]);

        foreach ($request->milestones ?? [] as $i => $row) {
            $iconName = $this->storeIcon($request->file("milestones.$i.icon"));
            $about->milestones()->create([
                'icon'       => $iconName,
                'count'      => $row['count'],
                'milestone'  => $row['milestone'],
                'sort_order' => $i,
            ]);
        }

        return redirect()->route('home-about-details.index')->with('message', 'About section added successfully.');
    }

    public function edit($id)
    {
        $about = HomeAbout::with('milestones')->findOrFail($id);

        return view('backend.home.about.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = HomeAbout::with('milestones')->findOrFail($id);

        $validated = $request->validate([
            'description'            => 'required|string',
            'milestones'             => 'array',
            'milestones.*.count'     => 'required|string|max:255',
            'milestones.*.milestone' => 'required|string|max:255',
            'milestones.*.icon'      => 'nullable|file|mimes:svg,png,jpg,jpeg,webp|max:2048',
        ], [
            'description.required'            => 'The description is required.',
            'milestones.*.count.required'     => 'Each milestone needs a count.',
            'milestones.*.milestone.required' => 'Each milestone needs a label.',
            'milestones.*.icon.mimes'         => 'Icon must be svg, png, jpg, jpeg or webp.',
            'milestones.*.icon.max'           => 'Icon may not be larger than 2 MB.',
        ]);

        $about->update([
            'description' => $validated['description'],
            'updated_by'  => Auth::id(),
        ]);

        // Rebuild the milestone rows. Existing icons are preserved via the
        // hidden "existing_icon" field unless a new file is uploaded.
        $oldIcons  = $about->milestones->pluck('icon')->all();
        $keptIcons = [];

        $about->milestones()->delete();

        foreach ($request->milestones ?? [] as $i => $row) {
            $iconName = $row['existing_icon'] ?? null;

            if ($request->hasFile("milestones.$i.icon")) {
                $iconName = $this->storeIcon($request->file("milestones.$i.icon"));
            }

            if (! $iconName) {
                continue; // safety net: a row with no icon at all is skipped
            }

            $about->milestones()->create([
                'icon'       => $iconName,
                'count'      => $row['count'],
                'milestone'  => $row['milestone'],
                'sort_order' => $i,
            ]);

            $keptIcons[] = $iconName;
        }

        // Remove icon files that are no longer referenced.
        foreach (array_diff($oldIcons, $keptIcons) as $orphan) {
            $this->deleteIcon($orphan);
        }

        return redirect()->route('home-about-details.index')->with('message', 'About section updated successfully.');
    }

    public function destroy($id)
    {
        $about = HomeAbout::with('milestones')->findOrFail($id);

        // Remove icon files and milestone rows, then soft-delete the record.
        // (The parent is soft-deleted, so the DB cascade won't fire — clear the
        //  child rows explicitly to avoid orphans.)
        foreach ($about->milestones as $m) {
            $this->deleteIcon($m->icon);
        }
        $about->milestones()->delete();

        $about->delete();

        return redirect()->route('home-about-details.index')->with('message', 'About section deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function storeIcon($file): string
    {
        $folder = public_path(self::ICON_DIR);
        if (! file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($folder, $fileName);

        return $fileName;
    }

    private function deleteIcon(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path(self::ICON_DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
