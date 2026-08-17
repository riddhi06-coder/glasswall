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
            <div class="col-6"><h4>Edit Project Details</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-project-details.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Project Details</li>
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
                <h4>Project Details Form</h4>
                <p class="f-m-light mt-1">Update the project details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-project-details.update', $detail->id) }}" method="POST" enctype="multipart/form-data">
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

                            @php
                              $selCat  = old('project_category_id', optional($detail->listing)->project_category_id);
                              $selProj = old('project_listing_id', $detail->project_listing_id);
                              $scopes  = old('scope_of_work', $detail->scope_of_work ?? []);
                            @endphp

                            <!-- Category -->
                            <div class="col-md-6">
                              <label class="form-label" for="project_category_id">Category <span class="text-danger">*</span></label>
                              <select class="form-control @error('project_category_id') is-invalid @enderror" id="project_category_id" name="project_category_id" required>
                                <option value="">-- Select a category --</option>
                                @foreach($categories as $cat)
                                  <option value="{{ $cat->id }}" {{ $selCat == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                              </select>
                              @error('project_category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Project (dependent on category) -->
                            <div class="col-md-6">
                              <label class="form-label" for="project_listing_id">Project <span class="text-danger">*</span></label>
                              <select class="form-control @error('project_listing_id') is-invalid @enderror" id="project_listing_id" name="project_listing_id" data-old="{{ $selProj }}" required>
                                <option value="">-- Select a project --</option>
                                @foreach($listings as $l)
                                  <option value="{{ $l->id }}" {{ $selProj == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                @endforeach
                              </select>
                              @error('project_listing_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Banner Image -->
                            <div class="col-md-6">
                              <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
                              <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" onchange="previewImg(this, 'banner_preview')">
                              @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB &nbsp;|&nbsp; Leave empty to keep current.</small>
                              <div class="mt-2">
                                <img id="banner_preview" src="{{ $detail->banner_image_url }}" style="max-height:120px; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="banner">
                              </div>
                            </div>

                            <!-- Image -->
                            <div class="col-md-6">
                              <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                              <input class="form-control @error('image') is-invalid @enderror" id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" onchange="previewImg(this, 'image_preview')">
                              @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB &nbsp;|&nbsp; Leave empty to keep current.</small>
                              <div class="mt-2">
                                <img id="image_preview" src="{{ $detail->image_url }}" style="max-height:120px; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="image">
                              </div>
                            </div>

                            <!-- Client -->
                            <div class="col-md-6">
                              <label class="form-label" for="client">Client <span class="text-danger">*</span></label>
                              <input class="form-control @error('client') is-invalid @enderror" id="client" type="text" name="client" value="{{ old('client', $detail->client) }}" placeholder="Enter Client" required>
                              @error('client')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Architect -->
                            <div class="col-md-6">
                              <label class="form-label" for="architect">Architect <span class="text-danger">*</span></label>
                              <input class="form-control @error('architect') is-invalid @enderror" id="architect" type="text" name="architect" value="{{ old('architect', $detail->architect) }}" placeholder="Enter Architect" required>
                              @error('architect')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Consultant -->
                            <div class="col-md-6">
                              <label class="form-label" for="consultant">Consultant <span class="text-danger">*</span></label>
                              <input class="form-control @error('consultant') is-invalid @enderror" id="consultant" type="text" name="consultant" value="{{ old('consultant', $detail->consultant) }}" placeholder="Enter Consultant" required>
                              @error('consultant')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Project Area -->
                            <div class="col-md-6">
                              <label class="form-label" for="project_area">Project Area <span class="text-danger">*</span></label>
                              <input class="form-control @error('project_area') is-invalid @enderror" id="project_area" type="text" name="project_area" value="{{ old('project_area', $detail->project_area) }}" placeholder="e.g. 1,20,000 sq.ft." required>
                              @error('project_area')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Floors -->
                            <div class="col-md-6">
                              <label class="form-label" for="floors">Floors <span class="text-danger">*</span></label>
                              <input class="form-control @error('floors') is-invalid @enderror" id="floors" type="text" name="floors" value="{{ old('floors', $detail->floors) }}" placeholder="e.g. G + 20" required>
                              @error('floors')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Scope of Work (repeatable rows) -->
                            <div class="col-md-12">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Scope of Work <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-primary" id="addScopeRow">+ Add More</button>
                              </div>
                              <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0" id="scopeTable">
                                  <thead>
                                    <tr>
                                      <th style="width:60px;">#</th>
                                      <th>Scope of Work <span class="text-danger">*</span></th>
                                      <th style="width:90px;" class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="scopeBody">
                                    <!-- rows injected by JS -->
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end mt-3">
                              <a href="{{ route('manage-project-details.index') }}" class="btn btn-danger px-4">Cancel</a>
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
        function previewImg(input, previewId) {
            var preview = document.getElementById(previewId);
            var file = input.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Image is too large. Maximum allowed is 2 MB.');
                input.value = '';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }

        (function ($) {
            var listUrl = '{{ url('manage-project-details/listings-by-category') }}';

            function loadProjects(categoryId, selectedId) {
                var $proj = $('#project_listing_id');
                if (!categoryId) {
                    $proj.html('<option value="">-- Select a category first --</option>');
                    return;
                }
                $proj.html('<option value="">Loading...</option>');
                $.getJSON(listUrl + '/' + categoryId, function (rows) {
                    var opts = '<option value="">-- Select a project --</option>';
                    $.each(rows, function (i, r) {
                        opts += '<option value="' + r.id + '"' + (String(r.id) === String(selectedId) ? ' selected' : '') + '>' + r.name + '</option>';
                    });
                    $proj.html(opts);
                }).fail(function () {
                    $proj.html('<option value="">Could not load projects</option>');
                });
            }

            $('#project_category_id').on('change', function () {
                loadProjects($(this).val(), null);
            });

            // ---- Scope of Work repeatable rows ----
            function scopeRow(value) {
                return '' +
                    '<tr>' +
                        '<td class="row-index"></td>' +
                        '<td><input type="text" name="scope_of_work[]" class="form-control" placeholder="Enter scope of work" value="' + (value || '') + '" required></td>' +
                        '<td class="text-center"><button type="button" class="btn btn-sm btn-danger removeScopeRow">Remove</button></td>' +
                    '</tr>';
            }

            function renumber() {
                $('#scopeBody tr').each(function (i) {
                    $(this).find('.row-index').text(i + 1);
                });
            }

            $('#addScopeRow').on('click', function () {
                $('#scopeBody').append(scopeRow(''));
                renumber();
            });

            $('#scopeBody').on('click', '.removeScopeRow', function () {
                if ($('#scopeBody tr').length <= 1) {
                    alert('At least one scope of work is required.');
                    return;
                }
                $(this).closest('tr').remove();
                renumber();
            });

            $(function () {
                @forelse($scopes as $scope)
                    $('#scopeBody').append(scopeRow(@json($scope)));
                @empty
                    $('#scopeBody').append(scopeRow(''));
                @endforelse
                renumber();
            });
        })(jQuery);
    </script>

</body>

</html>
