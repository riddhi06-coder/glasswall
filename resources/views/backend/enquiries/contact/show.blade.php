<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        .enq-table th { width: 200px; color: #6b7280; font-weight: 600; vertical-align: top; }
        .enq-table td, .enq-table th { padding: 12px 14px; border-bottom: 1px solid #eef0f4; }
    </style>
</head>
<body>
    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6"><h4>Contact Enquiry</h4></div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('manage-contact-enquiries.index') }}">Contact Enquiries</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Enquiry from {{ $submission->name }}</h4>
                            <a href="{{ route('manage-contact-enquiries.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                        </div>
                        <div class="card-body">
                            <table class="table enq-table mb-0">
                                <tr><th>Name</th><td>{{ $submission->name }}</td></tr>
                                <tr><th>Email</th><td><a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></td></tr>
                                <tr><th>Company</th><td>{{ $submission->company ?: '—' }}</td></tr>
                                <tr><th>Phone</th><td>{{ $submission->phone }}</td></tr>
                                <tr><th>Message</th><td style="white-space: pre-line;">{{ $submission->message }}</td></tr>
                                <tr><th>Submitted</th><td>{{ $submission->created_at?->format('d M Y, h:i A') }}</td></tr>
                                <tr><th>IP Address</th><td>{{ $submission->ip_address ?: '—' }}</td></tr>
                            </table>
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
