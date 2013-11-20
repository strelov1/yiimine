$(document).ready(function() {
    $('#project-form #Project_title').keyup(function() {
        var transText = $.transliterate($(this).val());
        $('#project-form #Project_identifier').val(transText);
    });
});