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

    // Per-row icon preview (finds the preview <img> in the same cell).
    function pmPreviewRow(input) {
        var file = input.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Image is too large. Maximum allowed is 2 MB.');
            input.value = '';
            return;
        }
        var preview = input.closest('td').querySelector('.pm-row-preview');
        if (preview) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Main description editor (CKEditor 5, already loaded in main-js).
        document.querySelectorAll('textarea.editor').forEach(function (el) {
            ClassicEditor.create(el, {
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                }
            }).catch(function (err) { console.error(err); });
        });

        // Repeatable pointer rows.
        var body = document.getElementById('pmPointersBody');
        var addBtn = document.getElementById('pmAddRow');
        var rowIndex = Date.now();

        if (addBtn) {
            addBtn.addEventListener('click', function () {
                var i = rowIndex++;
                var tr = document.createElement('tr');
                tr.innerHTML =
                    '<td>' +
                        '<input type="file" class="form-control" name="pointers[' + i + '][image]" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="pmPreviewRow(this)">' +
                        '<input type="hidden" name="pointers[' + i + '][existing_image]" value="">' +
                        '<small class="text-secondary d-block mt-1"><b>Allowed:</b> jpg, jpeg, png, webp, svg | <b>Max:</b> 2 MB</small>' +
                        '<div class="mt-2"><img class="pm-row-preview" src="" style="max-height:60px; display:none; background:#f5f5f5; border:1px solid #ddd; padding:4px; border-radius:6px;" alt="icon"></div>' +
                    '</td>' +
                    '<td><textarea class="form-control" name="pointers[' + i + '][pointer]" rows="3" placeholder="Enter pointer text"></textarea></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-sm btn-danger pm-remove-row">&times;</button></td>';
                body.appendChild(tr);
            });
        }

        if (body) {
            body.addEventListener('click', function (e) {
                var btn = e.target.closest('.pm-remove-row');
                if (!btn) return;
                if (body.querySelectorAll('tr').length <= 1) {
                    alert('At least one pointer is required.');
                    return;
                }
                btn.closest('tr').remove();
            });
        }
    });
</script>
