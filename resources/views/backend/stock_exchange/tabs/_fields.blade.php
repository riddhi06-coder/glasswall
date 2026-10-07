@php
    $r     = $record ?? null;
    $items = $r ? $r->items : collect();
@endphp

<div class="col-md-5">
  <label class="form-label" for="label">Tab Label <span class="text-danger">*</span></label>
  <input class="form-control @error('label') is-invalid @enderror" id="label" type="text" name="label" value="{{ old('label', $r->label ?? '') }}" placeholder="e.g. Q1" required>
  @error('label')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
        <th>Document Name</th>
        <th style="width:40%;">Attachment (PDF/DOC/ZIP/MP3)</th>
        <th style="width:50px;">×</th>
      </tr></thead>
      <tbody id="itemsBody">
        @foreach($items as $item)
        <tr>
          <td>
            <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
            <textarea class="form-control" name="items[{{ $item->id }}][title]" rows="2" placeholder="Document name">{{ $item->title }}</textarea>
          </td>
          <td>
            <input class="form-control" type="file" name="items[{{ $item->id }}][file]" accept=".pdf,.doc,.docx,.zip,.mp3">
            <a class="js-file-preview small mt-1" href="{{ $item->href ?: '#' }}" target="_blank" style="{{ $item->href ? 'display:block;' : 'display:none;' }}">Preview ↗</a>
          </td>
          <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-item>&times;</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <small class="text-secondary">The <b>No.</b> is assigned automatically (01, 02, 03 …) in row order. For each document give a <b>Name</b> and upload the <b>attachment</b> — PDF, DOC, DOCX, ZIP or MP3, max 5 MB.</small>
  @foreach($errors->get('items.*') as $errs)@foreach($errs as $e)<div class="text-danger small mt-1">{{ $e }}</div>@endforeach @endforeach
</div>

<script>
(function () {
    var idx = Date.now();
    function itemRow(i) {
        return '<tr>' +
            '<td><textarea class="form-control" name="items[n'+i+'][title]" rows="2" placeholder="Document name"></textarea></td>' +
            '<td><input class="form-control" type="file" name="items[n'+i+'][file]" accept=".pdf,.doc,.docx,.zip,.mp3">' +
            '<a class="js-file-preview small mt-1" href="#" target="_blank" style="display:none;">Preview ↗</a></td>' +
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
