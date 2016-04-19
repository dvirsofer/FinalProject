$("#new_worker_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    addWorker(event);
});

function addWorker(event){

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/Worker/newWorker',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });
}