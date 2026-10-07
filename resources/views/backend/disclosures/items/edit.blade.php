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
            <div class="col-6"><h4>Edit Disclosure Item</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-disclosure-items.index') }}">Disclosure Items</a></li>
                <li class="breadcrumb-item active">Edit</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header"><h4>Disclosure Item</h4></div>
              <div class="card-body p-4">
                <form class="row g-4 disclosure-form" action="{{ route('manage-disclosure-items.update', $record->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  @include('backend.disclosures.items._fields')
                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-disclosure-items.index') }}" class="btn btn-danger px-4">Cancel</a>
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
</body>
</html>
