@php
    $r       = $record ?? null;
    $links   = $r ? $r->links : collect();
    $tabs    = $r ? $r->tabs : collect();
    $curType = old('type', $r->type ?? 'links');
@endphp

<div class="col-12 mb-2">
  <h6 class="fw-bold text-uppercase text-secondary mb-0">Basic Details</h6>
</div>


<div class="col-md-4">
  <label class="form-label" for="type">Row Type <span class="text-danger">*</span></label>
  <select class="form-select" id="type" name="type" required>
    <option value="links" {{ $curType === 'links' ? 'selected' : '' }}>Standard row (title + View links)</option>
    <option value="financial" {{ $curType === 'financial' ? 'selected' : '' }}>Financial block (#14 — sub-items a/b/c)</option>
    <option value="tabs" {{ $curType === 'tabs' ? 'selected' : '' }}>Quarterly tabs block (Q1/Q2/Q3)</option>
  </select>
  @error('type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-4 js-year-wrap">
  <label class="form-label" for="year">Year <small>(financial / tabs)</small></label>
  <input class="form-control @error('year') is-invalid @enderror" id="year" type="text" name="year" value="{{ old('year', $r->year ?? '') }}" placeholder="2026–2027">
  @error('year')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>



<div class="col-md-7">
  <label class="form-label" for="title">Title / Heading</label>
  <textarea class="form-control @error('title') is-invalid @enderror" id="title" name="title" rows="2" placeholder="e.g. Details of Business">{{ old('title', $r->title ?? '') }}</textarea>
  @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="col-md-4">
  <label class="form-label d-block">Status</label>
  <div class="form-check form-switch mt-2">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $r->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
  </div>
</div>


{{-- ===== LINKS / FINANCIAL ITEMS ===== --}}
<div class="col-12 js-links-block border-top pt-4 mt-2">
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
        <th style="width:24%;">Document (PDF/DOC/ZIP)</th>
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
            <input class="form-control" type="file" name="links[{{ $link->id }}][file]" accept=".pdf,.doc,.docx,.zip">
            <a class="js-file-preview small mt-1" href="{{ $link->href ?: '#' }}" target="_blank" style="{{ $link->href ? 'display:block;' : 'display:none;' }}">Preview ↗</a>
          </td>
          <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-link>&times;</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <small class="text-secondary">For each link: set the <b>Link Text</b> (e.g. "View", "View MOA") and either paste a <b>URL</b> or upload a <b>document</b> — PDF, DOC, DOCX or ZIP, max 5 MB (file takes priority). A row can have multiple links (e.g. MOA + AOA).</small>
  @foreach($errors->get('links.*') as $errs)@foreach($errs as $e)<div class="text-danger small mt-1">{{ $e }}</div>@endforeach @endforeach
</div>

{{-- ===== QUARTERLY TABS (each tab holds documents) ===== --}}
<div class="col-12 js-tabs-block border-top pt-4 mt-2" style="display:none;">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <label class="form-label mb-0">Quarterly Tabs <small class="text-secondary">— an empty tab shows "Coming Soon" on the page</small></label>
    <button type="button" class="btn btn-sm btn-primary" id="addTab">+ Add Tab</button>
  </div>
  <div id="tabsBody">
    @foreach($tabs as $tab)
    <div class="card mb-4 tab-card shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <input type="hidden" name="tabs[{{ $tab->id }}][id]" value="{{ $tab->id }}">
          <label class="form-label mb-0">Tab:</label>
          <input class="form-control" style="max-width:160px" type="text" name="tabs[{{ $tab->id }}][label]" value="{{ $tab->label }}" placeholder="Q1">
          <button type="button" class="btn btn-sm btn-outline-danger ms-auto" data-remove-tab>Remove Tab</button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered align-middle mb-2">
            <thead><tr><th>Document Name</th><th style="width:40%;">Attachment (PDF/DOC/ZIP)</th><th style="width:50px;">×</th></tr></thead>
            <tbody class="tab-items-body" data-tabkey="{{ $tab->id }}">
              @foreach($tab->tabItems as $it)
              <tr>
                <td>
                  <input type="hidden" name="tabs[{{ $tab->id }}][items][{{ $it->id }}][id]" value="{{ $it->id }}">
                  <textarea class="form-control" name="tabs[{{ $tab->id }}][items][{{ $it->id }}][title]" rows="2" placeholder="Document name">{{ $it->title }}</textarea>
                </td>
                <td>
                  <input class="form-control" type="file" name="tabs[{{ $tab->id }}][items][{{ $it->id }}][file]" accept=".pdf,.doc,.docx,.zip">
                  <a class="js-file-preview small mt-1" href="{{ $it->href ?: '#' }}" target="_blank" style="{{ $it->href ? 'display:block;' : 'display:none;' }}">Preview ↗</a>
                </td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-item>&times;</button></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <button type="button" class="btn btn-sm btn-light border add-doc mt-2" data-tabkey="{{ $tab->id }}">+ Add Document</button>
      </div>
    </div>
    @endforeach
  </div>
  <small class="text-secondary">The <b>No.</b> is assigned automatically (01, 02, 03 …) in row order. For each document give a <b>Name</b> and upload the <b>attachment</b> — PDF, DOC, DOCX or ZIP, max 5 MB. An empty tab shows "Coming Soon" on the page.</small>
  @foreach($errors->get('tabs.*') as $errs)@foreach($errs as $e)<div class="text-danger small mt-1">{{ $e }}</div>@endforeach @endforeach
</div>

<script>
(function () {
    var idx = Date.now();

    function linkRow(i) {
        return '<tr>' +
            '<td class="js-name-col" style="display:none;"><textarea class="form-control" name="links[n'+i+'][name]" rows="2" placeholder="a. Notice of meeting…"></textarea></td>' +
            '<td><input class="form-control" type="text" name="links[n'+i+'][label]" value="View"></td>' +
            '<td><input class="form-control" type="text" name="links[n'+i+'][url]" placeholder="https://… or /path"></td>' +
            '<td><input class="form-control" type="file" name="links[n'+i+'][file]" accept=".pdf,.doc,.docx,.zip">' +
            '<a class="js-file-preview small mt-1" href="#" target="_blank" style="display:none;">Preview PDF ↗</a></td>' +
            '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-link>&times;</button></td>' +
        '</tr>';
    }
    function docRow(tabKey, i) {
        return '<tr>' +
            '<td><textarea class="form-control" name="tabs['+tabKey+'][items][n'+i+'][title]" rows="2" placeholder="Document name"></textarea></td>' +
            '<td><input class="form-control" type="file" name="tabs['+tabKey+'][items][n'+i+'][file]" accept=".pdf,.doc,.docx,.zip">' +
            '<a class="js-file-preview small mt-1" href="#" target="_blank" style="display:none;">Preview ↗</a></td>' +
            '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove-item>&times;</button></td>' +
        '</tr>';
    }
    function tabCard(tabKey) {
        return '<div class="card mb-4 tab-card shadow-sm"><div class="card-body p-4">' +
            '<div class="d-flex align-items-center gap-2 mb-3">' +
              '<label class="form-label mb-0">Tab:</label>' +
              '<input class="form-control" style="max-width:160px" type="text" name="tabs['+tabKey+'][label]" placeholder="Q1">' +
              '<button type="button" class="btn btn-sm btn-outline-danger ms-auto" data-remove-tab>Remove Tab</button>' +
            '</div>' +
            '<div class="table-responsive"><table class="table table-bordered align-middle mb-2">' +
              '<thead><tr><th>Document Name</th><th style="width:40%;">Attachment (PDF/DOC/ZIP)</th><th style="width:50px;">×</th></tr></thead>' +
              '<tbody class="tab-items-body" data-tabkey="'+tabKey+'"></tbody>' +
            '</table></div>' +
            '<button type="button" class="btn btn-sm btn-light border add-doc mt-2" data-tabkey="'+tabKey+'">+ Add Document</button>' +
        '</div></div>';
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
            document.getElementById('tabsBody').insertAdjacentHTML('beforeend', tabCard('n' + (idx++)));
        });
        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-remove-link]')) { e.target.closest('tr').remove(); return; }
            if (e.target.closest('[data-remove-item]')) { e.target.closest('tr').remove(); return; }
            if (e.target.closest('[data-remove-tab]'))  { e.target.closest('.tab-card').remove(); return; }
            var addDoc = e.target.closest('.add-doc');
            if (addDoc) {
                var key  = addDoc.getAttribute('data-tabkey');
                var body = addDoc.closest('.card-body').querySelector('.tab-items-body');
                body.insertAdjacentHTML('beforeend', docRow(key, idx++));
            }
        });

        // PDF preview for selected files (works for existing + dynamically added rows).
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
