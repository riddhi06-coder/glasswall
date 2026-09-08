<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
</head>

    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Edit Investor Resource</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-investor-resource.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Investor Resource</li>
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
                <h4>Investor Resource Form</h4>
                <p class="f-m-light mt-1">Fill up the details and submit the form.</p>
              </div>
              <div class="card-body">
                <form class="row g-4 needs-validation custom-input" novalidate action="{{ route('manage-investor-resource.update', $resource->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  @if($errors->any())
                    <div class="col-12">
                      <div class="alert alert-danger mb-0">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                      </div>
                    </div>
                  @endif

                  <div class="col-md-6">
                    <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
                    <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', $resource->banner_heading) }}" placeholder="e.g. Investor Resources" required>
                    @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
                    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewImage(this,'banner_preview')">
                    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB</small>
                    <div class="mt-2"><img id="banner_preview" src="{{ $resource->banner_image_url ?? $resource->assetUrl($resource->banner_image) }}" style="max-height:110px; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name', $resource->name) }}" placeholder="e.g. Sagar Lambole" required>
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="designation">Designation <span class="text-danger">*</span></label>
                    <input class="form-control @error('designation') is-invalid @enderror" id="designation" type="text" name="designation" value="{{ old('designation', $resource->designation) }}" placeholder="e.g. Company Secretary – Compliance and Legal" required>
                    @error('designation')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                    <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" value="{{ old('phone', $resource->phone) }}" placeholder="e.g. +91 22 6103 3456" required>
                    @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email', $resource->email) }}" placeholder="e.g. compliance@glasswallsystem.com" required>
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="company_name">Company Name <span class="text-danger">*</span></label>
                    <input class="form-control @error('company_name') is-invalid @enderror" id="company_name" type="text" name="company_name" value="{{ old('company_name', $resource->company_name) }}" placeholder="e.g. Glass Wall Systems (India) Limited" required>
                    @error('company_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Enter address" required>{{ old('address', $resource->address) }}</textarea>
                    @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-investor-resource.index') }}" class="btn btn-danger px-4">Cancel</a>
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
        function previewImage(input, previewId) {
            var preview = document.getElementById(previewId);
            var file = input.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) { alert('Image is too large. Maximum allowed is 2 MB.'); input.value=''; return; }
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    </script>

</body>

</html>
