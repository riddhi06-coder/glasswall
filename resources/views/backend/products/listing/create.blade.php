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
            <div class="col-6"><h4>Add Product</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-product-list.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Product</li>
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
                <h4>Product Form</h4>
                <p class="f-m-light mt-1">Fill up the details and submit the form.</p>
              </div>
              <div class="card-body">
                <form class="row g-4 needs-validation custom-input" novalidate action="{{ route('manage-product-list.store') }}" method="POST" enctype="multipart/form-data">
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

                  <!-- Product Category -->
                  <div class="col-md-6">
                    <label class="form-label" for="product_category_id">Product Category <span class="text-danger">*</span></label>
                    <select class="form-select @error('product_category_id') is-invalid @enderror" id="product_category_id" name="product_category_id" required>
                      <option value="">-- Select Category --</option>
                      @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                    </select>
                    @error('product_category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <!-- Product Name -->
                  <div class="col-md-6">
                    <label class="form-label" for="name">Product Name <span class="text-danger">*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter product name" required>
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <!-- Image -->
                  <div class="col-md-6">
                    <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                    <input class="form-control @error('image') is-invalid @enderror" id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required onchange="previewImage()">
                    @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB</small>
                    <div class="mt-2"><img id="image_preview" style="max-height:120px; display:none; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
                  </div>

                  <!-- Status -->
                  <div class="col-md-6">
                    <label class="form-label" for="is_active">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                      <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <!-- Priority -->
                  <div class="col-md-6">
                    <label class="form-label" for="priority">Priority</label>
                    <input class="form-control @error('priority') is-invalid @enderror" id="priority" type="number" min="0" name="priority" value="{{ old('priority', 0) }}" placeholder="e.g. 1">
                    @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1">Lower numbers appear first (within its category).</small>
                  </div>

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-product-list.index') }}" class="btn btn-danger px-4">Cancel</a>
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
