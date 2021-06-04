"use strict";
global.$ = window.jQuery = require('jquery/dist/jquery');
require('./bootstrap');
require('alpinejs');
require('bootstrap/dist/js/bootstrap.bundle');

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img_file').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function() {
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        $("#import-button").removeAttr("disabled");
    });
    $('input[name="img"]').change(function() {
        var id = $(this).attr("id");
        readURL(document.getElementById(id));
    });
});