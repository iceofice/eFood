<script>
    formatPrice(null); // Format the price input field

    var timeout;
    var delay = 1000; // 1 seconds

    $('#price').keyup(function(event) {
        $(':button[type="submit"]').prop('disabled', true); // Disable the submit button
        if (timeout) {
            clearTimeout(timeout);
        }
        timeout = setTimeout(function() {
            formatPrice(event);
            $(':button[type="submit"]').prop('disabled', false); // Re-enable the submit button
        }, delay);
    });

    function formatPrice(event) {
        if (event != null) {
            // Take the current cursor position
            var cursorStart = event.target.selectionStart,
                cursorEnd = event.target.selectionEnd;
        }

        var selection = window.getSelection().toString();
        if (selection !== '') {
            return;
        }

        var input = $('#price').val();
        var currentCursor = input.length;

        input = input.replace(/[a-zA-Z\s_\-,]+/g, "");
        input = input ? parseFloat(input, 10) : 0;
        var newCursor = input.toLocaleString("en-US").length;

        $('#price').val(function() {
            return (input === 0) ? "" : input.toLocaleString("en-US");
        });

        var addedComma = currentCursor - newCursor;
        if (event != null && addedComma > 0) {
            // Move the cursor to the correct position
            cursorStart = cursorStart + addedComma;
            cursorEnd = cursorEnd + addedComma;
            event.target.setSelectionRange(cursorStart, cursorEnd);
        }
    };
</script>
