<script>
    // Image preview + 2 MB guard.
    function previewFile(input, previewId) {
        var preview = document.getElementById(previewId);
        var file = input.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Image is too large. Maximum allowed is 2 MB.');
            input.value = '';
            return;
        }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }

    (function () {
        var EDITOR_CONFIG = {
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        };

        // Init a CKEditor on a textarea element (keeps the source textarea in sync for submit).
        function initEditor(el) {
            if (!el || el.dataset.ckReady) return;
            el.dataset.ckReady = '1';
            ClassicEditor.create(el, EDITOR_CONFIG)
                .then(function (ed) { el._ckeditor = ed; })
                .catch(function (err) { console.error(err); });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Main + existing feature-row editors.
            document.querySelectorAll('textarea.editor, textarea.de-feature-editor').forEach(initEditor);

            var body = document.getElementById('deFeaturesBody');
            var addBtn = document.getElementById('deAddRow');
            var rowIndex = Date.now();

            if (addBtn) {
                addBtn.addEventListener('click', function () {
                    var i = rowIndex++;
                    var tr = document.createElement('tr');
                    tr.innerHTML =
                        '<td><input type="text" class="form-control" name="features[' + i + '][feature]" placeholder="Feature"></td>' +
                        '<td><textarea class="form-control de-feature-editor" name="features[' + i + '][description]" rows="3" placeholder="Feature description"></textarea></td>' +
                        '<td class="text-center"><button type="button" class="btn btn-sm btn-danger de-remove-row">&times;</button></td>';
                    body.appendChild(tr);
                    initEditor(tr.querySelector('textarea.de-feature-editor'));
                });
            }

            if (body) {
                body.addEventListener('click', function (e) {
                    var btn = e.target.closest('.de-remove-row');
                    if (!btn) return;
                    if (body.querySelectorAll('tr').length <= 1) {
                        alert('At least one feature is required.');
                        return;
                    }
                    var tr = btn.closest('tr');
                    var ta = tr.querySelector('textarea.de-feature-editor');
                    if (ta && ta._ckeditor) { ta._ckeditor.destroy().catch(function () {}); }
                    tr.remove();
                });
            }
        });
    })();
</script>
