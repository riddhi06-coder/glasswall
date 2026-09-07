<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CareerJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index()
    {
        $jobs = CareerJob::latest()->get();

        return view('backend.career.job.index', compact('jobs'));
    }

    public function create()
    {
        return view('backend.career.job.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        CareerJob::create([
            'job_role'        => $validated['job_role'],
            'slug'            => $this->generateUniqueSlug($validated['job_role']),
            'description'     => $validated['description'],
            'location'        => $validated['location'],
            'employment_type' => $validated['employment_type'],
            'experience'      => $validated['experience'],
            'qualification'   => $validated['qualification'],
            'is_active'       => $validated['is_active'],
            'created_by'      => Auth::id(),
        ]);

        return redirect()->route('manage-jobs.index')->with('message', 'Job added successfully.');
    }

    public function edit($id)
    {
        $job = CareerJob::findOrFail($id);

        return view('backend.career.job.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = CareerJob::findOrFail($id);

        $validated = $request->validate($this->rules(), $this->messages());

        if ($job->job_role !== $validated['job_role']) {
            $job->slug = $this->generateUniqueSlug($validated['job_role'], $job->id);
        }

        $job->job_role        = $validated['job_role'];
        $job->description     = $validated['description'];
        $job->location        = $validated['location'];
        $job->employment_type = $validated['employment_type'];
        $job->experience      = $validated['experience'];
        $job->qualification   = $validated['qualification'];
        $job->is_active       = $validated['is_active'];
        $job->updated_by      = Auth::id();
        $job->save();

        return redirect()->route('manage-jobs.index')->with('message', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        $job = CareerJob::findOrFail($id);
        $job->delete();

        return redirect()->route('manage-jobs.index')->with('message', 'Job deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(): array
    {
        return [
            'job_role'        => 'required|string|max:255',
            'description'     => 'required|string',
            'location'        => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'experience'      => 'required|string|max:255',
            'qualification'   => 'required|string|max:255',
            'is_active'       => 'required|in:0,1',
        ];
    }

    private function messages(): array
    {
        return [
            'job_role.required'        => 'The job role is required.',
            'description.required'     => 'The description is required.',
            'location.required'        => 'The location is required.',
            'employment_type.required' => 'The employment type is required.',
            'experience.required'      => 'The experience is required.',
            'qualification.required'   => 'The qualification is required.',
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (CareerJob::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }
}
