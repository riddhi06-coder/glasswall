<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
    <style>
        #deForm { --bs-gutter-x: 2rem; }
        #deForm > [class*="col-"] { margin-bottom: 24px !important; }
        .de-sec-title {
            font-weight:700; color:#2b2f3a; font-size:17px;
            margin:22px 0 4px !important; padding:10px 14px;
            background:#f6f7fb; border-left:4px solid #4f46e5; border-radius:8px;
        }
        #deForm > [class*="col-"]:first-of-type .de-sec-title { margin-top:0 !important; }
    </style>
</head>

    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Add Design &amp; Engineering</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-design-engg.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Design &amp; Engineering</li>
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
                <h4>Design &amp; Engineering Form</h4>
                <p class="f-m-light mt-1">Fill up the details and submit the form.</p>
              </div>
              <div class="card-body">
                <form id="deForm" class="row needs-validation custom-input" novalidate action="{{ route('manage-design-engg.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if($errors->any())
                    <div class="col-12">
                      <div class="alert alert-danger mb-0">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                      </div>
                    </div>
                  @endif

                  @include('backend.infra.design_engg._fields', ['record' => null])

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-design-engg.index') }}" class="btn btn-danger px-4">Cancel</a>
                    <button class="btn btn-primary" type="submit">Submit</button>
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
    @include('backend.infra.design_engg._scripts')

</body>

</html>
