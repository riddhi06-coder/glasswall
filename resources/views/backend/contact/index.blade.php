<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: top; }
        #basic-1 th, #basic-1 td { padding: 14px 12px; }
        .contact-addr {
            font-size: 13.5px; line-height: 1.5; color: #4a4f57;
            max-width: 340px;
        }
        .contact-addr p { margin: 0 0 4px; }
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
                                        <li class="breadcrumb-item active">Contact Details</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-contact-details.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Contact Details
                                </a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th>Email 1</th>
                                            <th>Email 2</th>
                                            <th>Phone No.</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contacts as $key => $contact)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $contact->email_1 }}</td>
                                                <td>{{ $contact->email_2 }}</td>
                                                <td>{{ $contact->phone }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('manage-contact-details.edit', $contact->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('manage-contact-details.destroy', $contact->id) }}"
                                                              method="POST" class="m-0"
                                                              onsubmit="return confirm('Are you sure you want to delete these contact details?')">
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
