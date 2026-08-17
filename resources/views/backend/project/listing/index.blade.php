<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #prj-table td { vertical-align: middle; }
        #prj-table th, #prj-table td { padding: 12px; }
        .prj-thumb {
            height: 70px; width: 105px; object-fit: cover;
            border: 1px solid #e6e8f0; border-radius: 8px;
        }
        .prj-filter {
            background: #f7f8fc;
            border: 1px solid #eef0f6;
            border-radius: 8px;
            padding: 16px;
        }
        tr.dtrg-group td {
            background: #eef1f6 !important;
            color: #2f2f3b;
            font-weight: 700;
            letter-spacing: .3px;
            font-size: 14px;
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

                            {{-- Filters (instant, no reload — wired into DataTables) --}}
                            <div class="prj-filter mb-4">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label mb-1">Category</label>
                                        <select id="f-category" class="form-control">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label mb-1">Status</label>
                                        <select id="f-status" class="form-control">
                                            <option value="all">All</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="f-reset" class="btn btn-outline-secondary px-4">Reset Filters</button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="prj-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th>Thumbnail</th>
                                            <th>Project Name</th>
                                            <th>Category</th>
                                            <th>Location</th>
                                            <th style="width:80px;">Priority</th>
                                            <th style="width:90px;">Status</th>
                                            <th style="width:110px;">Show on Home</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($listings as $key => $listing)
                                            <tr data-category="{{ $listing->project_category_id }}" data-status="{{ $listing->is_active ? '1' : '0' }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td><img class="prj-thumb" src="{{ asset('project/listings/'.$listing->thumbnail) }}" alt="thumbnail"></td>
                                                <td>{{ $listing->name }}</td>
                                                <td>{{ optional($listing->category)->name ?? '—' }}</td>
                                                <td>{{ $listing->location ?: '—' }}</td>
                                                <td>{{ $listing->priority }}</td>
                                                <td>
                                                    @if($listing->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch d-inline-block m-0">
                                                        <input class="form-check-input home-toggle" type="checkbox" role="switch"
                                                               data-id="{{ $listing->id }}" style="cursor:pointer;"
                                                               {{ $listing->show_on_home ? 'checked' : '' }}>
                                                    </div>
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

    {{-- RowGroup extension (compatible with the theme's DataTables 1.10.16) --}}
    <script src="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>
    <script>
        (function () {
            // Custom category/status filter — reads the data-attrs on each row.
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                if (settings.nTable.id !== 'prj-table') return true;
                var row = settings.aoData[dataIndex].nTr;
                var c  = document.getElementById('f-category').value;
                var st = document.getElementById('f-status').value;
                if (c && row.getAttribute('data-category') !== c) return false;
                if (st !== 'all' && row.getAttribute('data-status') !== st) return false;
                return true;
            });

            $(function () {
                var table = $('#prj-table').DataTable({
                    pageLength: 15,
                    lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, 'All']],
                    ordering: false,                       // keep category order so grouping stays intact
                    columnDefs: [{ visible: false, targets: 3 }],  // hide the Category column (shown as group header)
                    rowGroup: { dataSrc: 3 }               // group by Category
                });

                $('#f-category, #f-status').on('change', function () { table.draw(); });
                $('#f-reset').on('click', function () {
                    $('#f-category').val('');
                    $('#f-status').val('all');
                    table.search('').draw();
                });

                // "Show on Home" toggle — AJAX, no reload. Delegated so it works across paginated pages.
                $(document).on('change', '.home-toggle', function () {
                    var el = $(this), id = el.data('id');
                    el.prop('disabled', true);
                    function toast(msg) {
                        $.notify('<i class="fa fa-bell-o"></i><strong>' + msg + '</strong>', {
                            type: "theme",
                            allow_dismiss: true,
                            delay: 5000,
                            showProgressbar: true,
                            timer: 300,
                            animate: { enter: "animated fadeInDown", exit: "animated fadeOutUp" }
                        });
                    }
                    $.ajax({
                        url: '{{ url('manage-project-listing') }}/' + id + '/toggle-home',
                        method: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (r) {
                            el.prop('disabled', false);
                            toast(r.show_on_home ? 'Project will now show on the home page.' : 'Project removed from the home page.');
                        },
                        error: function () {
                            el.prop('checked', !el.prop('checked')).prop('disabled', false);
                            toast('Could not update. Please try again.');
                        }
                    });
                });
            });
        })();
    </script>
</body>
</html>
