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

<div class="col-md-6">
  <label class="form-label" for="features_image">Features Image @if(!$r)<span class="text-danger">*</span>@endif</label>
  <input class="form-control @error('features_image') is-invalid @enderror" id="features_image" type="file" name="features_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'features_image_preview')" @if(!$r) required @endif>
  @error('features_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB @if($r)&nbsp;|&nbsp; Leave empty to keep current.@endif</small>
  <div class="mt-2"><img id="features_image_preview" src="{{ $r ? $r->assetUrl($r->features_image) : '' }}" style="max-height:120px; {{ $r && $r->features_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
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
