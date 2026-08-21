<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
    <style>
        #aboutForm { --bs-gutter-x: 2rem; }
        #aboutForm > [class*="col-"] { margin-bottom: 24px !important; }
        .about-sec-title {
            font-weight:700; color:#2b2f3a; font-size:17px;
            margin:22px 0 4px !important; padding:10px 14px;
            background:#f6f7fb; border-left:4px solid #4f46e5; border-radius:8px;
        }
        .about-sub-title { font-weight:600; color:#4f46e5; margin:10px 0 2px !important; }
        #aboutForm > [class*="col-"]:first-of-type .about-sec-title { margin-top:0 !important; }
    </style>
</head>

    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Edit About Us</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-about-us.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit About Us</li>
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
                <h4>About Us Form</h4>
                <p class="f-m-light mt-1">Update the details and submit the form.</p>
              </div>
              <div class="card-body">
                <form id="aboutForm" class="row needs-validation custom-input" novalidate action="{{ route('manage-about-us.update', $about->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  @include('backend.overview.about_us._fields', ['about' => $about])

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-about-us.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    @include('backend.overview.about_us._scripts')

</body>

</html>
