<script>
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

    function previewVideo(input, previewId) {
        var preview = document.getElementById(previewId);
        var file = input.files[0];
        if (!file) return;
        if (file.size > 30 * 1024 * 1024) {
            alert('Video is too large. Maximum allowed is 30 MB.');
            input.value = '';
            return;
        }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        preview.load();
    }

    // ---- Media documents: Add More / Remove ----
    (function () {
        var addBtn = document.getElementById('doc-add-more');
        var body   = document.getElementById('docBody');
        var tpl    = document.getElementById('doc-row-template');
        if (!addBtn || !body || !tpl) return;

        addBtn.addEventListener('click', function () {
            var idx = parseInt(addBtn.getAttribute('data-next-index'), 10) || 0;
            var tmp = document.createElement('template');
            tmp.innerHTML = tpl.innerHTML.replace(/__IDX__/g, idx).trim();
            body.appendChild(tmp.content.firstElementChild);
            addBtn.setAttribute('data-next-index', idx + 1);
        });

        // Remove any row (existing or newly added)
        body.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('doc-remove')) {
                var row = e.target.closest('tr');
                if (row) row.remove();
            }
        });
    })();
</script>
