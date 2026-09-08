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
                    <div class="col-6"><h4>Edit {{ $page->heading }}</h4></div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('manage-legal-pages.index') }}">Legal Pages</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $page->heading }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="row g-4 custom-input" action="{{ route('manage-legal-pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @if($errors->any())
                                    <div class="col-12"><div class="alert alert-danger mb-0"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                                @endif

                                <div class="col-md-8">
                                    <label class="form-label" for="heading">Banner Heading <span class="text-danger">*</span></label>
                                    <input class="form-control @error('heading') is-invalid @enderror" id="heading" type="text" name="heading" value="{{ old('heading', $page->heading) }}" required>
                                    @error('heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="banner_image">Banner Image</label>
                                    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept="image/*">
                                    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB @if($page->banner_image) &nbsp;|&nbsp; Leave empty to keep current.@endif</small>
                                    @if($page->banner_image)
                                        <img src="{{ $page->banner_image_url }}" alt="current banner" style="height:80px;margin-top:10px;border:1px solid #e6e8f0;border-radius:8px;object-fit:cover;">
                                    @endif
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="content">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control editor @error('content') is-invalid @enderror" id="content" name="content" rows="18">{{ old('content', $page->content) }}</textarea>
                                    @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 text-end mt-3">
                                    <a href="{{ route('manage-legal-pages.index') }}" class="btn btn-danger px-4">Cancel</a>
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.backend.footer')
    @include('components.backend.main-js')
    <script>
        document.querySelectorAll('textarea.editor').forEach(function (el) {
            ClassicEditor.create(el).catch(function (e) { console.error(e); });
        });
    </script>
</body>
</html>
