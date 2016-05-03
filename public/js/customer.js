(function() {
    $('#customers_dropdown').on('change', customerDropdownEvent);
    $('#workers').DataTable({
        responsive: true
    });
    $('#contacts').DataTable({
        responsive: true
    });
})();

$("#add_customer_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    addCustomer(event);
});

$("#update_customer_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    updateCustomer(event);
});

function customerDropdownEvent(event) {
    var $form = $(this).parent();
    $form.submit();
}

function updateCustomer(event) {
    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/Customers/updateCustomer',
        data: data,
        success: function(result) {
            console.log(result);
            $("#update_customer").modal('hide');
        }
    });
}

function addCustomer(event){

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/Customers/newCustomer',
        data: data,
        success: function(result) {
            console.log(result);
            $("#add_customer").modal('hide');
        }
    });
}