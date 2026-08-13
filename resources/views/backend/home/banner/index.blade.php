<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        /* Banner heading is CKEditor rich-text; keep it readable in the list
           instead of rendering giant <h1>/<h2> blocks. */
        .banner-heading-cell {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
            max-width: 460px;
            color: #2f2f3b;
        }
        .banner-heading-cell h1,
        .banner-heading-cell h2,
        .banner-heading-cell h3,
        .banner-heading-cell h4,
        .banner-heading-cell h5,
        .banner-heading-cell h6,
        .banner-heading-cell p {
            font-size: inherit;
            font-weight: inherit;
            line-height: inherit;
            margin: 0;
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
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg>
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
                                        <li class="breadcrumb-item active"> Banner Details</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('banner-details.create') }}" class="btn btn-primary px-5 radius-30">
                                    + Add Banner Details
                                </a>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>    
                                            <th>Sr No.</th>
                                            <th>Heading</th>
                                            <th>Banner</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($banners as $key => $banner)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><div class="banner-heading-cell">{!! $banner->banner_heading !!}</div></td>
                                                <td>
                                                    @if($banner->media_type === 'image')
                                                        <img src="{{ asset('home/bannerimagevideo/'.$banner->banner_media) }}"
                                                             style="max-height: 120px;" class="img-fluid rounded" alt="banner">
                                                    @else
                                                        <video muted autoplay loop style="max-height:120px;">
                                                            <source src="{{ asset('home/bannerimagevideo/'.$banner->banner_media) }}">
                                                        </video>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('banner-details.edit', $banner->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('banner-details.destroy', $banner->id) }}"
                                                              method="POST" class="m-0"
                                                              onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-4">No banners added yet.</td></tr>
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