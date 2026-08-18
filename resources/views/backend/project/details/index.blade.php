<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: middle; }
        #basic-1 th, #basic-1 td { padding: 12px; }
        .pd-thumb {
            height: 90px; width: 140px; object-fit: cover;
            border: 1px solid #e6e8f0; border-radius: 8px;
        }
        .scope-wrap { display: flex; flex-wrap: wrap; gap: 6px; }
        .scope-chip {
            background: #f6f7fb; border: 1px solid #e6e8f0; border-radius: 22px;
            padding: 4px 12px; font-size: 12px; color: #3a3f47;
        }
        .pd-filter {
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
                                        <li class="breadcrumb-item active">Project Details</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-project-details.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Project Details
                                </a>
                            </div>

                            {{-- Filters (instant, no reload — wired into DataTables) --}}
                            <div class="pd-filter mb-4">
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
                                        <button type="button" id="f-reset" class="btn btn-outline-secondary px-4">Reset Filters</button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="pd-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th style="width:150px;">Image</th>
                                            <th>Project</th>
                                            <th>Category</th>
                                            <th>Client</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($details as $key => $detail)
                                            <tr data-category="{{ optional($detail->listing)->project_category_id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td><img class="pd-thumb" src="{{ $detail->image_url }}" alt="image"></td>
                                                <td>{{ optional($detail->listing)->name ?? '—' }}</td>
                                                <td>{{ optional(optional($detail->listing)->category)->name ?? 'Uncategorized' }}</td>
                                                <td>{{ $detail->client }}</td>
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

    {{-- RowGroup extension (compatible with the theme's DataTables 1.10.16) --}}
    <script src="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>
    <script>
        // Custom category filter — reads the data-category attr on each row.
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'pd-table') return true;
            var row = settings.aoData[dataIndex].nTr;
            var c = document.getElementById('f-category').value;
            if (c && row.getAttribute('data-category') !== c) return false;
            return true;
        });

        $(function () {
            var table = $('#pd-table').DataTable({
                pageLength: 15,
                lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, 'All']],
                ordering: false,                              // keep category order so grouping stays intact
                columnDefs: [{ visible: false, targets: 3 }], // hide the Category column (shown as group header)
                rowGroup: { dataSrc: 3 }                       // group by Category
            });

            $('#f-category').on('change', function () { table.draw(); });
            $('#f-reset').on('click', function () {
                $('#f-category').val('');
                table.search('').draw();
            });
        });
    </script>
</body>
</html>
