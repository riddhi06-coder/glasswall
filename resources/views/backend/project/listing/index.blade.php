<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        .prj-table { width: 100%; border-collapse: collapse; }
        .prj-table th, .prj-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            vertical-align: middle;
        }
        .prj-table thead th {
            background: #f7f8fc;
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #6b7280;
            white-space: nowrap;
        }
        .prj-table tbody tr:hover td { background: #fafbfe; }
        .prj-thumb {
            height: 80px; width: 120px; object-fit: cover;
            border: 1px solid #e6e8f0; border-radius: 8px;
        }
        .cat-group-row td {
            background: #eef1f6;
            color: #2f2f3b;
            font-weight: 700;
            letter-spacing: .3px;
            font-size: 14px;
        }
        .cat-group-row .cat-count {
            background: #dfe3ea;
            color: #3a3f47;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }
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
                                        <li class="breadcrumb-item active">Project Listing</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-project-listing.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Project
                                </a>
                            </div>

                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <div class="table-responsive custom-scrollbar">
                                <table class="prj-table">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th style="width:140px;">Thumbnail</th>
                                            <th>Project Name</th>
                                            <th>Location</th>
                                            <th style="width:80px;">Priority</th>
                                            <th style="width:90px;">Status</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $sr = 0; @endphp
                                        @forelse($listings->groupBy(fn ($l) => optional($l->category)->name ?? 'Uncategorized') as $catName => $group)
                                            <tr class="cat-group-row">
                                                <td colspan="7">
                                                    {{ $catName }}
                                                    <span class="cat-count">{{ $group->count() }}</span>
                                                </td>
                                            </tr>
                                            @foreach($group as $listing)
                                                @php $sr++; @endphp
                                                <tr>
                                                    <td>{{ $sr }}</td>
                                                    <td><img class="prj-thumb" src="{{ asset('project/listings/'.$listing->thumbnail) }}" alt="thumbnail"></td>
                                                    <td>{{ $listing->name }}</td>
                                                    <td>{{ $listing->location }}</td>
                                                    <td>{{ $listing->priority }}</td>
                                                    <td>
                                                        @if($listing->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('manage-project-listing.edit', $listing->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                            <form action="{{ route('manage-project-listing.destroy', $listing->id) }}"
                                                                  method="POST" class="m-0"
                                                                  onsubmit="return confirm('Are you sure you want to delete this project?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr><td colspan="7" class="text-center text-muted py-4">No projects added yet.</td></tr>
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
