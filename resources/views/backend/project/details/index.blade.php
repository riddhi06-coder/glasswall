<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: middle; }
        #basic-1 th, #basic-1 td { padding: 12px; }
        .pd-thumb {
            height: 60px; width: 90px; object-fit: cover;
            border: 1px solid #e6e8f0; border-radius: 8px;
        }
        .scope-wrap { display: flex; flex-wrap: wrap; gap: 6px; }
        .scope-chip {
            background: #f6f7fb; border: 1px solid #e6e8f0; border-radius: 22px;
            padding: 4px 12px; font-size: 12px; color: #3a3f47;
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
                                        <li class="breadcrumb-item active">Project Details</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-project-details.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Project Details
                                </a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th style="width:110px;">Image</th>
                                            <th>Project</th>
                                            <th>Client</th>
                                            <th>Architect</th>
                                            <th>Scope of Work</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($details as $key => $detail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img class="pd-thumb" src="{{ $detail->image_url }}" alt="image"></td>
                                                <td>
                                                    {{ optional($detail->listing)->name ?? '—' }}
                                                    <div class="text-secondary small">{{ optional(optional($detail->listing)->category)->name }}</div>
                                                </td>
                                                <td>{{ $detail->client }}</td>
                                                <td>{{ $detail->architect }}</td>
                                                <td>
                                                    <div class="scope-wrap">
                                                        @foreach(($detail->scope_of_work ?? []) as $scope)
                                                            <span class="scope-chip">{{ $scope }}</span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('manage-project-details.edit', $detail->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('manage-project-details.destroy', $detail->id) }}"
                                                              method="POST" class="m-0"
                                                              onsubmit="return confirm('Are you sure you want to delete these details?')">
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
