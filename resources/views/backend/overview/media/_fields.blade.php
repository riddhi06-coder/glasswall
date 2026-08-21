@php $m = $media ?? null; @endphp

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
  <div class="col-12"><h5 class="media-sec-title">Page Banner</h5></div>

  <div class="col-md-6">
    <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', optional($m)->banner_heading) }}" placeholder="Enter banner heading" required>
    @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label" for="banner_image">Banner Image <span class="text-danger">*</span></label>
    <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" {{ $m ? '' : 'required' }} onchange="previewFile(this,'banner_image_preview')">
    @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $m ? ' | Leave empty to keep current.' : '' }}</small>
    <div class="mt-2"><img id="banner_image_preview" src="{{ $m ? $m->assetUrl($m->banner_image) : '' }}" style="max-height:110px; {{ optional($m)->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
  </div>
@endif

{{-- ============ VIDEO ============ --}}
<div class="col-12"><h5 class="media-sec-title">Video</h5></div>

<div class="col-md-6">
  <label class="form-label" for="video">Video Upload <span class="text-danger">*</span></label>
  <input class="form-control @error('video') is-invalid @enderror" id="video" type="file" name="video" accept="video/mp4,video/webm,video/ogg,video/quicktime" {{ $m ? '' : 'required' }} onchange="previewVideo(this,'video_preview')">
  @error('video')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> mp4, webm, ogg, mov &nbsp;|&nbsp; <b>Max:</b> 30 MB{{ $m ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2">
    <video id="video_preview" src="{{ $m ? $m->assetUrl($m->video) : '' }}" style="max-height:160px; {{ optional($m)->video ? '' : 'display:none;' }} border:1px solid #ddd; border-radius:6px;" controls></video>
  </div>
</div>
