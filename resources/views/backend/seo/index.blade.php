<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: top; }
        #basic-1 th, #basic-1 td { padding: 14px 12px; }
        .url-cell { max-width: 280px; word-break: break-all; font-size: 13px; }
        .title-cell { max-width: 420px; font-size: 13px; }
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
                                        <li class="breadcrumb-item active">SEO Manager</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-seo.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add SEO Entry
                                </a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th>Page Name</th>
                                            <th>URL Path</th>
                                            <th>Meta Title</th>
                                            <th style="width:90px;">Status</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($records as $key => $seo)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><strong>{{ $seo->page_name }}</strong></td>
                                                <td><div class="url-cell">{{ $seo->url_path }}</div></td>
                                                <td><div class="title-cell">{{ $seo->meta_title }}</div></td>
                                                <td>
                                                    @if($seo->is_active)
                                                        <span class="badge badge-light-success">Active</span>
                                                    @else
                                                        <span class="badge badge-light-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('manage-seo.edit', $seo->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('manage-seo.destroy', $seo->id) }}"
                                                              method="POST" class="m-0"
                                                              onsubmit="return confirm('Delete the SEO entry for {{ $seo->url_path }}?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
