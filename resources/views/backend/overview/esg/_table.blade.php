{{-- Reusable repeatable table shell. Rows are injected by JS (esg-scripts). --}}
<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">{{ $label }}</label>
    <button type="button" class="btn btn-sm btn-primary" data-add="{{ $key }}">+ Add More</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle mb-0">
      <thead>
        <tr>
          <th style="width:50px;">#</th>
          @foreach($cols as $col)
            <th @if($col[0] === 'image') style="width:240px;" @endif>{{ $col[1] }} <span class="text-danger">*</span></th>
          @endforeach
          <th class="text-center" style="width:90px;">Action</th>
        </tr>
      </thead>
      <tbody id="tbody_{{ $key }}"></tbody>
    </table>
  </div>
</div>
