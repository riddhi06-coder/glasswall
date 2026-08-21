<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: top; }
        #basic-1 th, #basic-1 td { padding: 14px 12px; }

        .about-desc-cell {
            font-size: 14px;
            line-height: 1.55;
            color: #4a4f57;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ms-wrap { display: flex; flex-wrap: wrap; gap: 8px; }
        .ms-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f6f7fb;
            border: 1px solid #e6e8f0;
            border-radius: 22px;
            padding: 6px 14px;
            font-size: 12.5px;
            line-height: 1.3;
            letter-spacing: normal;
            color: #3a3f47;
        }
        .ms-chip img { height: 18px; width: 18px; object-fit: contain; flex: 0 0 auto; }
        .ms-chip b { color: #1a4685; font-weight: 700; }
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
                                        <li class="breadcrumb-item active">About Us Details</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('manage-about-us.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add About Us Details
                                </a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th style="width:300px;">Description</th>
                                            <th>Milestones</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
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
