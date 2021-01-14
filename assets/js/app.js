
jQuery(document).ready(function() {

    $('table').DataTable();

    $('#bld').on('click', function (e) {
        e.preventDefault();
        $('#alt').hide(1500);
    });

    setTimeout(function () {
        $('#alt').show(1000);
    }, 500);

    setTimeout(function () {
        $('#alt').hide(1500);
    }, 9000);

    $('form').attr('autocomplete', 'off');

    $('.form-control').on('focus', function () {
        $(this).removeClass('is-invalid');
    });

});
