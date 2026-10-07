@php
    $r     = $record ?? null;
    $items = $r ? $r->items : collect();
@endphp

<div class="col-md-5">
  <label class="form-label" for="label">Tab Label <span class="text-danger">*</span></label>
  <input class="form-control @error('label') is-invalid @enderror" id="label" type="text" name="label" value="{{ old('label', $r->label ?? '') }}" placeholder="e.g. Q1" required>
  @error('label')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-4">
  <label class="form-label" for="sort_order">Sort Order</label>
  <input class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $r->sort_order ?? 0) }}">
  @error('sort_order')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-3">
  <label class="form-label d-block">Status</label>
  <div class="form-check form-switch mt-2">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $r->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
  </div>
</div>

<div class="col-12">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Documents <small class="text-secondary">(leave empty to show "Coming Soon")</small></label>
    <button type="button" class="btn btn-sm btn-primary" id="addItem">+ Add Document</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr>
        <th style="width:80px;">No.</th>
        <th>Title</th>
        <th style="width:26%;">URL / Path</th>
        <th style="width:24%;">Document (PDF/DOC/ZIP)</th>
        <th style="width:50px;">×</th>
      </tr></thead>
      <tbody id="itemsBody">
        @foreach($items as $item)
        <tr>
          <td>
            <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
            <input class="form-control" type="text" name="items[{{ $item->id }}][number]" value="{{ $item->number }}" placeholder="01">
          </td>
          <td><textarea class="form-control" name="items[{{ $item->id }}][title]" rows="2" placeholder="Document title">{{ $item->title }}</textarea></td>
          <td><input class="form-control" type="text" name="items[{{ $item->id }}][url]" value="{{ $item->url }}" placeholder="https://… or /path"></td>
          <td>
            <input class="form-control" type="file" name="items[{{ $item->id }}][file]" accept=".pdf,.doc,.docx,.zip">
            <a class="js-file-preview small d-block mt-1" href="{{ $item->file ? asset(\App\Models\StockExchange::DIR.'/'.$item->file) : '#' }}" target="_blank" style="{{ $item->file ? '' : 'display:none;' }}">Preview PDF ↗</a>
          </td>
          <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-item>&times;</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <small class="text-secondary">Each document: a <b>No.</b>, a <b>Title</b>, and either a pasted <b>URL</b> or an uploaded <b>document</b> — PDF, DOC, DOCX or ZIP, max 5 MB (file takes priority).</small>
  @foreach($errors->get('items.*') as $errs)@foreach($errs as $e)<div class="text-danger small mt-1">{{ $e }}</div>@endforeach @endforeach
</div>

<script>
(function () {
    var idx = Date.now();
    function itemRow(i) {
        return '<tr>' +
            '<td><input class="form-control" type="text" name="items[n'+i+'][number]" placeholder="01"></td>' +
            '<td><textarea class="form-control" name="items[n'+i+'][title]" rows="2" placeholder="Document title"></textarea></td>' +
            '<td><input class="form-control" type="text" name="items[n'+i+'][url]" placeholder="https://… or /path"></td>' +
            '<td><input class="form-control" type="file" name="items[n'+i+'][file]" accept=".pdf,.doc,.docx,.zip">' +
            '<a class="js-file-preview small d-block mt-1" href="#" target="_blank" style="display:none;">Preview PDF ↗</a></td>' +
            '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-item>&times;</button></td>' +
        '</tr>';
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('addItem').addEventListener('click', function () {
            document.getElementById('itemsBody').insertAdjacentHTML('beforeend', itemRow(idx++));
        });
        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-remove-item]')) e.target.closest('tr').remove();
        });
        // PDF preview for selected files (existing + dynamically added rows).
        document.addEventListener('change', function (e) {
            var inp = e.target;
            if (inp.tagName !== 'INPUT' || inp.type !== 'file') return;
            var prev = inp.parentNode.querySelector('.js-file-preview');
            if (!prev) return;
            var f = inp.files && inp.files[0];
            if (f) {
                prev.href = URL.createObjectURL(f);
                prev.textContent = 'Preview selected PDF ↗';
                prev.style.display = 'block';
            }
        });
    });
})();
</script>
