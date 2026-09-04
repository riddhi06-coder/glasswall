@php $e = $esg ?? null; @endphp

@if($errors->any())
  <div class="col-12">
    <div class="alert alert-danger mb-0">
      <ul class="mb-0">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  </div>
@endif

{{-- ============ BANNER ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Banner</h5></div>

<div class="col-md-6">
  <label class="form-label">Banner Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('banner_heading') is-invalid @enderror" type="text" name="banner_heading" value="{{ old('banner_heading', optional($e)->banner_heading) }}" placeholder="Enter banner heading" required>
  @error('banner_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Banner Image <span class="text-danger">*</span></label>
  <input class="form-control @error('banner_image') is-invalid @enderror" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $e ? '' : 'required' }} onchange="esgPreview(this,'p_banner_image')">
  @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $e ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="p_banner_image" src="{{ $e ? $e->assetUrl($e->banner_image) : '' }}" style="max-height:100px; {{ optional($e)->banner_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;"></div>
</div>

{{-- ============ DIRECTOR MESSAGE ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Director Message Section</h5></div>

<div class="col-md-4">
  <label class="form-label">Image <span class="text-danger">*</span></label>
  <input class="form-control @error('director_image') is-invalid @enderror" type="file" name="director_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $e ? '' : 'required' }} onchange="esgPreview(this,'p_director_image')">
  @error('director_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $e ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="p_director_image" src="{{ $e ? $e->assetUrl($e->director_image) : '' }}" style="max-height:90px; {{ optional($e)->director_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;"></div>
</div>

<div class="col-md-4">
  <label class="form-label">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('director_heading') is-invalid @enderror" type="text" name="director_heading" value="{{ old('director_heading', optional($e)->director_heading) }}" placeholder="Enter heading" required>
  @error('director_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-4">
  <label class="form-label">Name <span class="text-danger">*</span></label>
  <input class="form-control @error('director_name') is-invalid @enderror" type="text" name="director_name" value="{{ old('director_name', optional($e)->director_name) }}" placeholder="Enter name" required>
  @error('director_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-4">
  <label class="form-label">Position <span class="text-danger">*</span></label>
  <input class="form-control @error('director_position') is-invalid @enderror" type="text" name="director_position" value="{{ old('director_position', optional($e)->director_position) }}" placeholder="Enter position" required>
  @error('director_position')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('director_desc') is-invalid @enderror" name="director_desc" rows="3" placeholder="Enter description">{!! old('director_desc', optional($e)->director_desc) !!}</textarea>
  @error('director_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- ============ INNOVATION ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Innovation Section</h5></div>

<div class="col-md-6">
  <label class="form-label">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('innovation_heading') is-invalid @enderror" type="text" name="innovation_heading" value="{{ old('innovation_heading', optional($e)->innovation_heading) }}" placeholder="Enter heading" required>
  @error('innovation_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Background Image <span class="text-danger">*</span></label>
  <input class="form-control @error('innovation_bg_image') is-invalid @enderror" type="file" name="innovation_bg_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $e ? '' : 'required' }} onchange="esgPreview(this,'p_innovation_bg_image')">
  @error('innovation_bg_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $e ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="p_innovation_bg_image" src="{{ $e ? $e->assetUrl($e->innovation_bg_image) : '' }}" style="max-height:90px; {{ optional($e)->innovation_bg_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;"></div>
</div>

@include('backend.overview.esg._table', ['key' => 'innovation_features', 'label' => 'Feature Table', 'cols' => [['image','Image'],['feature','Feature'],['description','Description']]])

{{-- ============ DEVELOPMENT GOALS ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Development Goals Section</h5></div>

<div class="col-md-6">
  <label class="form-label">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('dev_heading') is-invalid @enderror" type="text" name="dev_heading" value="{{ old('dev_heading', optional($e)->dev_heading) }}" placeholder="Enter heading" required>
  @error('dev_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Image <span class="text-danger">*</span></label>
  <input class="form-control @error('dev_image') is-invalid @enderror" type="file" name="dev_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $e ? '' : 'required' }} onchange="esgPreview(this,'p_dev_image')">
  @error('dev_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $e ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="p_dev_image" src="{{ $e ? $e->assetUrl($e->dev_image) : '' }}" style="max-height:90px; {{ optional($e)->dev_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;"></div>
</div>

<div class="col-12">
  <label class="form-label">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('dev_desc') is-invalid @enderror" name="dev_desc" rows="3" placeholder="Enter description">{!! old('dev_desc', optional($e)->dev_desc) !!}</textarea>
  @error('dev_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- ============ DRIVING CHANGE ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Driving Change Section</h5></div>

<div class="col-md-6">
  <label class="form-label">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('driving_heading') is-invalid @enderror" type="text" name="driving_heading" value="{{ old('driving_heading', optional($e)->driving_heading) }}" placeholder="Enter heading" required>
  @error('driving_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Background Image <span class="text-danger">*</span></label>
  <input class="form-control @error('driving_bg_image') is-invalid @enderror" type="file" name="driving_bg_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $e ? '' : 'required' }} onchange="esgPreview(this,'p_driving_bg_image')">
  @error('driving_bg_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $e ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="p_driving_bg_image" src="{{ $e ? $e->assetUrl($e->driving_bg_image) : '' }}" style="max-height:90px; {{ optional($e)->driving_bg_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;"></div>
</div>

@include('backend.overview.esg._table', ['key' => 'driving_counts', 'label' => 'Count Table', 'cols' => [['image','Image'],['count','Count'],['feature','Feature']]])

{{-- ============ IMPACT ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Impact Section</h5></div>

<div class="col-md-6">
  <label class="form-label">Section Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('impact_heading') is-invalid @enderror" type="text" name="impact_heading" value="{{ old('impact_heading', optional($e)->impact_heading) }}" placeholder="Enter section heading" required>
  @error('impact_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

@include('backend.overview.esg._table', ['key' => 'impacts', 'label' => 'Impact Details Table', 'cols' => [['image','Image'],['year','Year'],['impact','Impact'],['description','Description']]])

{{-- ============ STAKEHOLDER ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Stakeholder Section</h5></div>

<div class="col-md-6">
  <label class="form-label">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('stakeholder_heading') is-invalid @enderror" type="text" name="stakeholder_heading" value="{{ old('stakeholder_heading', optional($e)->stakeholder_heading) }}" placeholder="Enter heading" required>
  @error('stakeholder_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Image <span class="text-danger">*</span></label>
  <input class="form-control @error('stakeholder_image') is-invalid @enderror" type="file" name="stakeholder_image" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $e ? '' : 'required' }} onchange="esgPreview(this,'p_stakeholder_image')">
  @error('stakeholder_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  <small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB{{ $e ? ' | Leave empty to keep current.' : '' }}</small>
  <div class="mt-2"><img id="p_stakeholder_image" src="{{ $e ? $e->assetUrl($e->stakeholder_image) : '' }}" style="max-height:90px; {{ optional($e)->stakeholder_image ? '' : 'display:none;' }} border:1px solid #ddd; padding:4px; border-radius:6px;"></div>
</div>

<div class="col-12">
  <label class="form-label">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('stakeholder_desc') is-invalid @enderror" name="stakeholder_desc" rows="3" placeholder="Enter description">{!! old('stakeholder_desc', optional($e)->stakeholder_desc) !!}</textarea>
  @error('stakeholder_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- ============ WASTE ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Waste Section</h5></div>

<div class="col-md-6">
  <label class="form-label">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('waste_heading') is-invalid @enderror" type="text" name="waste_heading" value="{{ old('waste_heading', optional($e)->waste_heading) }}" placeholder="Enter heading" required>
  @error('waste_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('waste_desc') is-invalid @enderror" name="waste_desc" rows="3" placeholder="Enter description">{!! old('waste_desc', optional($e)->waste_desc) !!}</textarea>
  @error('waste_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

@include('backend.overview.esg._table', ['key' => 'waste_features', 'label' => 'Feature Table', 'cols' => [['image','Image'],['feature','Feature'],['description','Description']]])

{{-- ============ ENVIRONMENTAL DECLARATIONS ============ --}}
<div class="col-12"><h5 class="esg-sec-title">Environmental Declarations Section</h5></div>

<div class="col-md-6">
  <label class="form-label">Heading <span class="text-danger">*</span></label>
  <input class="form-control @error('env_heading') is-invalid @enderror" type="text" name="env_heading" value="{{ old('env_heading', optional($e)->env_heading) }}" placeholder="Enter heading" required>
  @error('env_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Short Description <span class="text-danger">*</span></label>
  <textarea class="form-control @error('env_short_desc') is-invalid @enderror" name="env_short_desc" rows="2" placeholder="Enter short description" required>{{ old('env_short_desc', optional($e)->env_short_desc) }}</textarea>
  @error('env_short_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label">Specification Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('env_specification_desc') is-invalid @enderror" name="env_specification_desc" rows="4" placeholder="Enter specification description">{!! old('env_specification_desc', optional($e)->env_specification_desc) !!}</textarea>
  @error('env_specification_desc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
