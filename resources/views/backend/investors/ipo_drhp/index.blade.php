<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>#basic-1 td{vertical-align:middle;}#basic-1 th,#basic-1 td{padding:12px;}</style>
</head>
<body>
    @include('components.backend.header')
    @include('components.backend.sidebar')
    <div class="page-body">
        <div class="container-fluid"><div class="page-title"><div class="row"><div class="col-6"></div>
            <div class="col-6"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li></ol></div>
        </div></div></div>
        <div class="container-fluid"><div class="row"><div class="col-sm-12"><div class="card"><div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">DRHP Disclaimer</li></ol></nav>
                @if($drhps->isEmpty())<a href="{{ route('manage-ipo-drhp.create') }}" class="btn btn-primary px-5 radius-30">+ Add DRHP Disclaimer</a>@endif
            </div>
            <div class="table-responsive custom-scrollbar"><table class="display" id="basic-1" style="width:100%">
                <thead><tr><th style="width:60px;">Sr No.</th><th>Page 1 Heading</th><th>Page 2 Heading</th><th style="width:120px;">DRHP PDF</th><th style="width:150px;">Actions</th></tr></thead>
                <tbody>
                @foreach($drhps as $key => $drhp)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $drhp->page1_heading }}</td>
                        <td>{{ $drhp->page2_heading }}</td>
                        <td>@if($drhp->pdf)<a href="{{ $drhp->pdf_url }}" target="_blank" class="btn btn-sm btn-outline-primary">View PDF</a>@endif</td>
                        <td><div class="d-flex gap-2">
                            <a href="{{ route('manage-ipo-drhp.edit', $drhp->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('manage-ipo-drhp.destroy', $drhp->id) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this DRHP disclaimer?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                        </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
        </div></div></div></div></div>
    </div>
    @include('components.backend.footer')
    @include('components.backend.main-js')
</body>
</html>
