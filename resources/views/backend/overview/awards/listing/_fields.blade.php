@php $w = $award ?? null; @endphp

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
  <div class="col-12"><h5 class="aw-sec-title">Page Banner</h5></div>

  <div class="col-md-6">
    <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', optional($w)->banner_heading) }}" placeholder="Enter banner heading" required>
    @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" {{ $w ? '' : 'required' }} onchange="previewFile(this,'banner_image_preview')">
    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $w ? ' | Leave empty to keep current.' : '' }}</small>
    <div class="mt-2"><img id="banner_image_preview" src="{{ $w ? $w->assetUrl($w->banner_image) : '' }}" style="max-height:110px; {{ optional($w)->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
  </div>
@endif

{{-- ============ AWARD DETAILS ============ --}}
<div class="col-12"><h5 class="aw-sec-title">Award Details</h5></div>

<div class="col-md-6">
  <label class="form-label" for="awards_category_id">Award Category <span class="text-danger">*</span></label>
  <select class="form-control @error('awards_category_id') is-invalid @enderror" id="awards_category_id" name="awards_category_id" required>
    <option value="">-- Select a category --</option>
    @foreach($categories as $cat)
      <option value="{{ $cat->id }}" {{ old('awards_category_id', optional($w)->awards_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
    @endforeach
  </select>
  @error('awards_category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
  <input class="form-control @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title', optional($w)->title) }}" placeholder="Enter title" required>
  @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="subject">Subject <span class="text-danger">*</span></label>
  <input class="form-control @error('subject') is-invalid @enderror" id="subject" type="text" name="subject" value="{{ old('subject', optional($w)->subject) }}" placeholder="Enter subject" required>
  @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="year">Year</label>
  <input class="form-control @error('year') is-invalid @enderror" id="year" type="text" name="year" value="{{ old('year', optional($w)->year) }}" placeholder="e.g. 2024 or 2017-2018">
  @error('year')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1">Optional — a single year or a range (e.g. 2017-2018).</small>
</div>

<div class="col-md-6">
  <label class="form-label" for="thumbnail_image">Thumbnail Image <span class="text-danger">*</span></label>
  <input class="form-control @error('thumbnail_image') is-invalid @enderror" id="thumbnail_image" type="file" name="thumbnail_image" accept=".jpg,.jpeg,.png,.webp" {{ $w ? '' : 'required' }} onchange="previewFile(this,'thumbnail_image_preview')">
  @error('thumbnail_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $w ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="thumbnail_image_preview" src="{{ $w ? $w->assetUrl($w->thumbnail_image) : '' }}" style="max-height:100px; {{ optional($w)->thumbnail_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-md-6">
  <label class="form-label" for="main_image">Main Image <span class="text-danger">*</span></label>
  <input class="form-control @error('main_image') is-invalid @enderror" id="main_image" type="file" name="main_image" accept=".jpg,.jpeg,.png,.webp" {{ $w ? '' : 'required' }} onchange="previewFile(this,'main_image_preview')">
  @error('main_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $w ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="main_image_preview" src="{{ $w ? $w->assetUrl($w->main_image) : '' }}" style="max-height:100px; {{ optional($w)->main_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>
