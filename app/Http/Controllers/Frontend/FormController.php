<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\BrandedFormMail;
use App\Models\CareerApplication;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /** Name: starts with a letter; letters, spaces, . ' - only; min 2 chars. */
    private const NAME_RULE  = ['required', 'string', 'min:2', 'max:100', 'regex:/^[A-Za-z][A-Za-z .\'\-]*$/'];
    private const PHONE_RULE = ['required', 'regex:/^\d{10}$/'];

    // ------------------------------------------------------------------
    // Contact enquiry
    // ------------------------------------------------------------------
    public function contact(Request $request)
    {
        $validator = validator($request->all(), [
            'name'    => self::NAME_RULE,
            'email'   => ['required', 'email:rfc', 'max:150'],
            'company' => ['required', 'string', 'max:150'],
            'phone'   => self::PHONE_RULE,
            'message' => ['required', 'string', 'min:5', 'max:5000'],
        ], $this->messages());

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator, 'contact')->withInput();
        }

        $data          = $validator->validated();
        $data['phone'] = '+91 '.$data['phone'];

        $submission = ContactSubmission::create($data + ['ip_address' => $request->ip()]);

        // Emails — never let a delivery failure break the user's submission.
        try {
            $submitted = now()->format('d M Y, h:i A');

            Mail::to($this->adminEmail('contact_admin_email'))->send(new BrandedFormMail(
                subjectLine: 'New Contact Enquiry — '.$submission->name,
                heading: 'New Contact Enquiry',
                intro: 'You have received a new enquiry through the website contact form.',
                rows: [
                    'Name'      => $submission->name,
                    'Email'     => $submission->email,
                    'Company'   => $submission->company,
                    'Phone'     => $submission->phone,
                    'Message'   => $submission->message,
                    'Submitted' => $submitted,
                ],
                replyToEmail: $submission->email,
                replyToName: $submission->name,
            ));

            Mail::to($submission->email)->send(new BrandedFormMail(
                subjectLine: 'We have received your enquiry — Glass Wall Systems',
                heading: 'Thank you for contacting us',
                intro: "Hi {$submission->name},\n\nThank you for reaching out to Glass Wall Systems. We have received your enquiry and our team will get back to you shortly.",
                rows: ['Your Message' => $submission->message],
                note: 'This is a confirmation that your enquiry has been received. There is no need to reply to this email.',
            ));
        } catch (\Throwable $e) {
            Log::warning('Contact mail failed: '.$e->getMessage());
        }

            return redirect()->route('contact.thank-you');    }

    // ------------------------------------------------------------------
    // Career application
    // ------------------------------------------------------------------
    public function careerApply(Request $request)
    {
        $validator = validator($request->all(), [
            'first_name' => self::NAME_RULE,
            'last_name'  => self::NAME_RULE,
            'email'      => ['required', 'email:rfc', 'max:150'],
            'contact_no' => self::PHONE_RULE,
            'message'    => ['nullable', 'string', 'max:5000'],
            'job_role'   => ['nullable', 'string', 'max:150'],
            'resume'     => ['required', 'file', 'mimes:pdf,doc,docx', 'max:3072'],
        ], $this->messages());

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator, 'career')->withInput()->with('open_career_modal', true);
        }

        $data = $validator->validated();
        $role = trim($data['job_role'] ?? '') !== '' ? trim($data['job_role']) : 'General Application';

        // Store resume under public/uploads/resumes
        $folder = public_path('uploads/resumes');
        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
        $file       = $request->file('resume');
        $ext        = strtolower($file->getClientOriginalExtension());
        $storedName = 'resume_'.Str::random(20).'.'.$ext;
        $file->move($folder, $storedName);
        $relPath = 'uploads/resumes/'.$storedName;
        $absPath = $folder.DIRECTORY_SEPARATOR.$storedName;

        $application = CareerApplication::create([
            'job_role'    => $role,
            'first_name'  => $data['first_name'],
            'last_name'   => $data['last_name'],
            'email'       => $data['email'],
            'contact_no'  => $data['contact_no'],
            'message'     => $data['message'] ?? null,
            'resume_path' => $relPath,
            'resume_name' => $file->getClientOriginalName(),
            'ip_address'  => $request->ip(),
        ]);

        $fullName = trim($application->first_name.' '.$application->last_name);

        try {
            $submitted = now()->format('d M Y, h:i A');

            // Admin notification (with resume attached)
            Mail::to($this->adminEmail('careers_admin_email'))->send(new BrandedFormMail(
                subjectLine: 'New Job Application ('.$role.') — '.$fullName,
                heading: 'New Job Application',
                intro: 'A new job application has been submitted through the website careers form. The resume is attached.',
                rows: [
                    'Name'      => $fullName,
                    'Email'     => $application->email,
                    'Contact'   => $application->contact_no,
                    'Message'   => $application->message ?: '—',
                    'Resume'    => $application->resume_name,
                    'Submitted' => $submitted,
                ],
                highlight: ['label' => 'Position Applied For', 'value' => $role],
                replyToEmail: $application->email,
                replyToName: $fullName,
                attachmentPath: $absPath,
                attachmentName: $application->resume_name,
            ));

            // User confirmation
            Mail::to($application->email)->send(new BrandedFormMail(
                subjectLine: 'Your application has been received — Glass Wall Systems',
                heading: 'Application Received',
                intro: "Hi {$application->first_name},\n\nThank you for applying to Glass Wall Systems. We have successfully received your application and resume. Our HR team will review your profile and reach out if there is a suitable match.",
                note: 'This is an automated confirmation of your application. There is no need to reply to this email.',
                highlight: ['label' => 'Position Applied For', 'value' => $role],
            ));
        } catch (\Throwable $e) {
            Log::warning('Career mail failed: '.$e->getMessage());
        }

        return redirect()->route('career.thank-you');
    }

    // ------------------------------------------------------------------
    private function adminEmail(string $key): string
    {
        return config("forms.$key") ?: config('mail.from.address');
    }

    private function messages(): array
    {
        return [
            'name.regex'       => 'Please enter a valid name (letters only).',
            'first_name.regex' => 'Please enter a valid first name (letters only).',
            'last_name.regex'  => 'Please enter a valid last name (letters only).',
            'email.email'      => 'Please enter a valid email address.',
            'phone.regex'      => 'Please enter a valid 10-digit phone number.',
            'contact_no.regex' => 'Please enter a valid 10-digit contact number.',
            'company.required' => 'Please enter your company.',
            'message.min'      => 'Please enter your message.',
            'resume.required'  => 'Please upload your resume.',
            'resume.mimes'     => 'Resume must be a PDF, DOC or DOCX file.',
            'resume.max'       => 'Resume is too large (max 3 MB).',
        ];
    }
}
