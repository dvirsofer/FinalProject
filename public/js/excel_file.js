$("#worker_table").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    createExcelFile(event)

});

function createExcelFile(event) {
    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/ExcelController/createExcelFile',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });

}