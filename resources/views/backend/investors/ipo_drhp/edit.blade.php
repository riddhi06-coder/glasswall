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
            <div class="col-6"><h4>Edit DRHP Disclaimer</h4></div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-ipo-drhp.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit DRHP Disclaimer</li>
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
                <h4>DRHP Disclaimer Form</h4>
                <p class="f-m-light mt-1">The DRHP is gated behind two disclaimer pages before the PDF is shown.</p>
              </div>
              <div class="card-body">
                <form class="row g-4 needs-validation custom-input" novalidate action="{{ route('manage-ipo-drhp.update', $drhp->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  @if($errors->any())
                    <div class="col-12"><div class="alert alert-danger mb-0"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                  @endif

                  <div class="col-12"><div class="drhp-sec">Disclaimer Page 1</div></div>
                  <div class="col-md-6">
                    <label class="form-label" for="banner_image">Page 1 Banner Image</label>
                    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept="image/*">
                    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB &nbsp;|&nbsp; @if($drhp->banner_image) Leave empty to keep current. @else Leave empty to use the default banner. @endif</small>
                    @if($drhp->banner_image)
                      <img src="{{ $drhp->banner_image_url }}" alt="current page 1 banner" style="height:90px;margin-top:10px;border:1px solid #e6e8f0;border-radius:8px;object-fit:cover;">
                    @endif
                  </div>
                  <div class="col-md-12">
                    <label class="form-label" for="page1_heading">Page 1 Heading <span class="text-danger">*</span></label>
                    <input class="form-control @error('page1_heading') is-invalid @enderror" id="page1_heading" type="text" name="page1_heading" value="{{ old('page1_heading', $drhp->page1_heading) }}" required>
                    @error('page1_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="page1_content">Page 1 Content <span class="text-danger">*</span></label>
                    <textarea class="form-control editor @error('page1_content') is-invalid @enderror" id="page1_content" name="page1_content" rows="6">{{ old('page1_content', $drhp->page1_content) }}</textarea>
                    @error('page1_content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-12"><div class="drhp-sec">Disclaimer Page 2</div></div>
                  <div class="col-md-6">
                    <label class="form-label" for="banner_image_2">Page 2 Banner Image</label>
                    <input class="form-control @error('banner_image_2') is-invalid @enderror" id="banner_image_2" type="file" name="banner_image_2" accept="image/*">
                    @error('banner_image_2')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB &nbsp;|&nbsp; @if($drhp->banner_image_2) Leave empty to keep current. @else Leave empty to use the default banner. @endif</small>
                    @if($drhp->banner_image_2)
                      <img src="{{ $drhp->banner_image_2_url }}" alt="current page 2 banner" style="height:90px;margin-top:10px;border:1px solid #e6e8f0;border-radius:8px;object-fit:cover;">
                    @endif
                  </div>
                  <div class="col-md-12">
                    <label class="form-label" for="page2_heading">Page 2 Heading <span class="text-danger">*</span></label>
                    <input class="form-control @error('page2_heading') is-invalid @enderror" id="page2_heading" type="text" name="page2_heading" value="{{ old('page2_heading', $drhp->page2_heading) }}" required>
                    @error('page2_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="page2_content">Page 2 Content <span class="text-danger">*</span></label>
                    <textarea class="form-control editor @error('page2_content') is-invalid @enderror" id="page2_content" name="page2_content" rows="5">{{ old('page2_content', $drhp->page2_content) }}</textarea>
                    @error('page2_content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-12"><div class="drhp-sec">DRHP Document</div></div>
                  <div class="col-md-6">
                    <label class="form-label" for="pdf">DRHP PDF <span class="text-danger">*</span></label>
                    <input class="form-control @error('pdf') is-invalid @enderror" id="pdf" type="file" name="pdf" accept="application/pdf,.pdf">
                    @error('pdf')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-secondary d-block mt-1"><b>Allowed:</b> pdf &nbsp;|&nbsp; <b>Max:</b> 20 MB @if($drhp->pdf) &nbsp;|&nbsp; <a href="{{ $drhp->pdf_url }}" target="_blank">View current</a> · Leave empty to keep current.@endif</small>
                  </div>

                  <div class="col-12 text-end mt-3">
                    <a href="{{ route('manage-ipo-drhp.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    <style>.drhp-sec{font-weight:700;color:#2b2f3a;font-size:16px;padding:10px 14px;background:#f6f7fb;border-left:4px solid #4f46e5;border-radius:8px;}</style>
    <script>
        document.querySelectorAll('textarea.editor').forEach(function (el) {
            ClassicEditor.create(el).catch(function (e) { console.error(e); });
        });
    </script>

</body>

</html>
