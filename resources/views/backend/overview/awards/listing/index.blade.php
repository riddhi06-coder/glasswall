<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: middle; }
        #basic-1 th, #basic-1 td { padding: 12px; }
        .aw-thumb { height: 80px; width: 110px; object-fit: contain; background:#fff; padding:6px; border: 1px solid #e6e8f0; border-radius: 8px; }
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
                                        <li class="breadcrumb-item active">Awards &amp; Recognition</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-awards-recognition.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Award
                                </a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th style="width:130px;">Thumbnail</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Subject</th>
                                            <th style="width:80px;">Year</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($awards as $key => $award)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img class="aw-thumb" src="{{ $award->assetUrl($award->thumbnail_image) }}" alt="{{ $award->title }}"></td>
                                                <td>{{ $award->title }}</td>
                                                <td>{{ optional($award->category)->name ?? '—' }}</td>
                                                <td>{{ $award->subject }}</td>
                                                <td>{{ $award->year }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('manage-awards-recognition.edit', $award->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('manage-awards-recognition.destroy', $award->id) }}" method="POST" class="m-0"
                                                              onsubmit="return confirm('Are you sure you want to delete this award?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center text-muted py-4">No awards added yet.</td></tr>
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
