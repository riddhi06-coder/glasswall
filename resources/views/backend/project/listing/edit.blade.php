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
            <div class="col-6"><h4>Edit Project</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-project-listing.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Project</li>
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
                <h4>Project Form</h4>
                <p class="f-m-light mt-1">Update the details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-project-listing.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                              <div class="col-12">
                                <div class="alert alert-danger mb-0">
                                  <ul class="mb-0">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                  </ul>
                                </div>
                              </div>
                            @endif

                            <!-- Category -->
                            <div class="col-md-6">
                              <label class="form-label" for="project_category_id">Category <span class="text-danger">*</span></label>
                              <select class="form-control @error('project_category_id') is-invalid @enderror" id="project_category_id" name="project_category_id" required>
                                <option value="">-- Select a category --</option>
                                @foreach($categories as $cat)
                                  <option value="{{ $cat->id }}" {{ old('project_category_id', $listing->project_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                              </select>
                              @error('project_category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Project Name -->
                            <div class="col-md-6">
                              <label class="form-label" for="name">Project Name <span class="text-danger">*</span></label>
                              <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name', $listing->name) }}" placeholder="Enter Project Name" required>
                              @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1">Current slug: <code>{{ $listing->slug }}</code> (updates if the name changes).</small>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6">
                              <label class="form-label" for="location">Location <span class="text-danger">*</span></label>
                              <input class="form-control @error('location') is-invalid @enderror" id="location" type="text" name="location" value="{{ old('location', $listing->location) }}" placeholder="e.g. Mumbai, India" required>
                              @error('location')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Priority -->
                            <div class="col-md-3">
                              <label class="form-label" for="priority">Priority <span class="text-danger">*</span></label>
                              <input class="form-control @error('priority') is-invalid @enderror" id="priority" type="number" name="priority" min="0" value="{{ old('priority', $listing->priority) }}" placeholder="e.g. 1" required>
                              @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-3">
                              <label class="form-label" for="is_active">Status <span class="text-danger">*</span></label>
                              <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                                <option value="1" {{ (string) old('is_active', $listing->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ (string) old('is_active', $listing->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive</option>
                              </select>
                              @error('is_active')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Thumbnail -->
                            <div class="col-md-6">
                              <label class="form-label" for="thumbnail">Thumbnail Image</label>
                              <input class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp" onchange="previewThumbnail()">
                              @error('thumbnail')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB. Leave blank to keep current.</small>
                              <div class="mt-2">
                                <img id="thumbnail_preview" src="{{ asset('project/listings/'.$listing->thumbnail) }}" style="max-height:120px; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="thumbnail">
                              </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end mt-3">
                              <a href="{{ route('manage-project-listing.index') }}" class="btn btn-danger px-4">Cancel</a>
                              <button class="btn btn-primary" type="submit">Update</button>
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
