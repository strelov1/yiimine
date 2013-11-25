$(document).ready(function() {
    $('#project-form #Project_title').keyup(function() {
        var transText = $.transliterate($(this).val());
        $('#project-form #Project_identifier').val(transText);
    });

    $('.closeIssueBtn').click(function() {
        $.get(
            $(this).attr('href'),
            function(data) {
                $('.modal').html(data).modal('show');
            }
        );

        return false;
    });

    $('.sendForm').live('click', function() {
        var form = $(this).closest('form');
        $.post(
            form.attr('action'),
            form.serialize(),
            function(data) {
                window.location.reload();
            }
        );
        return false;
    });
});