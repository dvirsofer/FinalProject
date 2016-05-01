(function() {
    $('#ok_btn').on('click',  editTable);
    $('#delete_btn').on('click',  editTable);
    $('#activity').DataTable({
        responsive: true
    });
})();

function editTable(){

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
        }
    });

}