$("#worker_table").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    createWorkerFile(event)

});

$("#customer_table").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    createCustomersFile(event)

});

function createWorkerFile(event) {
    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/ExcelController/createWorkersFile',
        data: data,
        success: function(result) {
            download("Workers.csv", result);
        }
    });

}

function createCustomersFile(event) {
    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/ExcelController/createCustomersFile',
        data: data,
        success: function(result) {
            download("Customers.csv", result);
        }
    });

}



function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}