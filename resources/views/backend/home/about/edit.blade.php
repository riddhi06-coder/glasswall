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
            <div class="col-6"><h4>Edit About Details Form</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home-about-details.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit About Details</li>
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
                <h4>About Details Form</h4>
                <p class="f-m-light mt-1">Update the details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('home-about-details.update', $about->id) }}" method="POST" enctype="multipart/form-data">
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

                            <!-- Description (rich text) -->
                            <div class="col-md-12">
                              <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                              <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter Description">{{ old('description', $about->description) }}</textarea>
                              @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                              @enderror
                            </div>

                            <!-- Milestones (repeatable rows) -->
                            <div class="col-md-12">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Milestones</label>
                                <button type="button" class="btn btn-sm btn-primary" id="addMilestoneRow">+ Add More</button>
                              </div>
                              <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="milestonesTable">
                                  <thead>
                                    <tr>
                                      <th style="width:260px;">Icon <span class="text-danger">*</span></th>
                                      <th style="width:200px;">Count <span class="text-danger">*</span></th>
                                      <th>Milestone <span class="text-danger">*</span></th>
                                      <th style="width:90px;" class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="milestonesBody">
                                    @foreach($about->milestones as $i => $m)
                                      <tr>
                                        <td>
                                          <input type="hidden" name="milestones[{{ $i }}][existing_icon]" value="{{ $m->icon }}">
                                          <input type="file" name="milestones[{{ $i }}][icon]" class="form-control milestone-icon" accept=".svg,.png,.jpg,.jpeg,.webp">
                                          <small class="text-secondary d-block mt-1"><b>Allowed:</b> svg, png, jpg, jpeg, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB. Leave blank to keep current.</small>
                                          <img class="milestone-icon-preview mt-2" src="{{ asset('home/aboutmilestones/'.$m->icon) }}" style="max-height:60px; border:1px solid #ddd; padding:3px; border-radius:4px;" alt="icon">
                                        </td>
                                        <td><input type="text" name="milestones[{{ $i }}][count]" class="form-control" value="{{ $m->count }}" placeholder="e.g. 500000+" required></td>
                                        <td><input type="text" name="milestones[{{ $i }}][milestone]" class="form-control" value="{{ $m->milestone }}" placeholder="e.g. Projects Completed" required></td>
                                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row">Remove</button></td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end">
                              <a href="{{ route('home-about-details.index') }}" class="btn btn-danger px-4">Cancel</a>
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
        // Rich-text editor for the description.
        document.querySelectorAll('textarea.editor').forEach(function (el) {
            ClassicEditor.create(el, {
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                }
            }).catch(function (err) { console.error(err); });
        });

        // Dynamic milestone rows (new rows require an icon; existing rows keep theirs).
        (function () {
            var body = document.getElementById('milestonesBody');
            var idx = {{ $about->milestones->count() }};

            function rowHtml(i) {
                return '<tr>' +
                    '<td>' +
                        '<input type="file" name="milestones[' + i + '][icon]" class="form-control milestone-icon" accept=".svg,.png,.jpg,.jpeg,.webp" required>' +
                        '<small class="text-secondary d-block mt-1"><b>Allowed:</b> svg, png, jpg, jpeg, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB</small>' +
                        '<img class="milestone-icon-preview mt-2" style="max-height:60px; display:none; border:1px solid #ddd; padding:3px; border-radius:4px;" alt="icon preview">' +
                    '</td>' +
                    '<td><input type="text" name="milestones[' + i + '][count]" class="form-control" placeholder="e.g. 500000+" required></td>' +
                    '<td><input type="text" name="milestones[' + i + '][milestone]" class="form-control" placeholder="e.g. Projects Completed" required></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row">Remove</button></td>' +
                '</tr>';
            }

            document.getElementById('addMilestoneRow').addEventListener('click', function () {
                body.insertAdjacentHTML('beforeend', rowHtml(idx++));
            });

            body.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                }
            });

            body.addEventListener('change', function (e) {
                if (!e.target.classList.contains('milestone-icon')) return;
                var input = e.target, file = input.files[0];
                var preview = input.closest('td').querySelector('.milestone-icon-preview');
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('Icon is too large. Maximum allowed is 2 MB.');
                    input.value = '';
                    return;
                }
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            });
        })();
    </script>

</body>

</html>
