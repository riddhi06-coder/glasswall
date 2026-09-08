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
                    <div class="col-6"><h4>Career Application</h4></div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('manage-career-applications.index') }}">Career Applications</a></li>
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
                            <h4 class="mb-0">{{ $application->first_name }} {{ $application->last_name }}</h4>
                            <a href="{{ route('manage-career-applications.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                        </div>
                        <div class="card-body">
                            <table class="table enq-table mb-0">
                                <tr><th>Position Applied For</th><td>{{ $application->job_role }}</td></tr>
                                <tr><th>Name</th><td>{{ $application->first_name }} {{ $application->last_name }}</td></tr>
                                <tr><th>Email</th><td><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></td></tr>
                                <tr><th>Contact No.</th><td>{{ $application->contact_no }}</td></tr>
                                <tr><th>Message</th><td style="white-space: pre-line;">{{ $application->message ?: '—' }}</td></tr>
                                <tr>
                                    <th>Resume</th>
                                    <td>
                                        @if($application->resume_url)
                                            <a href="{{ $application->resume_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Download {{ $application->resume_name }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                                <tr><th>Submitted</th><td>{{ $application->created_at?->format('d M Y, h:i A') }}</td></tr>
                                <tr><th>IP Address</th><td>{{ $application->ip_address ?: '—' }}</td></tr>
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
