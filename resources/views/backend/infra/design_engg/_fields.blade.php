@php
    $r = $record ?? null;
    $seed = old('features');
    if (! $seed) {
        $seed = $r ? $r->features->map(fn ($f) => ['feature' => $f->feature, 'description' => $f->description])->values()->toArray() : [];
    }
    if (empty($seed)) {
        $seed = [['feature' => '', 'description' => '']];
    }
@endphp

{{-- Banner --}}
<div class="col-12"><div class="de-sec-title">Banner</div></div>

<div class="col-md-6">
  <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('banner_heading') is-invalid @enderror" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', $r->banner_heading ?? '') }}" placeholder="Enter banner heading" required>
  @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label" for="banner_image">Banner Image @if(!$r)<span class="text-danger">*</span>@endif</label>
  <input class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'banner_image_preview')" @if(!$r) required @endif>
  @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB @if($r)&nbsp;|&nbsp; Leave empty to keep current.@endif</small>
  <div class="mt-2"><img id="banner_image_preview" src="{{ $r ? $r->assetUrl($r->banner_image) : '' }}" style="max-height:120px; {{ $r && $r->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

{{-- Section --}}
<div class="col-12"><div class="de-sec-title">Section</div></div>

<div class="col-md-12">
  <label class="form-label" for="section_heading">Section Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('section_heading') is-invalid @enderror" id="section_heading" type="text" name="section_heading" value="{{ old('section_heading', $r->section_heading ?? '') }}" placeholder="Enter section heading" required>
  @error('section_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter description">{{ old('description', $r->description ?? '') }}</textarea>
  @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- Features --}}
<div class="col-12"><div class="de-sec-title">Features</div></div>

<div class="col-md-6">
  <label class="form-label" for="features_heading">Features Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('features_heading') is-invalid @enderror" id="features_heading" type="text" name="features_heading" value="{{ old('features_heading', $r->features_heading ?? '') }}" placeholder="Enter features heading" required>
  @error('features_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Features <span class="text-danger">*</span></label>
    <button type="button" class="btn btn-sm btn-primary" id="deAddRow">+ Add More</button>
  </div>
  @error('features')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
  <div class="table-responsive">
    <table class="table table-bordered align-middle" id="deFeaturesTable">
      <thead>
        <tr>
          <th style="width:30%;">Feature <span class="text-danger">*</span></th>
          <th>Description <span class="text-danger">*</span></th>
          <th style="width:80px;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody id="deFeaturesBody">
        @foreach($seed as $i => $row)
          <tr>
            <td><input type="text" class="form-control" name="features[{{ $i }}][feature]" value="{{ $row['feature'] ?? '' }}" placeholder="Feature"></td>
            <td><textarea class="form-control de-feature-editor" name="features[{{ $i }}][description]" rows="3" placeholder="Feature description">{{ $row['description'] ?? '' }}</textarea></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger de-remove-row">&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- ============ TEAM IMAGES (multi-image gallery) ============ --}}
<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Team Images</label>
    <button type="button" class="btn btn-sm btn-primary" id="deImgAddRow" data-next-index="{{ $r ? $r->teamImages->count() : 0 }}">+ Add More</button>
  </div>
  <small class="text-secondary d-block mb-2">Images shown in the row below the features (jpg, jpeg, png, webp, svg &nbsp;|&nbsp; Max 2 MB each).</small>
  <div class="table-responsive">
    <table class="table table-bordered align-middle" id="deImgTable">
      <thead>
        <tr><th style="width:60%;">Image</th><th style="width:120px;">Preview</th><th style="width:70px;" class="text-center">Action</th></tr>
      </thead>
      <tbody id="deImgBody">
        @php $teamImgs = $r ? $r->teamImages : collect(); @endphp
        @foreach($teamImgs as $i => $img)
          <tr>
            <td>
              <input type="hidden" name="team_images[{{ $i }}][existing_image]" value="{{ $img->image }}">
              <input type="file" class="form-control" name="team_images[{{ $i }}][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="deImgPreview(this)">
              <small class="text-secondary">Leave empty to keep current.</small>
            </td>
            <td><img src="{{ $img->image_url }}" class="de-img-prev" style="max-height:56px;border:1px solid #ddd;padding:3px;border-radius:6px;"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger de-img-remove">&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<template id="deImgRowTpl">
  <tr>
    <td>
      <input type="hidden" name="team_images[__IDX__][existing_image]" value="">
      <input type="file" class="form-control" name="team_images[__IDX__][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="deImgPreview(this)">
    </td>
    <td><img class="de-img-prev" style="max-height:56px;border:1px solid #ddd;padding:3px;border-radius:6px;display:none;"></td>
    <td class="text-center"><button type="button" class="btn btn-sm btn-danger de-img-remove">&times;</button></td>
  </tr>
</template>
