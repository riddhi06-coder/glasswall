<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: top; }
        #basic-1 th, #basic-1 td { padding: 14px 12px; }
        .api-cell { max-width: 460px; word-break: break-all; font-size: 13px; }
    </style>
</head>
<body>
    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg>
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item active">Blog Section</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('home-blog-details.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Blog Section
                                </a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th>Section Heading</th>
                                            <th>API Link</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($blogs as $key => $blog)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $blog->section_heading }}</td>
                                                <td><div class="api-cell"><a href="{{ $blog->api_link }}" target="_blank" rel="noopener">{{ $blog->api_link }}</a></div></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('home-blog-details.edit', $blog->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('home-blog-details.destroy', $blog->id) }}"
                                                              method="POST" class="m-0"
                                                              onsubmit="return confirm('Are you sure you want to delete this blog section?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted py-4">No blog sections added yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.backend.footer')
    @include('components.backend.main-js')
</body>
</html>
