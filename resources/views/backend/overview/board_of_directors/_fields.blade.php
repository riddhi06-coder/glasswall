@php $d = $director ?? null; @endphp

@if($errors->any())
  <div class="col-12">
    <div class="alert alert-danger mb-0">
      <ul class="mb-0">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  </div>
@endif

@if($isFirst)
  {{-- ============ PAGE BANNER (first record only) ============ --}}
  <div class="col-12"><h5 class="bod-sec-title">Page Banner</h5></div>

  <div class="col-md-6">
    <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', optional($d)->banner_heading) }}" placeholder="Enter banner heading" required>
    @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" {{ $d ? '' : 'required' }} onchange="previewFile(this,'banner_image_preview')">
    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $d ? ' | Leave empty to keep current.' : '' }}</small>
    <div class="mt-2"><img id="banner_image_preview" src="{{ $d ? $d->assetUrl($d->banner_image) : '' }}" style="max-height:110px; {{ optional($d)->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
  </div>

  <div class="col-12">
    <label class="form-label" for="banner_description">Description <span class="text-danger">*</span></label>
    <textarea class="form-control editor @error('banner_description') is-invalid @enderror" id="banner_description" name="banner_description" rows="3" placeholder="Enter description">{!! old('banner_description', optional($d)->banner_description) !!}</textarea>
    @error('banner_description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>
@endif

{{-- ============ DIRECTOR DETAILS ============ --}}
<div class="col-12"><h5 class="bod-sec-title">Director Details</h5></div>

<div class="col-md-6">
  <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
  <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name', optional($d)->name) }}" placeholder="Enter name" required>
  @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="designation">Designation <span class="text-danger">*</span></label>
  <input class="form-control @error('designation') is-invalid @enderror" id="designation" type="text" name="designation" value="{{ old('designation', optional($d)->designation) }}" placeholder="e.g. Managing Director" required>
  @error('designation')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
  <input class="form-control @error('image') is-invalid @enderror" id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" {{ $d ? '' : 'required' }} onchange="previewFile(this,'image_preview')">
  @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $d ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="image_preview" src="{{ $d ? $d->assetUrl($d->image) : '' }}" style="max-height:110px; {{ optional($d)->image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-12">
  <label class="form-label" for="info">Info <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('info') is-invalid @enderror" id="info" name="info" rows="4" placeholder="Enter director info">{!! old('info', optional($d)->info) !!}</textarea>
  @error('info')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
