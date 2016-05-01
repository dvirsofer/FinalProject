(function() {
    $("#hilel-turs-btn").on("click", function() {
        //sendMail("avishay89@gmail.com");
    });
    $("#alon-turs-btn").on("click", function() {
        sendMail("dvir.sofer90@gmail.com");
    });
})();

$("#mobility_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    sendActivity(event);
});


function sendMail($mailAddress) {
    var $form = $("#flight-ticket-form");
    $form.find("#mail-address").val($mailAddress);

    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/MailController/send',
        data: data,
        success: function(result) {
            console.log(result);
            $("#flight_ticket").modal('hide');
        }
    });

}

function sendActivity(event) {
    var $form = $("#mobility_form");
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