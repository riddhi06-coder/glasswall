<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
</head>
<body>
    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12">
                        <h4 class="mb-1">Dashboard</h4>
                        <p class="mb-0 text-muted">{{ $today->format('l, d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('components.backend.footer')
    @include('components.backend.main-js')
</body>
</html>
