<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;

class ContactSubmissionController extends Controller
{
    public function index()
    {
        $submissions = ContactSubmission::latest()->get();

        return view('backend.enquiries.contact.index', compact('submissions'));
    }

    public function show($id)
    {
        $submission = ContactSubmission::findOrFail($id);

        return view('backend.enquiries.contact.show', compact('submission'));
    }

    public function destroy($id)
    {
        ContactSubmission::findOrFail($id)->delete();

        return redirect()->route('manage-contact-enquiries.index')->with('message', 'Enquiry deleted successfully.');
    }
}
