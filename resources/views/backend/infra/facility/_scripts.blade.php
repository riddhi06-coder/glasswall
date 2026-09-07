<script>
    function previewFile(input, previewId) {
        var preview = document.getElementById(previewId);
        var file = input.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) { alert('Image is too large. Maximum allowed is 2 MB.'); input.value=''; return; }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
    function facPreviewRow(input) {
        var file = input.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) { alert('Image is too large. Maximum allowed is 2 MB.'); input.value=''; return; }
        var preview = input.closest('td').querySelector('.fac-row-preview');
        if (preview) { preview.src = URL.createObjectURL(file); preview.style.display='block'; }
    }

    (function () {
        var EDITOR_CFG = { heading: { options: [
            { model:'paragraph', title:'Paragraph', class:'ck-heading_paragraph' },
            { model:'heading2', view:'h2', title:'Heading 2', class:'ck-heading_heading2' },
            { model:'heading3', view:'h3', title:'Heading 3', class:'ck-heading_heading3' }
        ] } };
        function initEditor(el) {
            if (!el || el.dataset.ckReady) return;
            el.dataset.ckReady = '1';
            ClassicEditor.create(el, EDITOR_CFG).then(function(ed){ el._ck = ed; }).catch(function(e){ console.error(e); });
        }

        function rowTemplate(kind, i) {
            if (kind === 'features') {
                return '<td><input type="file" class="form-control" name="features['+i+'][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="facPreviewRow(this)">' +
                       '<input type="hidden" name="features['+i+'][existing_image]" value="">' +
                       '<div class="mt-2"><img class="fac-row-preview" src="" style="max-height:50px; display:none; background:#f5f5f5; border:1px solid #ddd; padding:3px; border-radius:6px;" alt=""></div></td>' +
                       '<td><input type="text" class="form-control" name="features['+i+'][title]" placeholder="Title"></td>' +
                       '<td><textarea class="form-control" name="features['+i+'][description]" rows="2" placeholder="Description"></textarea></td>' +
                       '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>';
            }
            if (kind === 'counters') {
                return '<td><input type="text" class="form-control" name="counters['+i+'][count]" placeholder="e.g. 500000"></td>' +
                       '<td><input type="text" class="form-control" name="counters['+i+'][suffix]" placeholder="e.g. + or mm"></td>' +
                       '<td><input type="text" class="form-control" name="counters['+i+'][label]" placeholder="Label"></td>' +
                       '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>';
            }
            if (kind === 'galleries') {
                return '<td><input type="file" class="form-control" name="galleries['+i+'][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="facPreviewRow(this)">' +
                       '<input type="hidden" name="galleries['+i+'][existing_image]" value="">' +
                       '<div class="mt-2"><img class="fac-row-preview" src="" style="max-height:70px; display:none; border:1px solid #ddd; padding:3px; border-radius:6px;" alt=""></div></td>' +
                       '<td><input type="text" class="form-control" name="galleries['+i+'][heading]" placeholder="e.g. MS and Sheet Metal Fabrication Unit"></td>' +
                       '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>';
            }
            if (kind === 'strengths') {
                return '<td><input type="text" class="form-control" name="strengths['+i+'][title]" placeholder="Title"></td>' +
                       '<td><textarea class="form-control fac-editor" name="strengths['+i+'][description]" rows="3" placeholder="Description"></textarea></td>' +
                       '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" data-remove>&times;</button></td>';
            }
            return '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('textarea.editor, textarea.fac-editor').forEach(initEditor);

            var rowIndex = Date.now();

            document.querySelectorAll('[data-add]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var kind = btn.getAttribute('data-add');
                    var body = document.querySelector('[data-body="' + kind + '"]');
                    var tr = document.createElement('tr');
                    tr.innerHTML = rowTemplate(kind, rowIndex++);
                    body.appendChild(tr);
                    var ed = tr.querySelector('textarea.fac-editor');
                    if (ed) initEditor(ed);
                });
            });

            document.querySelectorAll('[data-body]').forEach(function (body) {
                body.addEventListener('click', function (e) {
                    if (!e.target.closest('[data-remove]')) return;
                    if (body.querySelectorAll('tr').length <= 1) { alert('At least one row is required.'); return; }
                    var tr = e.target.closest('tr');
                    var ed = tr.querySelector('textarea.fac-editor');
                    if (ed && ed._ck) { ed._ck.destroy().catch(function(){}); }
                    tr.remove();
                });
            });
        });
    })();
</script>
