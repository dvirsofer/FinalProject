(function() {
    $("#hilel-turs-btn").on("click", function() {
        sendMail("avishay89@gmail.com");
    });
    $("#alon-turs-btn").on("click", function() {
        sendMail("dvir.sofer90@gmail.com");
    });
})();


function sendMail($mailAddress) {
    var $form = $("#flight-ticket-form");

    $form.find("#mail-address").val($mailAddress);

    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: 'http://52.25.230.58/MailController/send',
        data: data,
        success: function(result) {
            console.log(result);
            $("#flight_ticket").modal('hide');
        }
    });

}