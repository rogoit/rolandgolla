$(function() {
    "use strict";

    $("#contact-form").submit(function(e) {

        var url = "/emailform/"; // the script where you handle the form input.

        var data = JSON.stringify({"email": $('#email').val()});

        $.ajax({
            type: "POST",
            url: url,
            contentType:"application/json",
            dataType:"json",
            data:data,
        }).done(function(data) {
            $("#contact-form").html('<div style="text-align: center;font-weight: bold;font-size: 20px;">Danke</div>');
        }).fail(function(data) {
        });


        e.preventDefault();
    });
});