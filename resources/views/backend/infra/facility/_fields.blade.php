@php
    $r = $record ?? null;
    $seedFeatures  = old('features',  $r ? $r->features->map(fn($x)=>['title'=>$x->title,'description'=>$x->description,'existing_image'=>$x->image])->values()->toArray() : []);
    $seedCounters  = old('counters',  $r ? $r->counters->map(fn($x)=>['count'=>$x->count,'suffix'=>$x->suffix,'label'=>$x->label])->values()->toArray() : []);
    $seedGalleries = old('galleries', $r ? $r->galleries->map(fn($x)=>['existing_image'=>$x->image,'heading'=>$x->heading])->values()->toArray() : []);
    $seedStrengths = old('strengths', $r ? $r->strengths->map(fn($x)=>['title'=>$x->title,'description'=>$x->description])->values()->toArray() : []);
    if(empty($seedFeatures))  $seedFeatures  = [['title'=>'','description'=>'','existing_image'=>'']];
    if(empty($seedCounters))  $seedCounters  = [['count'=>'','suffix'=>'','label'=>'']];
    if(empty($seedGalleries)) $seedGalleries = [['existing_image'=>'']];
    if(empty($seedStrengths)) $seedStrengths = [['title'=>'','description'=>'']];
@endphp

{{-- Banner --}}
<div class="col-12"><div class="fac-sec-title">Banner</div></div>
<div class="col-md-6">
  <label class="form-label" for="banner_heading">Banner Heading <span class="text-danger">*</span></label>
  <input class="form-control" id="banner_heading" type="text" name="banner_heading" value="{{ old('banner_heading', $r->banner_heading ?? '') }}" placeholder="Enter banner heading" required>
  @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
  <label class="form-label" for="banner_image">Banner Image @if(!$r)<span class="text-danger">*</span>@endif</label>
  <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'banner_image_preview')" @if(!$r) required @endif>
  @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg | <b>Max:</b> 2 MB @if($r)| Leave empty to keep current.@endif</small>
  <div class="mt-2"><img id="banner_image_preview" src="{{ $r ? $r->assetUrl($r->banner_image) : '' }}" style="max-height:110px; {{ $r && $r->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

{{-- About --}}
<div class="col-12"><div class="fac-sec-title">About Section</div></div>
<div class="col-12">
  <label class="form-label" for="about_heading">About Heading <span class="text-danger">*</span></label>
  <textarea class="form-control" id="about_heading" name="about_heading" rows="2" placeholder="Enter the large left-side heading">{{ old('about_heading', $r->about_heading ?? '') }}</textarea>
  @error('about_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-12">
  <label class="form-label" for="about_description">About Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor" id="about_description" name="about_description" rows="4" placeholder="Enter the right-side description">{{ old('about_description', $r->about_description ?? '') }}</textarea>
  @error('about_description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- Feature cards --}}
<div class="col-12"><div class="fac-sec-title">Feature Cards</div></div>
<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Feature Cards <span class="text-danger">*</span></label>
    <button type="button" class="btn btn-sm btn-primary" data-add="features">+ Add More</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th style="width:180px;">Icon</th><th style="width:25%;">Title</th><th>Description</th><th style="width:70px;" class="text-center">Action</th></tr></thead>
      <tbody data-body="features">
        @foreach($seedFeatures as $i => $row)
          <tr>
            <td>
              <input type="file" class="form-control" name="features[{{ $i }}][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="facPreviewRow(this)">
              <input type="hidden" name="features[{{ $i }}][existing_image]" value="{{ $row['existing_image'] ?? '' }}">
              <div class="mt-2"><img class="fac-row-preview" src="{{ !empty($row['existing_image']) && $r ? $r->assetUrl($row['existing_image']) : '' }}" style="max-height:50px; {{ !empty($row['existing_image']) ? '' : 'display:none;' }} background:#f5f5f5; border:1px solid #ddd; padding:3px; border-radius:6px;" alt=""></div>
            </td>
            <td><input type="text" class="form-control" name="features[{{ $i }}][title]" value="{{ $row['title'] ?? '' }}" placeholder="Title"></td>
            <td><textarea class="form-control" name="features[{{ $i }}][description]" rows="2" placeholder="Description">{{ $row['description'] ?? '' }}</textarea></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Counters --}}
<div class="col-12"><div class="fac-sec-title">Counters</div></div>
<div class="col-md-6">
  <label class="form-label" for="counter_image">Counter Section Image</label>
  <input class="form-control" id="counter_image" type="file" name="counter_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'counter_image_preview')">
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg | <b>Max:</b> 2 MB</small>
  <div class="mt-2"><img id="counter_image_preview" src="{{ $r ? $r->assetUrl($r->counter_image) : '' }}" style="max-height:110px; {{ $r && $r->counter_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>
