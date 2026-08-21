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
</script>
