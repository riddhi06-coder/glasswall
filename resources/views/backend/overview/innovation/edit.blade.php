<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
    <style>
        #invForm { --bs-gutter-x: 2rem; }
        #invForm > [class*="col-"] { margin-bottom: 24px !important; }
        .inv-sec-title { font-weight:700; color:#2b2f3a; font-size:17px; margin:22px 0 4px !important;
            padding:10px 14px; background:#f6f7fb; border-left:4px solid #4f46e5; border-radius:8px; }
        #invForm > [class*="col-"]:first-of-type .inv-sec-title { margin-top:0 !important; }
    </style>
</head>

    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Edit Innovation</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-innovation.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Innovation</li>
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
                <h4>Innovation Form</h4>
                <p class="f-m-light mt-1">Update the details and submit the form.</p>
              </div>
              <div class="card-body">
                <form id="invForm" class="row needs-validation custom-input" novalidate action="{{ route('manage-innovation.update', $innovation->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  @include('backend.overview.innovation._fields', ['innovation' => $innovation, 'isFirst' => $isFirst])

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-innovation.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    @include('backend.overview.innovation._scripts')

</body>

</html>
