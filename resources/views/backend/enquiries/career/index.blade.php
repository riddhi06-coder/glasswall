<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #ca-table td { vertical-align: middle; }
        #ca-table th, #ca-table td { padding: 12px; }
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
                                        <li class="breadcrumb-item active">Career Applications</li>
                                    </ol>
                                </nav>
                                <span class="badge bg-primary px-3 py-2">Total: {{ $applications->count() }}</span>
                            </div>

                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="ca-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th style="width:150px;">Actions</th>
                                            <th>Job Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $key => $a)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $a->first_name }} {{ $a->last_name }}</td>
                                                <td><a href="mailto:{{ $a->email }}">{{ $a->email }}</a></td>
                                                <td>{{ $a->contact_no }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('manage-career-applications.show', $a->id) }}" class="btn btn-sm btn-primary">View</a>
                                                        <form action="{{ route('manage-career-applications.destroy', $a->id) }}" method="POST" class="m-0"
                                                              onsubmit="return confirm('Delete this application?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>{{ $a->job_role ?: 'General Application' }}</td>
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
        $(function () {
            $('#ca-table').DataTable({
                pageLength: 15,
                lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, 'All']],
                ordering: false,                              // keep job-role order so grouping stays intact
                columnDefs: [{ visible: false, targets: 5 }], // hide the Job Role column (shown as group header)
                rowGroup: { dataSrc: 5 }                      // group by Job Role
            });
        });
    </script>
</body>
</html>
