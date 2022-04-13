<script>
    $('#image').change(function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image-preview').attr('src', e.target.result);
            $('#image-preview').show();
        };
        reader.readAsDataURL(file);
    });
</script>
