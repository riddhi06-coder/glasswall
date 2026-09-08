<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;

class CareerApplicationController extends Controller
{
    public function index()
    {
        // Order by job role so DataTables RowGroup keeps each group contiguous.
        $applications = CareerApplication::orderBy('job_role')->latest()->get();

        return view('backend.enquiries.career.index', compact('applications'));
    }

    public function show($id)
    {
        $application = CareerApplication::findOrFail($id);

        return view('backend.enquiries.career.show', compact('application'));
    }

    public function destroy($id)
    {
        $application = CareerApplication::findOrFail($id);

        // Remove the stored resume file, then soft-delete the record.
        if ($application->resume_path && is_file(public_path($application->resume_path))) {
            @unlink(public_path($application->resume_path));
        }
        $application->delete();

        return redirect()->route('manage-career-applications.index')->with('message', 'Application deleted successfully.');
    }
}
