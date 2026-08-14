<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeBlogController extends Controller
{
    public function index()
    {
        $blogs = HomeBlog::latest()->get();

        return view('backend.home.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('backend.home.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        HomeBlog::create($validated + ['created_by' => Auth::id()]);

        return redirect()->route('home-blog-details.index')->with('message', 'Blog section added successfully.');
    }

    public function edit($id)
    {
        $blog = HomeBlog::findOrFail($id);

        return view('backend.home.blog.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = HomeBlog::findOrFail($id);

        $validated = $request->validate($this->rules(), $this->messages());

        $blog->update($validated + ['updated_by' => Auth::id()]);

        return redirect()->route('home-blog-details.index')->with('message', 'Blog section updated successfully.');
    }

    public function destroy($id)
    {
        $blog = HomeBlog::findOrFail($id);
        $blog->delete();

        return redirect()->route('home-blog-details.index')->with('message', 'Blog section deleted successfully.');
    }

    private function rules(): array
    {
        return [
            'section_heading' => 'required|string|max:255',
            'api_link'        => 'required|url|max:2000',
        ];
    }

    private function messages(): array
    {
        return [
            'section_heading.required' => 'The section heading is required.',
            'api_link.required'        => 'The API link is required.',
            'api_link.url'             => 'Please enter a valid URL (e.g. https://example.com/api/blogs).',
        ];
    }
}
