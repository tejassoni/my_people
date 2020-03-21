// A $( document ).ready() block.
$( document ).ready(function() {
    // Session flash message hide after 10 seconds
    $(".alert").fadeTo(2000, 1000).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
});