$("#mobility_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    sendMail(event);
});

function sendMail(event) {
    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/MailController/sendMobility',
        data: data,
        success: function(result) {
            $("#mobility").modal('hide');
        }
    });
}
