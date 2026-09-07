@php $j = $job ?? null; @endphp

<!-- Job Role -->
<div class="col-md-6">
  <label class="form-label" for="job_role">Job Role <span class="text-danger">*</span></label>
  <input class="form-control @error('job_role') is-invalid @enderror" id="job_role" type="text" name="job_role" value="{{ old('job_role', $j->job_role ?? '') }}" placeholder="e.g. Senior Facade Engineer" required>
  @error('job_role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<!-- Location -->
<div class="col-md-6">
  <label class="form-label" for="location">Location <span class="text-danger">*</span></label>
  <input class="form-control @error('location') is-invalid @enderror" id="location" type="text" name="location" value="{{ old('location', $j->location ?? '') }}" placeholder="e.g. Mumbai, India" required>
  @error('location')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<!-- Employment Type -->
<div class="col-md-6">
  <label class="form-label" for="employment_type">Employment Type <span class="text-danger">*</span></label>
  <input class="form-control @error('employment_type') is-invalid @enderror" id="employment_type" type="text" name="employment_type" value="{{ old('employment_type', $j->employment_type ?? '') }}" placeholder="e.g. Full Time" required>
  @error('employment_type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<!-- Experience -->
<div class="col-md-6">
  <label class="form-label" for="experience">Experience <span class="text-danger">*</span></label>
  <input class="form-control @error('experience') is-invalid @enderror" id="experience" type="text" name="experience" value="{{ old('experience', $j->experience ?? '') }}" placeholder="e.g. 3-5 years" required>
  @error('experience')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<!-- Qualification -->
<div class="col-md-6">
  <label class="form-label" for="qualification">Qualification <span class="text-danger">*</span></label>
  <input class="form-control @error('qualification') is-invalid @enderror" id="qualification" type="text" name="qualification" value="{{ old('qualification', $j->qualification ?? '') }}" placeholder="e.g. B.E. / B.Tech in Civil" required>
  @error('qualification')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<!-- Status -->
<div class="col-md-6">
  <label class="form-label" for="is_active">Status <span class="text-danger">*</span></label>
  <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
    <option value="1" {{ (string) old('is_active', $j->is_active ?? '1') === '1' ? 'selected' : '' }}>Active</option>
    <option value="0" {{ (string) old('is_active', $j->is_active ?? '1') === '0' ? 'selected' : '' }}>Inactive</option>
  </select>
  @error('is_active')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<!-- Description -->
<div class="col-12">
  <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
  <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description" rows="6" placeholder="Enter job description">{{ old('description', $j->description ?? '') }}</textarea>
  @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
