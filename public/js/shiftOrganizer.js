/**
 * Created by IgorB on 14/05/2016.
 */


$("#get_worker_form").submit(function(e) {

    var url = "http://52.25.230.58/public/webservice/workers_webservice.php";  // the script where you handle the form input.

    $.ajax({
        type: "POST",
        url: url,
        data: $("#get_worker_form").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#workers_to_choose").html(data);
            // alert(data); // show response from the php script.
        }
    });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});




function set_activity_item(item) {
    // change input value
    $("[name='new_area_field']").val(item);
    // hide proposition list
    $('#new_area_field_list').hide();


}

$(function() {
    $("#settlement_list_id").mouseout(function () {
        $("#settlement_list_id").css("display", "none");
    });

    $("#new_area_field_list").mouseout(function () {
        $("#new_area_field_list").css("display", "none");
    });

})