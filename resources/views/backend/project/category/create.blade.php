<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
</head>

    @include('components.backend.header')

    <!--start sidebar wrapper-->
    @include('components.backend.sidebar')
    <!--end sidebar wrapper-->

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Add Project Category</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-project-category.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Category</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Container-fluid starts-->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Category Form</h4>
                <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-project-category.store') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="col-md-12">
                              <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                              <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter Category Name" required>
                              @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1">A URL slug will be generated automatically from the name.</small>
                            </div>

                            <!-- Priority -->
                            <div class="col-md-6">
                              <label class="form-label" for="priority">Priority <span class="text-danger">*</span></label>
                              <input class="form-control @error('priority') is-invalid @enderror" id="priority" type="number" name="priority" min="0" value="{{ old('priority', 0) }}" placeholder="e.g. 1" required>
                              @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1">Lower number appears first.</small>
                            </div>

                            <!-- Thumbnail -->
                            <div class="col-md-6">
                              <label class="form-label" for="thumbnail">Thumbnail Image <span class="text-danger">*</span></label>
                              <input class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp" required onchange="previewThumbnail()">
                              @error('thumbnail')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB</small>
                              <div class="mt-2">
                                <img id="thumbnail_preview" style="max-height:120px; display:none; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview">
                              </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end mt-3">
                              <a href="{{ route('manage-project-category.index') }}" class="btn btn-danger px-4">Cancel</a>
                              <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- footer start-->
    @include('components.backend.footer')
    </div>
    </div>

    @include('components.backend.main-js')

    <script>
        function previewThumbnail() {
            var input = document.getElementById('thumbnail');
            var preview = document.getElementById('thumbnail_preview');
            var file = input.files[0];
            preview.style.display = 'none';
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Thumbnail is too large. Maximum allowed is 2 MB.');
                input.value = '';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    </script>

</body>

</html>
