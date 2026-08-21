<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.3.0/apexcharts.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.3.0/apexcharts.min.js"></script>
    <style>
        .dash-stat { display:flex; align-items:center; justify-content:space-between; gap:12px;
            background:#fff; border:1px solid #eceff3; border-radius:12px; padding:18px 20px; height:100%; }
        .dash-stat__num { font-size:28px; font-weight:700; line-height:1; color:#111827; }
        .dash-stat__label { font-size:13px; color:#6b7280; margin-top:6px; }
        .dash-stat__icon { width:50px; height:50px; border-radius:12px; display:flex; align-items:center;
            justify-content:center; font-size:20px; flex:0 0 50px; }
        .dash-stat--primary { border-left:4px solid #4f46e5; }
        .dash-stat--primary .dash-stat__icon { background:#e0e7ff; color:#4f46e5; }
        .dash-stat--info { border-left:4px solid #0284c7; }
        .dash-stat--info .dash-stat__icon { background:#e0f2fe; color:#0284c7; }
        .dash-stat--warning { border-left:4px solid #d97706; }
        .dash-stat--warning .dash-stat__icon { background:#fef3c7; color:#d97706; }
        .dash-stat--success { border-left:4px solid #16a34a; }
        .dash-stat--success .dash-stat__icon { background:#dcfce7; color:#16a34a; }

        .dash-list-item { display:flex; align-items:center; justify-content:space-between; gap:10px;
            padding:12px 0; border-bottom:1px solid #f1f3f5; }
        .dash-list-item:last-child { border-bottom:0; }
        .dash-list-item__title { font-weight:600; color:#1f2937; font-size:14px; }
        .dash-list-item__sub { font-size:12px; color:#6b7280; }
        .dash-empty { color:#9ca3af; text-align:center; padding:26px 0; font-size:14px; }
        .dash-status-dot { width:10px; height:10px; border-radius:50%; display:inline-block; margin-right:8px; flex:0 0 10px; }

        .dash-table { margin-bottom:0; }
        .dash-table th, .dash-table td { padding:14px 16px !important; vertical-align:middle; white-space:nowrap; }
        .dash-table thead th { background:#f8fafc; color:#475569; font-weight:600; font-size:13px; }

        .dash-chip { display:inline-block; padding:4px 11px; border-radius:20px; background:#eef2ff;
            color:#3730a3 !important; font-size:12px; font-weight:600; border:1px solid #e0e7ff; line-height:1.4; }

        .dash-highlight-header { background:#eef2ff; border-bottom:1px solid #e0e7ff !important; padding:14px 18px; }
        .dash-highlight-header h5 { color:#3730a3 !important; font-weight:700; }
    </style>
</head>
<body>
    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mb-1">Dashboard</h4>
                        <p class="mb-0 text-muted">{{ $today->format('l, d M Y') }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <a href="{{ route('manage-project-listing.index') }}" class="btn btn-primary btn-sm">View All Projects</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            {{-- ===== Stat cards ===== --}}
            @php
                $cards = [
                    ['label' => "Total Projects",   'value' => $stats['projects'],       'icon' => 'fa-th-large',    'tone' => 'primary'],
                    ['label' => "Categories",       'value' => $stats['categories'],     'icon' => 'fa-tags',        'tone' => 'info'],
                    ['label' => "Project Details",  'value' => $stats['projectDetails'], 'icon' => 'fa-file-text-o', 'tone' => 'success'],
                    ['label' => "Shown on Home",    'value' => $stats['showOnHome'],     'icon' => 'fa-home',        'tone' => 'warning'],
                    ['label' => "Home Banners",     'value' => $stats['banners'],        'icon' => 'fa-picture-o',   'tone' => 'info'],
                    ['label' => "Blogs",            'value' => $stats['blogs'],          'icon' => 'fa-pencil',      'tone' => 'primary'],
                    ['label' => "Users",            'value' => $stats['users'],          'icon' => 'fa-users',       'tone' => 'success'],
                    ['label' => "Activity Logs",    'value' => $stats['activities'],     'icon' => 'fa-history',     'tone' => 'warning'],
                ];
            @endphp
            <div class="row g-3 mb-1">
                @foreach($cards as $c)
                    <div class="col-xl-3 col-sm-6">
                        <div class="dash-stat dash-stat--{{ $c['tone'] }}">
                            <div>
                                <div class="dash-stat__num">{{ $c['value'] }}</div>
                                <div class="dash-stat__label">{{ $c['label'] }}</div>
                            </div>
                            <div class="dash-stat__icon"><i class="fa {{ $c['icon'] }}"></i></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row g-3 mt-1 mb-4">

                {{-- ===== Recent activity ===== --}}
                <div class="col-xl-8">
                    <div class="card h-100">
                        <div class="card-header dash-highlight-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Activity</h5>
                            <a href="{{ route('admin.activity-logs.index') }}" class="dash-chip" style="text-decoration:none;">View all</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive custom-scrollbar">
                                <table class="table table-hover dash-table">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Event</th>
                                            <th>Module</th>
                                            <th>Description</th>
                                            <th class="text-end">When</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentActivities as $log)
                                            <tr>
                                                <td>{{ $log->user_name ?? '—' }}</td>
                                                <td><span class="badge {{ $log->eventBadgeClass() }}">{{ ucfirst($log->event) }}</span></td>
                                                <td>{{ $log->module ?? '—' }}</td>
                                                <td class="text-muted">{{ \Illuminate\Support\Str::limit($log->description, 40) ?: '—' }}</td>
                                                <td class="text-end text-muted">{{ optional($log->created_at)->diffForHumans() }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="dash-empty">No activity recorded yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Projects by category ===== --}}
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Projects by Category</h5>
                            <span class="dash-chip">{{ $stats['activeProjects'] }} active</span>
                        </div>
                        <div class="card-body">
                            @if($stats['projects'] > 0)
                                <div id="categoryChart"></div>
                            @endif
                            <ul class="list-unstyled mb-0 mt-2">
                                @php $palette = ['#4f46e5','#0284c7','#16a34a','#d97706','#db2777','#0891b2']; @endphp
                                @forelse($projectsByCategory as $i => $cat)
                                    <li class="dash-list-item">
                                        <span><span class="dash-status-dot" style="background:{{ $palette[$i % count($palette)] }};"></span>{{ $cat->name }}</span>
                                        <span class="badge bg-light text-dark">{{ $cat->listings_count }}</span>
                                    </li>
                                @empty
                                    <li class="dash-empty">No categories yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @include('components.backend.footer')
    @include('components.backend.main-js')

    @if($stats['projects'] > 0)
    <script>
        (function () {
            var el = document.querySelector('#categoryChart');
            if (!el || typeof ApexCharts === 'undefined') return;

            new ApexCharts(el, {
                chart:   { type: 'donut', height: 250 },
                labels:  @json($projectsByCategory->pluck('name')),
                series:  @json($projectsByCategory->pluck('listings_count')->map(fn ($n) => (int) $n)),
                colors:  ['#4f46e5', '#0284c7', '#16a34a', '#d97706', '#db2777', '#0891b2'],
                legend:  { show: false },
                dataLabels: { enabled: false },
                stroke:  { width: 2 },
                tooltip: { y: { formatter: function (v) { return v + ' project(s)'; } } }
            }).render();
        })();
    </script>
    @endif
</body>
</html>
