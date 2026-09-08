@php $c = $career ?? null; @endphp

{{-- Banner --}}
<div class="col-12"><div class="career-sec-title">Banner</div></div>

<div class="col-md-6">
  <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', $c->banner_heading ?? '') }}" placeholder="Enter banner heading" required>
  @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="banner_image">Banner Image @if(!$c)<span class="text-danger">*</span>@endif</label>
  <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'banner_image_preview')" @if(!$c) required @endif>
  @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB @if($c)&nbsp;|&nbsp; Leave empty to keep current.@endif</small>
  <div class="mt-2"><img id="banner_image_preview" src="{{ $c ? $c->assetUrl($c->banner_image) : '' }}" style="max-height:120px; {{ $c && $c->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

{{-- Section --}}
<div class="col-12"><div class="career-sec-title">Section</div></div>

<div class="col-md-6">
  <label class="form-label" for="section_heading">Section Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('section_heading') is-invalid @enderror" id="section_heading" type="text" name="section_heading" value="{{ old('section_heading', $c->section_heading ?? '') }}" placeholder="Enter section heading" required>
  @error('section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="section_image">Section Image @if(!$c)<span class="text-danger">*</span>@endif</label>
  <input class="form-control @error('section_image') is-invalid @enderror" id="section_image" type="file" name="section_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'section_image_preview')" @if(!$c) required @endif>
  @error('section_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB @if($c)&nbsp;|&nbsp; Leave empty to keep current.@endif</small>
  <div class="mt-2"><img id="section_image_preview" src="{{ $c ? $c->assetUrl($c->section_image) : '' }}" style="max-height:120px; {{ $c && $c->section_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-12">
  <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter description">{{ old('description', $c->description ?? '') }}</textarea>
  @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- Job section --}}
<div class="col-12"><div class="career-sec-title">Job Section</div></div>

<div class="col-md-6">
  <label class="form-label" for="job_section_heading">Job Section Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('job_section_heading') is-invalid @enderror" id="job_section_heading" type="text" name="job_section_heading" value="{{ old('job_section_heading', $c->job_section_heading ?? '') }}" placeholder="Enter job section heading" required>
  @error('job_section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
