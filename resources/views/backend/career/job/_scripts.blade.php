<script>
    // Rich-text editor (CKEditor 5 is already loaded in main-js).
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
</script>
