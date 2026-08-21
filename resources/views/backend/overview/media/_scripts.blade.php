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
</script>