<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Counters <span class="text-danger">*</span></label>
    <button type="button" class="btn btn-sm btn-primary" data-add="counters">+ Add More</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th style="width:20%;">Count</th><th style="width:20%;">Suffix</th><th>Label</th><th style="width:70px;" class="text-center">Action</th></tr></thead>
      <tbody data-body="counters">
        @foreach($seedCounters as $i => $row)
          <tr>
            <td><input type="text" class="form-control" name="counters[{{ $i }}][count]" value="{{ $row['count'] ?? '' }}" placeholder="e.g. 500000"></td>
            <td><input type="text" class="form-control" name="counters[{{ $i }}][suffix]" value="{{ $row['suffix'] ?? '' }}" placeholder="e.g. + or mm"></td>
            <td><input type="text" class="form-control" name="counters[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" placeholder="Label"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Process --}}
<div class="col-12"><div class="fac-sec-title">Manufacturing Process</div></div>
<div class="col-md-12">
  <label class="form-label" for="process_heading">Process Heading <span class="text-danger">*</span></label>
  <input class="form-control" id="process_heading" type="text" name="process_heading" value="{{ old('process_heading', $r->process_heading ?? '') }}" placeholder="Enter process heading" required>
  @error('process_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-12">
  <label class="form-label" for="process_description">Process Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor" id="process_description" name="process_description" rows="4" placeholder="Enter process description">{{ old('process_description', $r->process_description ?? '') }}</textarea>
  @error('process_description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Process Gallery Images</label>
    <button type="button" class="btn btn-sm btn-primary" data-add="galleries">+ Add More</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th style="width:220px;">Image</th><th>Heading (optional)</th><th style="width:70px;" class="text-center">Action</th></tr></thead>
      <tbody data-body="galleries">
        @foreach($seedGalleries as $i => $row)
          <tr>
            <td>
              <input type="file" class="form-control" name="galleries[{{ $i }}][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="facPreviewRow(this)">
              <input type="hidden" name="galleries[{{ $i }}][existing_image]" value="{{ $row['existing_image'] ?? '' }}">
              <div class="mt-2"><img class="fac-row-preview" src="{{ !empty($row['existing_image']) && $r ? $r->assetUrl($row['existing_image']) : '' }}" style="max-height:70px; {{ !empty($row['existing_image']) ? '' : 'display:none;' }} border:1px solid #ddd; padding:3px; border-radius:6px;" alt=""></div>
            </td>
            <td><input type="text" class="form-control" name="galleries[{{ $i }}][heading]" value="{{ $row['heading'] ?? '' }}" placeholder="e.g. MS and Sheet Metal Fabrication Unit"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Equipment strength --}}
<div class="col-12"><div class="fac-sec-title">Equipment Strength</div></div>
<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Strength Blocks <span class="text-danger">*</span></label>
    <button type="button" class="btn btn-sm btn-primary" data-add="strengths">+ Add More</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th style="width:28%;">Title</th><th>Description</th><th style="width:70px;" class="text-center">Action</th></tr></thead>
      <tbody data-body="strengths">
        @foreach($seedStrengths as $i => $row)
          <tr>
            <td><input type="text" class="form-control" name="strengths[{{ $i }}][title]" value="{{ $row['title'] ?? '' }}" placeholder="Title"></td>
            <td><textarea class="form-control fac-editor" name="strengths[{{ $i }}][description]" rows="3" placeholder="Description">{{ $row['description'] ?? '' }}</textarea></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- ============ FAÇADE TESTING FACILITY ============ --}}
<div class="col-12"><div class="fac-sec-title">Façade Testing Facility</div></div>

{{-- Block 1 --}}
<div class="col-12"><small class="text-secondary fw-bold">Block 1 — Intro (heading + text + 2 images)</small></div>
<div class="col-md-12">
  <label class="form-label" for="testing_heading">Heading</label>
  <input class="form-control" id="testing_heading" type="text" name="testing_heading" value="{{ old('testing_heading', $r->testing_heading ?? '') }}" placeholder="e.g. In-House Façade Testing Facility">
</div>
<div class="col-12">
  <label class="form-label" for="testing_content">Content</label>
  <textarea class="form-control editor" id="testing_content" name="testing_content" rows="4">{{ old('testing_content', $r->testing_content ?? '') }}</textarea>
</div>
<div class="col-md-6">
  <label class="form-label" for="testing_image1">Image 1</label>
  <input class="form-control" id="testing_image1" type="file" name="testing_image1" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'testing_image1_preview')">
  <div class="mt-2"><img id="testing_image1_preview" src="{{ $r ? $r->assetUrl($r->testing_image1) : '' }}" style="max-height:100px; {{ $r && $r->testing_image1 ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>
