<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 th, #basic-1 td { padding: 14px 12px; vertical-align: middle; }
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
                                        <li class="breadcrumb-item"><a href="{{ route('manage-stock-exchange.index') }}">Stock Exchange Page</a></li>
                                        <li class="breadcrumb-item active">Tabs &amp; Documents</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-stock-exchange-tabs.create') }}" class="btn btn-primary px-5 radius-30">+ Add Tab</a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th style="width:70px;">#</th>
                                            <th>Tab Label</th>
                                            <th style="width:130px;">Documents</th>
                                            <th style="width:90px;">Status</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($records as $tab)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $tab->label }}</strong></td>
                                                <td>{{ $tab->items_count }} document(s)</td>
                                                <td>
                                                    @if($tab->is_active)<span class="badge badge-light-success">Active</span>
                                                    @else<span class="badge badge-light-danger">Inactive</span>@endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('manage-stock-exchange-tabs.edit', $tab->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('manage-stock-exchange-tabs.destroy', $tab->id) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this tab and its documents?')">
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
