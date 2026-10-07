<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
</head>
<body>
    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6"><h4>Add SEO Entry</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-seo.index') }}">SEO Manager</a></li>
                <li class="breadcrumb-item active">Add</li>
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
                <h4>SEO Meta Tags</h4>
                <p class="f-m-light mt-1">Add the on-page meta tags for a single URL.</p>
              </div>
              <div class="card-body">
                <form class="row g-3" action="{{ route('manage-seo.store') }}" method="POST">
                  @csrf
                  @include('backend.seo._fields')
                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-seo.index') }}" class="btn btn-danger px-4">Cancel</a>
                    <button class="btn btn-primary" type="submit">Save</button>
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
</body>
</html>
