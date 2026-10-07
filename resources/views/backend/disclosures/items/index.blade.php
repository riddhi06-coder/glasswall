<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: top; }
        #basic-1 th, #basic-1 td { padding: 14px 12px; }
        .title-cell { max-width: 520px; font-size: 13px; }
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
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
                                        <li class="breadcrumb-item"><a href="{{ route('manage-disclosures.index') }}">Disclosures Page</a></li>
                                        <li class="breadcrumb-item active">Disclosure Items</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-disclosure-items.create') }}" class="btn btn-primary px-5 radius-30">+ Add Disclosure Item</a>
                            </div>

                            @if(session('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th style="width:70px;">No.</th>
                                            <th>Title</th>
                                            <th style="width:110px;">Type</th>
                                            <th style="width:90px;">Items</th>
                                            <th style="width:80px;">Status</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($records as $row)
                                            <tr>
                                                <td>{{ $row->number }}</td>
                                                <td><div class="title-cell">{{ \Illuminate\Support\Str::limit(trim(strip_tags($row->title)), 140) }}</div></td>
                                                <td>
                                                    @php
                                                        $badge = ['links' => 'badge-light-primary', 'financial' => 'badge-light-warning', 'tabs' => 'badge-light-info'][$row->type] ?? 'badge-light-secondary';
                                                    @endphp
                                                    <span class="badge {{ $badge }}">{{ ucfirst($row->type) }}</span>
                                                </td>
                                                <td>{{ $row->type === 'tabs' ? $row->tabs_count.' tabs' : $row->links_count.' links' }}</td>
                                                <td>
                                                    @if($row->is_active)<span class="badge badge-light-success">Active</span>
                                                    @else<span class="badge badge-light-danger">Inactive</span>@endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('manage-disclosure-items.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('manage-disclosure-items.destroy', $row->id) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this disclosure item?')">
                                                            @csrf @method('DELETE')
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
