@php
  $e = $esg ?? null;
  $seed = [
    'innovation_features' => old('innovation_features', $e ? $e->innovationFeatures->map(fn($r)=>['feature'=>$r->feature,'description'=>$r->description,'existing_image'=>$r->image])->all() : []),
    'driving_counts'      => old('driving_counts',      $e ? $e->drivingCounts->map(fn($r)=>['count'=>$r->count,'feature'=>$r->feature,'existing_image'=>$r->image])->all() : []),
    'impacts'             => old('impacts',             $e ? $e->impacts->map(fn($r)=>['year'=>$r->year,'impact'=>$r->impact,'description'=>$r->description,'existing_image'=>$r->image])->all() : []),
    'waste_features'      => old('waste_features',      $e ? $e->wasteFeatures->map(fn($r)=>['feature'=>$r->feature,'description'=>$r->description,'existing_image'=>$r->image])->all() : []),
  ];
@endphp
<script>
    var ESG_ASSET = '{{ asset('esg-uploads') }}/';
    var ESG_TABLES = {
        innovation_features: [{name:'image',type:'file'},{name:'feature',type:'text'},{name:'description',type:'textarea'}],
        driving_counts:      [{name:'image',type:'file'},{name:'count',type:'text'},{name:'feature',type:'text'}],
        impacts:             [{name:'image',type:'file'},{name:'year',type:'text'},{name:'impact',type:'text'},{name:'description',type:'textarea'}],
        waste_features:      [{name:'image',type:'file'},{name:'feature',type:'text'},{name:'description',type:'textarea'}]
    };
    var ESG_SEED = @json($seed);
    var ESG_COUNTERS = {};

    // ---- Singleton image preview + 2 MB guard ----
    function esgPreview(input, previewId) {
        var preview = document.getElementById(previewId);
        var file = input.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) { alert('Image is too large. Maximum allowed is 2 MB.'); input.value = ''; return; }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }

    // ---- Repeatable table rows ----
    function esgRowPreview(input) {
        var file = input.files[0];
        var img = input.parentNode.querySelector('.esg-row-preview');
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) { alert('Image is too large. Maximum allowed is 2 MB.'); input.value = ''; return; }
        if (img) { img.src = URL.createObjectURL(file); img.style.display = 'block'; }
    }

    function esgRenumber(key) {
        document.querySelectorAll('#tbody_' + key + ' tr').forEach(function (r, n) {
            var c = r.querySelector('.esg-row-num');
            if (c) c.textContent = n + 1;
        });
    }

    function esgAddRow(key, values) {
        values = values || {};
        if (ESG_COUNTERS[key] === undefined) ESG_COUNTERS[key] = 0;
        var i = ESG_COUNTERS[key]++;
        var tbody = document.getElementById('tbody_' + key);
        if (!tbody) return;

        var tr = document.createElement('tr');
        var tdNum = document.createElement('td'); tdNum.className = 'esg-row-num'; tr.appendChild(tdNum);

        ESG_TABLES[key].forEach(function (col) {
            var td = document.createElement('td');
            if (col.type === 'file') {
                var input = document.createElement('input');
                input.type = 'file'; input.className = 'form-control'; input.name = key + '[' + i + '][image]';
                input.accept = '.jpg,.jpeg,.png,.webp,.svg';
                input.addEventListener('change', function () { esgRowPreview(input); });
                if (!values.existing_image) input.required = true;
                td.appendChild(input);

                var img = document.createElement('img'); img.className = 'esg-row-preview';
                img.style.cssText = 'max-height:70px;margin-top:6px;border:1px solid #ddd;padding:3px;border-radius:6px;' + (values.existing_image ? '' : 'display:none;');
                if (values.existing_image) img.src = ESG_ASSET + values.existing_image;
                td.appendChild(img);

                var hidden = document.createElement('input'); hidden.type = 'hidden'; hidden.name = key + '[' + i + '][existing_image]'; hidden.value = values.existing_image || '';
                td.appendChild(hidden);

                var note = document.createElement('small'); note.className = 'text-secondary d-block mt-1';
                note.innerHTML = '<b>Allowed:</b> jpg, jpeg, webp, svg &nbsp;|&nbsp; <b>Max:</b> 2 MB';
                td.appendChild(note);
            } else if (col.type === 'textarea') {
                var ta = document.createElement('textarea'); ta.className = 'form-control'; ta.name = key + '[' + i + '][' + col.name + ']'; ta.rows = 2; ta.required = true;
                ta.value = values[col.name] || '';
                td.appendChild(ta);
            } else {
                var inp = document.createElement('input'); inp.type = 'text'; inp.className = 'form-control'; inp.name = key + '[' + i + '][' + col.name + ']'; inp.required = true;
                inp.value = values[col.name] || '';
                td.appendChild(inp);
            }
            tr.appendChild(td);
        });

        var tdAct = document.createElement('td'); tdAct.className = 'text-center';
        var btn = document.createElement('button'); btn.type = 'button'; btn.className = 'btn btn-sm btn-danger'; btn.textContent = 'Remove';
        btn.addEventListener('click', function () { tr.remove(); esgRenumber(key); });
        tdAct.appendChild(btn); tr.appendChild(tdAct);

        tbody.appendChild(tr);
        esgRenumber(key);
    }

    // Add More buttons
    document.querySelectorAll('[data-add]').forEach(function (b) {
        b.addEventListener('click', function () { esgAddRow(b.getAttribute('data-add'), {}); });
    });

    // Seed existing / old rows
    Object.keys(ESG_SEED).forEach(function (key) {
        (ESG_SEED[key] || []).forEach(function (row) { esgAddRow(key, row); });
    });

    // Rich-text editors (CKEditor 5 loaded in main-js).
    document.querySelectorAll('textarea.editor').forEach(function (el) {
        ClassicEditor.create(el, {
            heading: { options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ] }
        }).catch(function (err) { console.error(err); });
    });
</script>
