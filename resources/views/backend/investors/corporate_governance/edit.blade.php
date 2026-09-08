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
            <div class="col-6"><h4>Edit Governance Document</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-corporate-governance.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Governance Document</li>
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
                <h4>Governance Document Form</h4>
                <p class="f-m-light mt-1">Update the details and submit the form. @if($isFirst)<b>Banner fields apply to the whole page (first record only).</b>@endif</p>
              </div>
              <div class="card-body">
                <form class="row g-4 needs-validation custom-input" novalidate action="{{ route('manage-corporate-governance.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  @if($errors->any())
                    <div class="col-12">
                      <div class="alert alert-danger mb-0">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                      </div>
                    </div>
                  @endif

                  @if($isFirst)
                    <div class="col-md-6">
                      <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
                      <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', $report->banner_heading) }}" placeholder="e.g. Governance Documents" required>
                      @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
                      <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewImage(this,'banner_preview')">
                      @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                      <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB &nbsp;|&nbsp; Leave empty to keep current.</small>
                      <div class="mt-2"><img id="banner_preview" src="{{ $report->banner_image_url }}" style="max-height:110px; {{ $report->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
                    </div>
                  @endif

                  <!-- Document Title -->
                  <div class="col-md-6">
                    <label class="form-label" for="title">Document Title <span class="text-danger">*</span></label>
                    <input class="form-control @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title', $report->title) }}" placeholder="e.g. Committees of Board" required>
                    @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <!-- Group -->
                  <div class="col-md-6">
                    <label class="form-label" for="group">Group</label>
                    <input class="form-control @error('group') is-invalid @enderror" id="group" type="text" name="group" value="{{ old('group', $report->group) }}" placeholder="e.g. Policies" list="cg-groups">
                    <datalist id="cg-groups"><option value="Policies"></datalist>
                    @error('group')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1">Leave empty for a standalone document; documents with the same group are shown together (e.g. "Policies").</small>
                  </div>

                  <!-- PDF -->
                  <div class="col-md-6">
                    <label class="form-label" for="pdf">PDF File <span class="text-danger">*</span></label>
                    <input class="form-control @error('pdf') is-invalid @enderror" id="pdf" type="file" name="pdf" accept="application/pdf,.pdf">
                    @error('pdf')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> pdf &nbsp;|&nbsp; <b>Max:</b> 5 MB &nbsp;|&nbsp;
                      @if($report->pdf)<a href="{{ $report->pdf_url }}" target="_blank">View current PDF</a> · Leave empty to keep current.@endif
                    </small>
                  </div>

                  <!-- Status -->
                  <div class="col-md-6">
                    <label class="form-label" for="is_active">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                      <option value="1" {{ (string) old('is_active', $report->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ (string) old('is_active', $report->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <!-- Priority -->
                  <div class="col-md-6">
                    <label class="form-label" for="priority">Priority</label>
                    <input class="form-control @error('priority') is-invalid @enderror" id="priority" type="number" min="0" name="priority" value="{{ old('priority', $report->priority) }}" placeholder="e.g. 1">
                    @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1">Lower numbers appear first.</small>
                  </div>

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-corporate-governance.index') }}" class="btn btn-danger px-4">Cancel</a>
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
