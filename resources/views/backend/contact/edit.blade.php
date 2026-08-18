<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
    <style>
        form#contactForm.row > [class*="col-"] { margin-bottom: 40px !important; }
        form#contactForm .form-label { margin-bottom: 10px !important; font-weight: 500; }
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
            <div class="col-6"><h4>Edit Contact Details</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-contact-details.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Contact Details</li>
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
                <h4>Contact Details Form</h4>
                <p class="f-m-light mt-1">Update the contact details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form id="contactForm" class="row needs-validation custom-input" novalidate action="{{ route('manage-contact-details.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
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

                            <!-- Banner Heading -->
                            <div class="col-md-6">
                              <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', $contact->banner_heading) }}" placeholder="e.g. Contact Us" required>
                              @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Banner Image -->
                            <div class="col-md-6">
                              <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
                              <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" onchange="previewBanner()">
                              @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB &nbsp;|&nbsp; Leave empty to keep current.</small>
                              <div class="mt-2">
                                <img id="banner_preview" src="{{ $contact->banner_image_url }}" style="max-height:120px; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="banner">
                              </div>
                            </div>

                            <!-- Email 1 -->
                            <div class="col-md-6">
                              <label class="form-label" for="email_1">Email 1 <span class="text-danger">*</span></label>
                              <input class="form-control @error('email_1') is-invalid @enderror" id="email_1" type="email" name="email_1" value="{{ old('email_1', $contact->email_1) }}" placeholder="e.g. info@glasswallsystems.in" required>
                              @error('email_1')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Email 2 -->
                            <div class="col-md-6">
                              <label class="form-label" for="email_2">Email 2 <span class="text-danger">*</span></label>
                              <input class="form-control @error('email_2') is-invalid @enderror" id="email_2" type="email" name="email_2" value="{{ old('email_2', $contact->email_2) }}" placeholder="e.g. sales@glasswallsystems.in" required>
                              @error('email_2')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                              <label class="form-label" for="phone">Phone No. <span class="text-danger">*</span></label>
                              <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" value="{{ old('phone', $contact->phone) }}" placeholder="e.g. +91 22 6197 7456" required>
                              @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Address (rich text) -->
                            <div class="col-md-12">
                              <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                              <textarea class="form-control editor @error('address') is-invalid @enderror" id="address" name="address" rows="4" placeholder="Enter Address">{!! old('address', $contact->address) !!}</textarea>
                              @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Map URL -->
                            <div class="col-md-6">
                              <label class="form-label" for="map_url">Map URL <span class="text-danger">*</span></label>
                              <input class="form-control @error('map_url') is-invalid @enderror" id="map_url" type="text" name="map_url" value="{{ old('map_url', $contact->map_url) }}" placeholder="e.g. https://maps.google.com/..." required>
                              @error('map_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Iframe URL -->
                            <div class="col-md-6">
                              <label class="form-label" for="iframe_url">Iframe URL <span class="text-danger">*</span></label>
                              <input class="form-control @error('iframe_url') is-invalid @enderror" id="iframe_url" type="text" name="iframe_url" value="{{ old('iframe_url', $contact->iframe_url) }}" placeholder="e.g. https://www.google.com/maps/embed?..." required>
                              @error('iframe_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Social Media Links (repeatable rows) -->
                            <div class="col-md-12">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Social Media Links</label>
                                <button type="button" class="btn btn-sm btn-primary" id="addSocialRow">+ Add More</button>
                              </div>
                              <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0" id="socialTable">
                                  <thead>
                                    <tr>
                                      <th style="width:60px;">#</th>
                                      <th style="width:240px;">Platform <span class="text-danger">*</span></th>
                                      <th>URL <span class="text-danger">*</span></th>
                                      <th style="width:90px;" class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="socialBody">
                                    <!-- rows injected by JS -->
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end mt-3">
                              <a href="{{ route('manage-contact-details.index') }}" class="btn btn-danger px-4">Cancel</a>
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
        function previewBanner() {
            var input = document.getElementById('banner_image');
            var preview = document.getElementById('banner_preview');
            var file = input.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Banner image is too large. Maximum allowed is 2 MB.');
                input.value = '';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }

        document.querySelectorAll('textarea.editor').forEach(function (el) {
            ClassicEditor.create(el, {
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                }
            }).catch(function (err) { console.error(err); });
        });
    </script>

    <script>
        // ---- Social media links: repeatable rows ----
        (function () {
            var PLATFORMS = @json(\App\Models\ContactSocialLink::PLATFORMS);
            var body = document.getElementById('socialBody');
            var idx  = 0;

            function options(selected) {
                var html = '<option value="">-- Select platform --</option>';
                Object.keys(PLATFORMS).forEach(function (key) {
                    html += '<option value="' + key + '"' + (key === selected ? ' selected' : '') + '>' + PLATFORMS[key].label + '</option>';
                });
                return html;
            }

            function addRow(platform, url) {
                var i = idx++;
                var tr = document.createElement('tr');
                tr.innerHTML =
                    '<td class="row-index"></td>' +
                    '<td><select name="social_links[' + i + '][platform]" class="form-control" required>' + options(platform) + '</select></td>' +
                    '<td><input type="url" name="social_links[' + i + '][url]" class="form-control" placeholder="https://..." value="' + (url ? url.replace(/"/g, '&quot;') : '') + '" required></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-sm btn-danger removeSocialRow">Remove</button></td>';
                body.appendChild(tr);
                renumber();
            }

            function renumber() {
                Array.prototype.forEach.call(body.querySelectorAll('tr'), function (tr, n) {
                    tr.querySelector('.row-index').textContent = n + 1;
                });
            }

            document.getElementById('addSocialRow').addEventListener('click', function () { addRow('', ''); });
            body.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeSocialRow')) {
                    e.target.closest('tr').remove();
                    renumber();
                }
            });

            // Seed rows: old input on validation error, else existing links.
            @if(old('social_links'))
                @foreach(old('social_links') as $row)
                    addRow(@json($row['platform'] ?? ''), @json($row['url'] ?? ''));
                @endforeach
            @else
                @foreach($contact->socialLinks as $link)
                    addRow(@json($link->platform), @json($link->url));
                @endforeach
            @endif
        })();
    </script>

</body>

</html>
