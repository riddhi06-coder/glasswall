@php
    $r = $record ?? null;
    $seed = old('pointers');
    if (! $seed) {
        $seed = $r ? $r->pointers->map(fn ($p) => ['pointer' => $p->pointer, 'existing_image' => $p->image])->values()->toArray() : [];
    }
    if (empty($seed)) {
        $seed = [['pointer' => '', 'existing_image' => '']];
    }
@endphp

{{-- Banner --}}
<div class="col-12"><div class="pm-sec-title">Banner</div></div>

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

{{-- Intro --}}
<div class="col-12"><div class="pm-sec-title">Introduction</div></div>

<div class="col-12">
  <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter description">{{ old('description', $r->description ?? '') }}</textarea>
  @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- Pointers --}}
<div class="col-12"><div class="pm-sec-title">Pointers</div></div>

<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Pointers <span class="text-danger">*</span></label>
    <button type="button" class="btn btn-sm btn-primary" id="pmAddRow">+ Add More</button>
  </div>
  @error('pointers')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
  <div class="table-responsive">
    <table class="table table-bordered align-middle" id="pmPointersTable">
      <thead>
        <tr>
          <th style="width:210px;">Icon</th>
          <th>Pointer <span class="text-danger">*</span></th>
          <th style="width:80px;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody id="pmPointersBody">
        @foreach($seed as $i => $row)
          @php $img = $row['existing_image'] ?? null; @endphp
          <tr>
            <td>
              <input type="file" class="form-control" name="pointers[{{ $i }}][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="pmPreviewRow(this)">
              <input type="hidden" name="pointers[{{ $i }}][existing_image]" value="{{ $img }}">
              <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg | <b>Max:</b> 2 MB</small>
              <div class="mt-2"><img class="pm-row-preview" src="{{ $img ? $r->assetUrl($img) : '' }}" style="max-height:60px; {{ $img ? '' : 'display:none;' }} background:#f5f5f5; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="icon"></div>
            </td>
            <td><textarea class="form-control" name="pointers[{{ $i }}][pointer]" rows="3" placeholder="Enter pointer text">{{ $row['pointer'] ?? '' }}</textarea></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger pm-remove-row">&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
