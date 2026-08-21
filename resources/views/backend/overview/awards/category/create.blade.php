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
            <div class="col-6"><h4>Add Award Category</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-awards-category.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Award Category</li>
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
                <h4>Award Category Form</h4>
                <p class="f-m-light mt-1">Fill up the details and submit the form.</p>
              </div>
              <div class="card-body">
                <form class="row g-4 needs-validation custom-input" novalidate action="{{ route('manage-awards-category.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if($errors->any())
                    <div class="col-12">
                      <div class="alert alert-danger mb-0">
                        <ul class="mb-0">
                          @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                      </div>
                    </div>
                  @endif

                  <!-- Category Name -->
                  <div class="col-md-6">
                    <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter category name" required>
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1">A URL slug will be generated automatically from the name.</small>
                  </div>

                  <!-- Category Image -->
                  <div class="col-md-6">
                    <label class="form-label" for="image">Category Image <span class="text-danger">*</span></label>
                    <input class="form-control @error('image') is-invalid @enderror" id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required onchange="previewImage()">
                    @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB</small>
                    <div class="mt-2"><img id="image_preview" style="max-height:120px; display:none; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
                  </div>

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-awards-category.index') }}" class="btn btn-danger px-4">Cancel</a>
                    <button class="btn btn-primary" type="submit">Submit</button>
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
        function previewImage() {
            var input = document.getElementById('image');
            var preview = document.getElementById('image_preview');
            var file = input.files[0];
            preview.style.display = 'none';
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Image is too large. Maximum allowed is 2 MB.');
                input.value = '';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    </script>

</body>

</html>
