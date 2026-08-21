@php $a = $about ?? null; @endphp

@if($errors->any())
  <div class="col-12">
    <div class="alert alert-danger mb-0">
      <ul class="mb-0">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  </div>
@endif

{{-- ============ BANNER & INTRO ============ --}}
<div class="col-12"><h5 class="about-sec-title">Banner &amp; Intro</h5></div>

<div class="col-md-6">
  <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', optional($a)->banner_heading) }}" placeholder="Enter banner heading" required>
  @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="banner_video">Banner Video <span class="text-danger">*</span></label>
  <input class="form-control @error('banner_video') is-invalid @enderror" id="banner_video" type="file" name="banner_video" accept="video/mp4,video/webm,video/ogg,video/quicktime" {{ $a ? '' : 'required' }} onchange="previewVideo(this,'banner_video_preview')">
  @error('banner_video')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> mp4, webm, ogg, mov &nbsp;|&nbsp; <b>Max:</b> 30 MB{{ $a ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2">
    <video id="banner_video_preview" src="{{ $a ? $a->assetUrl($a->banner_video) : '' }}" style="max-height:140px; {{ optional($a)->banner_video ? '' : 'display:none;' }} border:1px solid #ddd; border-radius:6px;" controls></video>
  </div>
</div>

<div class="col-md-6">
  <label class="form-label" for="section_heading">Section Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('section_heading') is-invalid @enderror" id="section_heading" type="text" name="section_heading" value="{{ old('section_heading', optional($a)->section_heading) }}" placeholder="Enter section heading" required>
  @error('section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="section_image">Section Image <span class="text-danger">*</span></label>
  <input class="form-control @error('section_image') is-invalid @enderror" id="section_image" type="file" name="section_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $a ? '' : 'required' }} onchange="previewFile(this,'section_image_preview')">
  @error('section_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $a ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="section_image_preview" class="file-preview" src="{{ $a ? $a->assetUrl($a->section_image) : '' }}" style="max-height:110px; {{ optional($a)->section_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-12">
  <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter description">{!! old('description', optional($a)->description) !!}</textarea>
  @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- ============ VISION SECTION (wrapper) ============ --}}
<div class="col-12"><h5 class="about-sec-title">Vision Section</h5></div>

<div class="col-md-6">
  <label class="form-label" for="vision_section_heading">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('vision_section_heading') is-invalid @enderror" id="vision_section_heading" type="text" name="vision_section_heading" value="{{ old('vision_section_heading', optional($a)->vision_section_heading) }}" placeholder="Enter section heading" required>
  @error('vision_section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label" for="vision_section_description">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('vision_section_description') is-invalid @enderror" id="vision_section_description" name="vision_section_description" rows="3" placeholder="Enter description">{!! old('vision_section_description', optional($a)->vision_section_description) !!}</textarea>
  @error('vision_section_description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- ---- Vision block ---- --}}
<div class="col-12"><h6 class="about-sub-title">Vision</h6></div>

<div class="col-md-6">
  <label class="form-label" for="vision_logo">Vision Logo <span class="text-danger">*</span></label>
  <input class="form-control @error('vision_logo') is-invalid @enderror" id="vision_logo" type="file" name="vision_logo" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $a ? '' : 'required' }} onchange="previewFile(this,'vision_logo_preview')">
  @error('vision_logo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $a ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="vision_logo_preview" class="file-preview" src="{{ $a ? $a->assetUrl($a->vision_logo) : '' }}" style="max-height:90px; {{ optional($a)->vision_logo ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-md-6">
  <label class="form-label" for="vision_image">Vision Image <span class="text-danger">*</span></label>
  <input class="form-control @error('vision_image') is-invalid @enderror" id="vision_image" type="file" name="vision_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $a ? '' : 'required' }} onchange="previewFile(this,'vision_image_preview')">
  @error('vision_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $a ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="vision_image_preview" class="file-preview" src="{{ $a ? $a->assetUrl($a->vision_image) : '' }}" style="max-height:90px; {{ optional($a)->vision_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-md-6">
  <label class="form-label" for="vision_heading">Vision Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('vision_heading') is-invalid @enderror" id="vision_heading" type="text" name="vision_heading" value="{{ old('vision_heading', optional($a)->vision_heading) }}" placeholder="Enter vision heading" required>
  @error('vision_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="vision_title">Vision Title <span class="text-danger">*</span></label>
  <input class="form-control @error('vision_title') is-invalid @enderror" id="vision_title" type="text" name="vision_title" value="{{ old('vision_title', optional($a)->vision_title) }}" placeholder="Enter vision title" required>
  @error('vision_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label" for="vision_desc">Vision Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('vision_desc') is-invalid @enderror" id="vision_desc" name="vision_desc" rows="3" placeholder="Enter vision description">{!! old('vision_desc', optional($a)->vision_desc) !!}</textarea>
  @error('vision_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- ---- Mission block ---- --}}
<div class="col-12"><h6 class="about-sub-title">Mission</h6></div>

<div class="col-md-6">
  <label class="form-label" for="mission_logo">Mission Logo <span class="text-danger">*</span></label>
  <input class="form-control @error('mission_logo') is-invalid @enderror" id="mission_logo" type="file" name="mission_logo" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $a ? '' : 'required' }} onchange="previewFile(this,'mission_logo_preview')">
  @error('mission_logo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $a ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="mission_logo_preview" class="file-preview" src="{{ $a ? $a->assetUrl($a->mission_logo) : '' }}" style="max-height:90px; {{ optional($a)->mission_logo ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-md-6">
  <label class="form-label" for="mission_image">Mission Image <span class="text-danger">*</span></label>
  <input class="form-control @error('mission_image') is-invalid @enderror" id="mission_image" type="file" name="mission_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $a ? '' : 'required' }} onchange="previewFile(this,'mission_image_preview')">
  @error('mission_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $a ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="mission_image_preview" class="file-preview" src="{{ $a ? $a->assetUrl($a->mission_image) : '' }}" style="max-height:90px; {{ optional($a)->mission_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-md-6">
  <label class="form-label" for="mission_heading">Mission Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('mission_heading') is-invalid @enderror" id="mission_heading" type="text" name="mission_heading" value="{{ old('mission_heading', optional($a)->mission_heading) }}" placeholder="Enter mission heading" required>
  @error('mission_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="mission_title">Mission Title <span class="text-danger">*</span></label>
  <input class="form-control @error('mission_title') is-invalid @enderror" id="mission_title" type="text" name="mission_title" value="{{ old('mission_title', optional($a)->mission_title) }}" placeholder="Enter mission title" required>
  @error('mission_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label" for="mission_desc">Mission Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('mission_desc') is-invalid @enderror" id="mission_desc" name="mission_desc" rows="3" placeholder="Enter mission description">{!! old('mission_desc', optional($a)->mission_desc) !!}</textarea>
  @error('mission_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- ============ CORE VALUES SECTION ============ --}}
<div class="col-12"><h5 class="about-sec-title">Core Values Section</h5></div>

<div class="col-md-6">
  <label class="form-label" for="core_title">Title <span class="text-danger">*</span></label>
  <input class="form-control @error('core_title') is-invalid @enderror" id="core_title" type="text" name="core_title" value="{{ old('core_title', optional($a)->core_title) }}" placeholder="Enter title" required>
  @error('core_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="core_image">Image <span class="text-danger">*</span></label>
  <input class="form-control @error('core_image') is-invalid @enderror" id="core_image" type="file" name="core_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $a ? '' : 'required' }} onchange="previewFile(this,'core_image_preview')">
  @error('core_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $a ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="core_image_preview" class="file-preview" src="{{ $a ? $a->assetUrl($a->core_image) : '' }}" style="max-height:110px; {{ optional($a)->core_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

<div class="col-12">
  <label class="form-label" for="core_description">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('core_description') is-invalid @enderror" id="core_description" name="core_description" rows="4" placeholder="Enter description">{!! old('core_description', optional($a)->core_description) !!}</textarea>
  @error('core_description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
