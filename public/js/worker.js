$("#new_worker_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    addWorker(event);
});

$("#update_worker_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    editWorker(event);
});

(function() {
    $('.delClass').on('click',  updateWorker);
})();

function addWorker(event){

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/Worker/newWorker',
        data: data,
        success: function(result) {
            $("#new_worker").modal('hide');
        }
    });
}

function editWorker() {
    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/Worker/editWorker',
        data: data,
        success: function(result) {
            $("#update_worker").modal('hide');
        }
    });
}

function updateWorker() {
    var $form = $("#workers_table");
    var select_id = $(this).data();

    document.getElementById("worker_id").value = select_id['id'];
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/Worker/updateWorker',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });
}
