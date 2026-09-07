<!doctype html>
<html lang="en">

<head>
    @include('components.backend.head')
</head>

    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Add Job</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-jobs.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Job</li>
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
                <h4>Job Form</h4>
                <p class="f-m-light mt-1">Fill up the details and submit the form.</p>
              </div>
              <div class="card-body">
                <form class="row g-4 needs-validation custom-input" novalidate action="{{ route('manage-jobs.store') }}" method="POST">
                  @csrf

                  @if($errors->any())
                    <div class="col-12">
                      <div class="alert alert-danger mb-0">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                      </div>
                    </div>
                  @endif

                  @include('backend.career.job._fields', ['job' => null])

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-jobs.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    @include('backend.career.job._scripts')

</body>

</html>