<div class="col-md-6">
  <label class="form-label" for="testing_image2">Image 2</label>
  <input class="form-control" id="testing_image2" type="file" name="testing_image2" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'testing_image2_preview')">
  <div class="mt-2"><img id="testing_image2_preview" src="{{ $r ? $r->assetUrl($r->testing_image2) : '' }}" style="max-height:100px; {{ $r && $r->testing_image2 ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

{{-- Block 2 --}}
<div class="col-12"><small class="text-secondary fw-bold">Block 2 — Calibration (2 images + text)</small></div>
<div class="col-12">
  <label class="form-label" for="testing2_content">Content</label>
  <textarea class="form-control editor" id="testing2_content" name="testing2_content" rows="3">{{ old('testing2_content', $r->testing2_content ?? '') }}</textarea>
</div>
<div class="col-md-6">
  <label class="form-label" for="testing2_image1">Image 1 (large)</label>
  <input class="form-control" id="testing2_image1" type="file" name="testing2_image1" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'testing2_image1_preview')">
  <div class="mt-2"><img id="testing2_image1_preview" src="{{ $r ? $r->assetUrl($r->testing2_image1) : '' }}" style="max-height:100px; {{ $r && $r->testing2_image1 ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>
<div class="col-md-6">
  <label class="form-label" for="testing2_image2">Image 2</label>
  <input class="form-control" id="testing2_image2" type="file" name="testing2_image2" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'testing2_image2_preview')">
  <div class="mt-2"><img id="testing2_image2_preview" src="{{ $r ? $r->assetUrl($r->testing2_image2) : '' }}" style="max-height:100px; {{ $r && $r->testing2_image2 ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

{{-- Block 3 --}}
<div class="col-12"><small class="text-secondary fw-bold">Block 3 — Certification (heading + certificate image)</small></div>
<div class="col-md-8">
  <label class="form-label" for="nabl_heading">Heading</label>
  <textarea class="form-control" id="nabl_heading" name="nabl_heading" rows="2" placeholder="e.g. …is NABL Certified.">{{ old('nabl_heading', $r->nabl_heading ?? '') }}</textarea>
</div>
<div class="col-md-4">
  <label class="form-label" for="nabl_image">Certificate Image</label>
  <input class="form-control" id="nabl_image" type="file" name="nabl_image" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'nabl_image_preview')">
  <div class="mt-2"><img id="nabl_image_preview" src="{{ $r ? $r->assetUrl($r->nabl_image) : '' }}" style="max-height:100px; {{ $r && $r->nabl_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>

{{-- Block 4 --}}
<div class="col-12"><small class="text-secondary fw-bold">Block 4 — Precision Engineering (heading + text)</small></div>
<div class="col-md-12">
  <label class="form-label" for="precision_heading">Heading</label>
  <input class="form-control" id="precision_heading" type="text" name="precision_heading" value="{{ old('precision_heading', $r->precision_heading ?? '') }}" placeholder="e.g. Precision Engineering and Advanced Instrumentation">
</div>
<div class="col-12">
  <label class="form-label" for="precision_content">Content</label>
  <textarea class="form-control editor" id="precision_content" name="precision_content" rows="4">{{ old('precision_content', $r->precision_content ?? '') }}</textarea>
</div>

{{-- Block 5 --}}
<div class="col-12"><small class="text-secondary fw-bold">Block 5 — Project Mock-ups (caption + 2 images)</small></div>
<div class="col-12">
  <label class="form-label" for="mockup_caption">Caption</label>
  <input class="form-control" id="mockup_caption" type="text" name="mockup_caption" value="{{ old('mockup_caption', $r->mockup_caption ?? '') }}" placeholder="e.g. Some of our project testing mock-ups are as shown below:">
</div>
<div class="col-md-6">
  <label class="form-label" for="mockup_image1">Image 1</label>
  <input class="form-control" id="mockup_image1" type="file" name="mockup_image1" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'mockup_image1_preview')">
  <div class="mt-2"><img id="mockup_image1_preview" src="{{ $r ? $r->assetUrl($r->mockup_image1) : '' }}" style="max-height:100px; {{ $r && $r->mockup_image1 ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>
<div class="col-md-6">
  <label class="form-label" for="mockup_image2">Image 2 (wide)</label>
  <input class="form-control" id="mockup_image2" type="file" name="mockup_image2" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewFile(this,'mockup_image2_preview')">
  <div class="mt-2"><img id="mockup_image2_preview" src="{{ $r ? $r->assetUrl($r->mockup_image2) : '' }}" style="max-height:100px; {{ $r && $r->mockup_image2 ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;" alt="preview"></div>
</div>
