@php
    $r       = $record ?? null;
    $links   = $r ? $r->links : collect();
    $tabs    = $r ? $r->tabs : collect();
    $curType = old('type', $r->type ?? 'links');
@endphp

@if($errors->any())
  <div class="col-12"><div class="alert alert-danger mb-0"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div></div>
@endif

<div class="col-md-2">
  <label class="form-label" for="number">Number</label>
  <input class="form-control" id="number" type="text" name="number" value="{{ old('number', $r->number ?? '') }}" placeholder="01">
</div>

<div class="col-md-7">
  <label class="form-label" for="title">Title / Heading</label>
  <textarea class="form-control" id="title" name="title" rows="2" placeholder="e.g. Details of Business">{{ old('title', $r->title ?? '') }}</textarea>
</div>

<div class="col-md-3">
  <label class="form-label" for="sort_order">Sort Order</label>
  <input class="form-control" id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $r->sort_order ?? 0) }}">
</div>

<div class="col-md-4">
  <label class="form-label" for="type">Row Type <span class="text-danger">*</span></label>
  <select class="form-select" id="type" name="type" required>
    <option value="links" {{ $curType === 'links' ? 'selected' : '' }}>Standard row (title + View links)</option>
    <option value="financial" {{ $curType === 'financial' ? 'selected' : '' }}>Financial block (#14 — sub-items a/b/c)</option>
    <option value="tabs" {{ $curType === 'tabs' ? 'selected' : '' }}>Quarterly tabs block (Q1/Q2/Q3)</option>
  </select>
</div>

<div class="col-md-4 js-year-wrap">
  <label class="form-label" for="year">Year <small>(financial / tabs)</small></label>
  <input class="form-control" id="year" type="text" name="year" value="{{ old('year', $r->year ?? '') }}" placeholder="2026–2027">
</div>

<div class="col-md-4">
  <label class="form-label d-block">Status</label>
  <div class="form-check form-switch mt-2">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $r->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
  </div>
</div>

{{-- ===== LINKS / FINANCIAL ITEMS ===== --}}
<div class="col-12 js-links-block">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Links / Documents <small class="text-secondary js-financial-hint" style="display:none;">— each is a sub-item (a/b/c) with its own name</small></label>
    <button type="button" class="btn btn-sm btn-primary" id="addLink">+ Add Link</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr>
        <th class="js-name-col" style="width:34%;display:none;">Item Name (financial a/b/c)</th>
        <th style="width:14%;">Link Text</th>
        <th>URL / Path</th>
        <th style="width:24%;">PDF Upload</th>
        <th style="width:50px;">×</th>
      </tr></thead>
      <tbody id="linksBody">
        @foreach($links as $link)
        <tr>
          <td class="js-name-col" style="display:none;">
            <input type="hidden" name="links[{{ $link->id }}][id]" value="{{ $link->id }}">
            <textarea class="form-control" name="links[{{ $link->id }}][name]" rows="2" placeholder="a. Notice of meeting…">{{ $link->name }}</textarea>
          </td>
          <td><input class="form-control" type="text" name="links[{{ $link->id }}][label]" value="{{ $link->label }}" placeholder="View"></td>
          <td><input class="form-control" type="text" name="links[{{ $link->id }}][url]" value="{{ $link->url }}" placeholder="https://… or /path"></td>
          <td>
            <input class="form-control" type="file" name="links[{{ $link->id }}][file]" accept=".pdf">
            @if($link->file)<a class="small d-block mt-1" href="{{ asset(\App\Models\Disclosure::DIR.'/'.$link->file) }}" target="_blank">Current PDF ↗</a>@endif
          </td>
          <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-link>&times;</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <small class="text-secondary">For each link: set the <b>Link Text</b> (e.g. "View", "View MOA") and either paste a <b>URL</b> or upload a <b>PDF</b> (PDF takes priority). A row can have multiple links (e.g. MOA + AOA).</small>
</div>

{{-- ===== QUARTERLY TABS ===== --}}
<div class="col-12 js-tabs-block" style="display:none;">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Quarterly Tabs</label>
    <button type="button" class="btn btn-sm btn-primary" id="addTab">+ Add Tab</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th style="width:120px;">Tab Label</th><th>Content (text or HTML — e.g. "Coming Soon" or document links)</th><th style="width:50px;">×</th></tr></thead>
      <tbody id="tabsBody">
        @foreach($tabs as $tab)
        <tr>
          <td>
            <input type="hidden" name="tabs[{{ $tab->id }}][id]" value="{{ $tab->id }}">
            <input class="form-control" type="text" name="tabs[{{ $tab->id }}][label]" value="{{ $tab->label }}" placeholder="Q1">
          </td>
          <td><textarea class="form-control" name="tabs[{{ $tab->id }}][content]" rows="3" placeholder="Coming Soon Q1">{{ $tab->content }}</textarea></td>
          <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-tab>&times;</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<script>
(function () {
    var idx = Date.now();

    function linkRow(i) {
        return '<tr>' +
            '<td class="js-name-col" style="display:none;"><textarea class="form-control" name="links[n'+i+'][name]" rows="2" placeholder="a. Notice of meeting…"></textarea></td>' +
            '<td><input class="form-control" type="text" name="links[n'+i+'][label]" value="View"></td>' +
            '<td><input class="form-control" type="text" name="links[n'+i+'][url]" placeholder="https://… or /path"></td>' +
            '<td><input class="form-control" type="file" name="links[n'+i+'][file]" accept=".pdf"></td>' +
            '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-link>&times;</button></td>' +
        '</tr>';
    }
    function tabRow(i) {
        return '<tr>' +
            '<td><input class="form-control" type="text" name="tabs[n'+i+'][label]" value="Q1"></td>' +
            '<td><textarea class="form-control" name="tabs[n'+i+'][content]" rows="3" placeholder="Coming Soon"></textarea></td>' +
            '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-tab>&times;</button></td>' +
        '</tr>';
    }

    function syncByType() {
        var type = document.getElementById('type').value;
        var linksBlock = document.querySelector('.js-links-block');
        var tabsBlock  = document.querySelector('.js-tabs-block');
        var yearWrap   = document.querySelector('.js-year-wrap');
        var isTabs = type === 'tabs';
        var isFin  = type === 'financial';

        linksBlock.style.display = isTabs ? 'none' : '';
        tabsBlock.style.display  = isTabs ? '' : 'none';
        yearWrap.style.display   = (isTabs || isFin) ? '' : 'none';

        // Financial rows show the "Item Name" column.
        document.querySelectorAll('.js-name-col').forEach(function (el) { el.style.display = isFin ? '' : 'none'; });
        var hint = document.querySelector('.js-financial-hint');
        if (hint) hint.style.display = isFin ? '' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('type').addEventListener('change', syncByType);
        syncByType();

        document.getElementById('addLink').addEventListener('click', function () {
            document.getElementById('linksBody').insertAdjacentHTML('beforeend', linkRow(idx++));
            syncByType();
        });
        document.getElementById('addTab').addEventListener('click', function () {
            document.getElementById('tabsBody').insertAdjacentHTML('beforeend', tabRow(idx++));
        });
        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-remove-link]')) e.target.closest('tr').remove();
            if (e.target.closest('[data-remove-tab]')) e.target.closest('tr').remove();
        });
    });
})();
</script>
