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
            <div class="col-6"><h4>Stock Exchange Page Settings</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Stock Exchange Page</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                  <h4>Banner &amp; Heading</h4>
                  <p class="f-m-light mt-1">Manage the top banner and the heading of the Stock Exchange page.</p>
                </div>
                <a href="{{ route('manage-stock-exchange-tabs.index') }}" class="btn btn-outline-primary">Manage Tabs &amp; Documents →</a>
              </div>
              <div class="card-body">
                <form class="row g-4" action="{{ route('manage-stock-exchange.update', $record->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <div class="col-md-6">
                    <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
                    <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', $record->banner_heading) }}" required>
                    @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="banner_image">Banner Image</label>
                    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.webp,.svg" onchange="previewBanner(event)">
                    <small class="text-secondary">Leave empty to keep the current image. Allowed: jpg, jpeg, webp, svg · Max 2 MB.</small>
                    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <div class="mt-2">
                      <img id="banner_preview" src="{{ $record->banner_image_url ?? '' }}" style="max-height:90px;border:1px solid #ddd;padding:4px;border-radius:6px;{{ $record->banner_image ? '' : 'display:none;' }}" alt="banner preview">
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label" for="page_heading">Page Heading</label>
                    <input class="form-control @error('page_heading') is-invalid @enderror" id="page_heading" type="text" name="page_heading" value="{{ old('page_heading', $record->page_heading) }}" placeholder="e.g. Financial Year 2026-2027">
                    @error('page_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-12 text-end mt-3">
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
        function previewBanner(e) {
            var file = e.target.files && e.target.files[0];
            if (!file) return;
            var img = document.getElementById('banner_preview');
            img.src = URL.createObjectURL(file);
            img.style.display = 'inline-block';
        }
    </script>
</body>
</html>
