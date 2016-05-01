(function() {
    $('#ok_btn').on('click',  editActivity);
    $('#delete_btn').on('click',  cancelActivity);
    $('#activity').DataTable({
        responsive: true
    });
})();

function editActivity(){

    var $form = $("#activity_table");
    var select_id = $(this).data();

    document.getElementById("activity_id").value = select_id['id'];
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/ActivityController/editActivity',
        data: data,
        success: function(result) {
            console.log(result);
            location.reload(true);
        }
    });

}

function cancelActivity(){

    var $form = $("#activity_table");
    var select_id = $(this).data();

    document.getElementById("activity_id").value = select_id['id'];
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/ActivityController/cancelActivity',
        data: data,
        success: function(result) {
            console.log(result);
            location.reload(true);
        }
    });

}