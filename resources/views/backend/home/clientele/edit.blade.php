<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
    <style>
        .form-section-head {
            border-bottom: 1px solid #e6e8ee;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }
        .form-section-head h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #2f2f3b;
        }
        .form-section-gap { margin-top: 3.75rem !important; }
    </style>
</head>

    @include('components.backend.header')

    <!--start sidebar wrapper-->
    @include('components.backend.sidebar')
    <!--end sidebar wrapper-->

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Edit Clientele Form</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home-clientele.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Clientele</li>
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
                <h4>Clientele Form</h4>
                <p class="f-m-light mt-1">Update the details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('home-clientele.update', $clientele->id) }}" method="POST" enctype="multipart/form-data">
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

                            {{-- ================= Section Headings ================= --}}
                            <div class="col-12">
                              <div class="form-section-head">
                                <h6>Section Headings</h6>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label" for="product_section_heading">Product Section Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('product_section_heading') is-invalid @enderror" id="product_section_heading" type="text" name="product_section_heading" value="{{ old('product_section_heading', $clientele->product_section_heading) }}" required>
                              @error('product_section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12">
                              <label class="form-label" for="work_section_heading">Work Section Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('work_section_heading') is-invalid @enderror" id="work_section_heading" type="text" name="work_section_heading" value="{{ old('work_section_heading', $clientele->work_section_heading) }}" required>
                              @error('work_section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12">
                              <label class="form-label" for="project_section_heading">Project Section Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('project_section_heading') is-invalid @enderror" id="project_section_heading" type="text" name="project_section_heading" value="{{ old('project_section_heading', $clientele->project_section_heading) }}" required>
                              @error('project_section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            {{-- ================= Clientele Section ================= --}}
                            <div class="col-12 form-section-gap">
                              <div class="form-section-head">
                                <h6>Clientele Section</h6>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label" for="clientele_section_heading">Clientele Section Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('clientele_section_heading') is-invalid @enderror" id="clientele_section_heading" type="text" name="clientele_section_heading" value="{{ old('clientele_section_heading', $clientele->clientele_section_heading) }}" required>
                              @error('clientele_section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12">
                              <label class="form-label" for="clientele_section_desc">Clientele Section Description <span class="text-danger">*</span></label>
                              <textarea class="form-control editor @error('clientele_section_desc') is-invalid @enderror" id="clientele_section_desc" name="clientele_section_desc" rows="5">{{ old('clientele_section_desc', $clientele->clientele_section_desc) }}</textarea>
                              @error('clientele_section_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Client Images <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-primary" id="addClientRow">+ Add More</button>
                              </div>
                              <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="clientsTable">
                                  <thead>
                                    <tr>
                                      <th>Client Image <span class="text-danger">*</span></th>
                                      <th style="width:90px;" class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="clientsBody">
                                    @foreach($clientele->images as $i => $img)
                                      <tr>
                                        <td>
                                          <input type="hidden" name="clients[{{ $i }}][existing_image]" value="{{ $img->image }}">
                                          <input type="file" name="clients[{{ $i }}][image]" class="form-control client-image" accept=".jpg,.jpeg,.png,.webp,.svg">
                                          <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB. Leave blank to keep current.</small>
                                          <img class="client-image-preview mt-2" src="{{ asset('home/clienteleimages/'.$img->image) }}" style="max-height:70px; border:1px solid #ddd; padding:3px; border-radius:4px;" alt="client">
                                        </td>
                                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row">Remove</button></td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            {{-- ================= Collaboration Section ================= --}}
                            <div class="col-12 form-section-gap">
                              <div class="form-section-head">
                                <h6>Collaboration Section</h6>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label" for="collaboration_section_heading">Collaboration Section Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('collaboration_section_heading') is-invalid @enderror" id="collaboration_section_heading" type="text" name="collaboration_section_heading" value="{{ old('collaboration_section_heading', $clientele->collaboration_section_heading) }}" required>
                              @error('collaboration_section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12">
                              <label class="form-label" for="collaboration_section_title">Collaboration Section Title <span class="text-danger">*</span></label>
                              <input class="form-control @error('collaboration_section_title') is-invalid @enderror" id="collaboration_section_title" type="text" name="collaboration_section_title" value="{{ old('collaboration_section_title', $clientele->collaboration_section_title) }}" required>
                              @error('collaboration_section_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end mt-4">
                              <a href="{{ route('home-clientele.index') }}" class="btn btn-danger px-4">Cancel</a>
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

        (function () {
            var body = document.getElementById('clientsBody');
            var idx = {{ $clientele->images->count() }};

            function rowHtml(i) {
                return '<tr>' +
                    '<td>' +
                        '<input type="file" name="clients[' + i + '][image]" class="form-control client-image" accept=".jpg,.jpeg,.png,.webp,.svg" required>' +
                        '<small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB</small>' +
                        '<img class="client-image-preview mt-2" style="max-height:70px; display:none; border:1px solid #ddd; padding:3px; border-radius:4px;" alt="client preview">' +
                    '</td>' +
                    '<td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row">Remove</button></td>' +
                '</tr>';
            }

            document.getElementById('addClientRow').addEventListener('click', function () {
                body.insertAdjacentHTML('beforeend', rowHtml(idx++));
            });

            body.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                }
            });

            body.addEventListener('change', function (e) {
                if (!e.target.classList.contains('client-image')) return;
                var input = e.target, file = input.files[0];
                var preview = input.closest('td').querySelector('.client-image-preview');
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('Client image is too large. Maximum allowed is 2 MB.');
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
