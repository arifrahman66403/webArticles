<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    if (!file) return; // cek kalau ga ada file langsung stop

    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById(previewId);
        if (preview) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
    };
    reader.readAsDataURL(file);
}
</script>
