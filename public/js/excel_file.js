$("#worker_table").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    createExcelFile(event)

});

function createExcelFile(event) {
    var export_url = develop_server_name+'/ExcelController/createExcelFile';
    $('#workers-export').attr('src', export_url);
}