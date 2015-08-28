jQuery(document).ready(function($) {
    // Make clickable-rows clickable ;-)
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });

    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        language: 'de',
        pickTime: false,
        format: 'DD.mm.yyyy'
    });
});