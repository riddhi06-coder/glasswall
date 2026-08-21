@php $n = $innovation ?? null; @endphp

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
  <div class="col-12"><h5 class="inv-sec-title">Page Banner</h5></div>

  <div class="col-md-6">
    <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', optional($n)->banner_heading) }}" placeholder="Enter banner heading" required>
    @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" {{ $n ? '' : 'required' }} onchange="previewFile(this,'banner_image_preview')">
    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $n ? ' | Leave empty to keep current.' : '' }}</small>
    <div class="mt-2"><img id="banner_image_preview" src="{{ $n ? $n->assetUrl($n->banner_image) : '' }}" style="max-height:110px; {{ optional($n)->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
  </div>
@endif

{{-- ============ INNOVATION DETAILS ============ --}}
<div class="col-12"><h5 class="inv-sec-title">Innovation Details</h5></div>

<div class="col-md-6">
  <label class="form-label" for="heading">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('heading') is-invalid @enderror" id="heading" type="text" name="heading" value="{{ old('heading', optional($n)->heading) }}" placeholder="Enter heading" required>
  @error('heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
  <input class="form-control @error('image') is-invalid @enderror" id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" {{ $n ? '' : 'required' }} onchange="previewFile(this,'image_preview')">
  @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $n ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="image_preview" src="{{ $n ? $n->assetUrl($n->image) : '' }}" style="max-height:110px; {{ optional($n)->image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-12">
  <label class="form-label" for="feature">Feature <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('feature') is-invalid @enderror" id="feature" name="feature" rows="4" placeholder="Enter feature">{!! old('feature', optional($n)->feature) !!}</textarea>
  @error('feature')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
