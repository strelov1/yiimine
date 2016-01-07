$(document).ready(function() {
    $('body').on('click', '.confirmLink', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var grid = $(this).attr('data-grid');

        if (confirm('Точно удалить?')) {
            $.get(url, function() {
                if (grid) {
                    $.pjax.reload({container:'#'+grid});
                } else {
                    window.location.reload();
                }
            });
        }
        return false;
    });

    $('[data-toggle="tooltip"]').tooltip();
});