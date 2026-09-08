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

{{-- ============ CORPORATE FILM SECTION ============ --}}
<div class="col-12"><h5 class="media-sec-title">Corporate Film Section</h5></div>

<div class="col-md-4">
  <label class="form-label" for="section_subtitle">Section Eyebrow</label>
  <input class="form-control" id="section_subtitle" type="text" name="section_subtitle" value="{{ old('section_subtitle', optional($m)->section_subtitle) }}" placeholder="e.g. Our Products">
</div>
<div class="col-md-8">
  <label class="form-label" for="section_heading">Section Heading</label>
  <input class="form-control" id="section_heading" type="text" name="section_heading" value="{{ old('section_heading', optional($m)->section_heading) }}" placeholder="e.g. Vision, Engineered: GWS Corporate Film">
</div>
<div class="col-12">
  <label class="form-label" for="section_intro">Section Intro</label>
  <textarea class="form-control" id="section_intro" name="section_intro" rows="3" placeholder="Short paragraph shown under the heading">{{ old('section_intro', optional($m)->section_intro) }}</textarea>
</div>

{{-- ============ DOCUMENTS (PDF cards) ============ --}}
<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="media-sec-title mb-0">Documents (PDF cards)</h5>
    <button type="button" class="btn btn-sm btn-primary" id="doc-add-more" data-next-index="{{ $m ? $m->documents->count() : 0 }}">+ Add More</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle" id="docTable">
      <thead>
        <tr>
          <th>Title / Caption</th>
          <th style="width:28%;">PDF</th>
          <th style="width:80px;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody id="docBody">
        @php $docs = $m ? $m->documents : collect(); @endphp
        @foreach($docs as $i => $doc)
          <tr>
            <td>
              <input type="hidden" name="doc_id[{{ $i }}]" value="{{ $doc->id }}">
              <textarea class="form-control" name="doc_title[{{ $i }}]" rows="2" placeholder="Document title / caption">{{ $doc->title }}</textarea>
            </td>
            <td>
              <input class="form-control" type="file" name="doc_pdf[{{ $i }}]" accept=".pdf">
              @if($doc->pdf)<small class="d-block mt-1"><a href="{{ $doc->pdf_url }}" target="_blank">View current</a> · leave empty to keep</small>@endif
            </td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger doc-remove">&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <small class="text-secondary d-block">Each row renders as a PDF card under the video. Max 20 MB per PDF.</small>
</div>

{{-- Template for a new document row (cloned by JS) --}}
<template id="doc-row-template">
  <tr>
    <td>
      <input type="hidden" name="doc_id[__IDX__]" value="">
      <textarea class="form-control" name="doc_title[__IDX__]" rows="2" placeholder="e.g. Construction Week, October 2025 — Transforming Skylines…"></textarea>
    </td>
    <td>
      <input class="form-control" type="file" name="doc_pdf[__IDX__]" accept=".pdf">
    </td>
    <td class="text-center"><button type="button" class="btn btn-sm btn-danger doc-remove">&times;</button></td>
  </tr>
</template>
