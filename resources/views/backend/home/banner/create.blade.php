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
                <div class="col-6">
                  <h4>Add Banner Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('banner-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Banner Details</li>
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
                        <h4>Banner Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('banner-details.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Banner Heading-->
                                    <div class="col-md-12">
                                        <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
                                        <textarea class="form-control editor @error('banner_heading') is-invalid @enderror" id="banner_heading" name="banner_heading" rows="4" placeholder="Enter Banner Heading">{{ old('banner_heading') }}</textarea>
                                        @error('banner_heading')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Banner Title-->
                                    <div class="col-md-12">
                                        <label class="form-label" for="banner_title">Banner Title <span class="text-danger">*</span></label>
                                        <input class="form-control @error('banner_title') is-invalid @enderror" id="banner_title" type="text" name="banner_title" placeholder="Enter Banner Title" value="{{ old('banner_title') }}" required>
                                        @error('banner_title')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <!-- Banner Media -->
                                    <div class="col-md-6">
                                        <label class="form-label" for="banner_media">
                                            Banner Image / Video <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            class="form-control @error('banner_media') is-invalid @enderror"
                                            id="banner_media"
                                            type="file"
                                            name="banner_media"
                                            accept=".jpg,.jpeg,.png,.webp,.mp4,.webm"
                                            required
                                            onchange="previewBannerMedia()"
                                        >

                                        @error('banner_media')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror

                                        <small class="text-secondary d-block mt-1">
                                            <b>Allowed:</b> jpg, jpeg, png, webp, mp4, webm &nbsp;|&nbsp;
                                            <b>Max size:</b> Image 2 MB, Video 5 MB
                                        </small>

                                        <!-- Preview BELOW input -->
                                        <div id="bannerPreviewContainer" class="mt-3" style="display:none;">
                                            <img
                                                id="banner_image_preview"
                                                class="img-fluid"
                                                style="max-height:200px; display:none; border:1px solid #ddd; padding:5px;"
                                            >

                                            <video
                                                id="banner_video_preview"
                                                controls
                                                style="max-height:200px; display:none; border:1px solid #ddd; padding:5px;"
                                            ></video>
                                        </div>
                                    </div>



                                    <!-- Form Actions -->
                                    <div class="col-12 text-end">
                                        <a href="{{ route('banner-details.index') }}" class="btn btn-danger px-4">Cancel</a>
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
            // Rich-text editor for the banner heading.
            // (CKEditor 5 is already loaded in main-js — do NOT re-include the CDN,
            //  it would throw a "ckeditor-duplicated-modules" error.)
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

            function previewBannerMedia() {
                const fileInput = document.getElementById('banner_media');
                const file = fileInput.files[0];

                const previewContainer = document.getElementById('bannerPreviewContainer');
                const imagePreview = document.getElementById('banner_image_preview');
                const videoPreview = document.getElementById('banner_video_preview');

                imagePreview.style.display = 'none';
                videoPreview.style.display = 'none';

                if (!file) return;

                const imageTypes = ['image/jpeg', 'image/png', 'image/webp'];
                const videoTypes = ['video/mp4', 'video/webm'];

                const isImage = imageTypes.includes(file.type);
                const isVideo = videoTypes.includes(file.type);
                const maxBytes = isVideo ? 5 * 1024 * 1024 : 2 * 1024 * 1024;
                if ((isImage || isVideo) && file.size > maxBytes) {
                    alert(isVideo ? 'Video is too large. Maximum allowed is 5 MB.'
                                  : 'Image is too large. Maximum allowed is 2 MB.');
                    fileInput.value = '';
                    return;
                }

                const url = URL.createObjectURL(file);

                if (imageTypes.includes(file.type)) {
                    imagePreview.src = url;
                    imagePreview.style.display = 'block';
                } else if (videoTypes.includes(file.type)) {
                    videoPreview.src = url;
                    videoPreview.style.display = 'block';
                } else {
                    alert('Invalid file type');
                    fileInput.value = '';
                    return;
                }

                previewContainer.style.display = 'block';
            }
        </script>


</body>

</html>