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
            <div class="col-6"><h4>Add Blog Section Form</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home-blog-details.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Blog Section</li>
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
                <h4>Blog Section Form</h4>
                <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="tab-content" id="wizard-tabContent">
                        <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel">
                          <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('home-blog-details.store') }}" method="POST">
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

                            <!-- Section Heading -->
                            <div class="col-md-12">
                              <label class="form-label" for="section_heading">Section Heading <span class="text-danger">*</span></label>
                              <input class="form-control @error('section_heading') is-invalid @enderror" id="section_heading" type="text" name="section_heading" value="{{ old('section_heading') }}" placeholder="Enter Section Heading" required>
                              @error('section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- API Link -->
                            <div class="col-md-12">
                              <label class="form-label" for="api_link">API Link <span class="text-danger">*</span></label>
                              <input class="form-control @error('api_link') is-invalid @enderror" id="api_link" type="url" name="api_link" value="{{ old('api_link') }}" placeholder="https://example.com/api/blogs" required>
                              @error('api_link')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 text-end mt-3">
                              <a href="{{ route('home-blog-details.index') }}" class="btn btn-danger px-4">Cancel</a>
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

</body>

</html>
