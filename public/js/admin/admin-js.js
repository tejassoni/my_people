// A $( document ).ready() block.
$( document ).ready(function() {
    // Session flash message hide after 10 seconds
    $(".alert").fadeTo(2000, 2000).slideUp(500, function(){
        $(".alert").slideUp(500);
    });

    // Initialize Select2 Library
    $('select').select2({
        theme: 'bootstrap4',
    });
});