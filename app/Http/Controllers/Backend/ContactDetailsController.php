<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactDetailsController extends Controller
{
    /** Banner image upload directory under /public. */
    private const IMG_DIR = 'contact';

    public function index()
    {
        $contacts = ContactDetail::latest()->get();

        return view('backend.contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('backend.contact.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $validated['banner_image'] = $this->storeImage($request->file('banner_image'));
        $validated['created_by']   = Auth::id();
        ContactDetail::create($validated);

        return redirect()->route('manage-contact-details.index')->with('message', 'Contact details added successfully.');
    }

    public function edit($id)
    {
        $contact = ContactDetail::findOrFail($id);

        return view('backend.contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = ContactDetail::findOrFail($id);

        $validated = $request->validate($this->rules($contact->id), $this->messages());

        if ($request->hasFile('banner_image')) {
            $this->deleteImage($contact->banner_image);
            $validated['banner_image'] = $this->storeImage($request->file('banner_image'));
        }

        $validated['updated_by'] = Auth::id();
        $contact->update($validated);

        return redirect()->route('manage-contact-details.index')->with('message', 'Contact details updated successfully.');
    }

    public function destroy($id)
    {
        $contact = ContactDetail::findOrFail($id);
        $this->deleteImage($contact->banner_image);
        $contact->delete();

        return redirect()->route('manage-contact-details.index')->with('message', 'Contact details deleted successfully.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    private function rules(?int $ignoreId = null): array
    {
        return [
            'banner_heading' => 'required|string|max:255',
            'banner_image'   => ($ignoreId ? 'nullable' : 'required').'|file|mimes:jpg,jpeg,png,webp|max:2048',
            'email_1'    => 'required|email|max:255',
            'email_2'    => 'required|email|max:255',
            'phone'      => 'required|string|max:50',
            'address'    => 'required|string',
            'map_url'    => 'required|string|max:2000',
            'iframe_url' => 'required|string|max:2000',
        ];
    }

    private function messages(): array
    {
        return [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_image.required'   => 'The banner image is required.',
            'banner_image.mimes'      => 'Banner image must be jpg, jpeg, png or webp.',
            'banner_image.max'        => 'Banner image may not be larger than 2 MB.',
            'email_1.required'    => 'Email 1 is required.',
            'email_1.email'       => 'Email 1 must be a valid email address.',
            'email_2.required'    => 'Email 2 is required.',
            'email_2.email'       => 'Email 2 must be a valid email address.',
            'phone.required'      => 'The phone number is required.',
            'address.required'    => 'The address is required.',
            'map_url.required'    => 'The map URL is required.',
            'iframe_url.required' => 'The iframe URL is required.',
        ];
    }

    private function storeImage($file): string
    {
        $folder = public_path(self::IMG_DIR);
        if (! file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($folder, $fileName);

        return $fileName;
    }

    private function deleteImage(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path(self::IMG_DIR.'/'.$fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
