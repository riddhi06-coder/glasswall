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
            <div class="col-6"><h4>Add Contact Details</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-contact-details.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Contact Details</li>
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
                <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-contact-details.store') }}" method="POST" enctype="multipart/form-data">
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

                            <!-- Banner Heading -->
                            <div class="col-md-6">
                              <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading') }}" placeholder="e.g. Contact Us" required>
                              @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Banner Image -->
                            <div class="col-md-6">
                              <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
                              <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" required onchange="previewBanner()">
                              @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                              <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB</small>
                              <div class="mt-2"><img id="banner_preview" style="max-height:120px; display:none; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
                            </div>

                            <!-- Email 1 -->
                            <div class="col-md-6">
                              <label class="form-label" for="email_1">Email 1 <span class="text-danger">*</span></label>
                              <input class="form-control @error('email_1') is-invalid @enderror" id="email_1" type="email" name="email_1" value="{{ old('email_1') }}" placeholder="e.g. info@glasswallsystems.in" required>
                              @error('email_1')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Email 2 -->
                            <div class="col-md-6">
                              <label class="form-label" for="email_2">Email 2 <span class="text-danger">*</span></label>
                              <input class="form-control @error('email_2') is-invalid @enderror" id="email_2" type="email" name="email_2" value="{{ old('email_2') }}" placeholder="e.g. sales@glasswallsystems.in" required>
                              @error('email_2')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                              <label class="form-label" for="phone">Phone No. <span class="text-danger">*</span></label>
                              <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +91 22 6197 7456" required>
                              @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Address (rich text) -->
                            <div class="col-md-12">
                              <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                              <textarea class="form-control editor @error('address') is-invalid @enderror" id="address" name="address" rows="4" placeholder="Enter Address">{!! old('address') !!}</textarea>
                              @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Map URL -->
                            <div class="col-md-6">
                              <label class="form-label" for="map_url">Map URL <span class="text-danger">*</span></label>
                              <input class="form-control @error('map_url') is-invalid @enderror" id="map_url" type="text" name="map_url" value="{{ old('map_url') }}" placeholder="e.g. https://maps.google.com/..." required>
                              @error('map_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Iframe URL -->
                            <div class="col-md-6">
                              <label class="form-label" for="iframe_url">Iframe URL <span class="text-danger">*</span></label>
                              <input class="form-control @error('iframe_url') is-invalid @enderror" id="iframe_url" type="text" name="iframe_url" value="{{ old('iframe_url') }}" placeholder="e.g. https://www.google.com/maps/embed?..." required>
                              @error('iframe_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end mt-3">
                              <a href="{{ route('manage-contact-details.index') }}" class="btn btn-danger px-4">Cancel</a>
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
        // Banner image preview + 2 MB guard.
        function previewBanner() {
            var input = document.getElementById('banner_image');
            var preview = document.getElementById('banner_preview');
            var file = input.files[0];
            preview.style.display = 'none';
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Banner image is too large. Maximum allowed is 2 MB.');
                input.value = '';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }

        // Rich-text editor for the address.
        // (CKEditor 5 is already loaded in main-js — do NOT re-include the CDN.)
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

</body>

</html>
