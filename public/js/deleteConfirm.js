/**
 * This script will search for all links that have the "delete" class and create click handlers to
 * add a form dynamically and ask if the Item shall be deleted.
 */

$(function() {
    $( "a.delete-confirm" ).click(function( event ) {
        var id = '#delete-confirm-dialog';
        var route = $(this).attr('href');

        $(id+' form').attr('action', route);
        $(id).modal('show');
        return false; // prevent redirecting
    });
});