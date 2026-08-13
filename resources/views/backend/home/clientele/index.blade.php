<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        #basic-1 td { vertical-align: top; }
        #basic-1 th, #basic-1 td { padding: 14px 12px; }
        .cl-desc-cell {
            font-size: 14px; line-height: 1.55; color: #4a4f57; max-width: 320px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .cl-logos { display: flex; flex-wrap: wrap; gap: 8px; max-width: 360px; }
        .cl-logos img {
            height: 40px; width: auto; max-width: 90px; object-fit: contain;
            border: 1px solid #e6e8f0; border-radius: 6px; padding: 3px; background: #fff;
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
                                        <li class="breadcrumb-item active">Clientele</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('home-clientele.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Clientele
                                </a>
                            </div>
                            
                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sr No.</th>
                                            <th style="width:200px;">Clientele Heading</th>
                                            <th>Description</th>
                                            <th>Client Logos</th>
                                            <th style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($clienteles as $key => $c)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $c->clientele_section_heading }}</td>
                                                <td><div class="cl-desc-cell">{{ strip_tags($c->clientele_section_desc) }}</div></td>
                                                <td>
                                                    <div class="cl-logos">
                                                        @forelse($c->images as $img)
                                                            <img src="{{ asset('home/clienteleimages/'.$img->image) }}" alt="client">
                                                        @empty
                                                            <span class="text-muted">—</span>
                                                        @endforelse
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('home-clientele.edit', $c->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('home-clientele.destroy', $c->id) }}"
                                                              method="POST" class="m-0"
                                                              onsubmit="return confirm('Are you sure you want to delete this clientele section?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-4">No clientele sections added yet.</td></tr>
                                        @endforelse
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
