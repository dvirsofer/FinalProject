(function() {
    $('#forms_panel form').hide();
    $('#search_dropdown').on('change', searchDropdownEvent);
    $('#customers_dropdown').on('change', customerDropdownEvent);
    $('#form_by_employee').submit(formByEmployeeSubmit);
    $('#form_by_passport').submit(formByPassportSubmit);
    $('#workers').DataTable({
        responsive: true
    });
    $('#contacts').DataTable({
        responsive: true
    });
})();

function searchDropdownEvent(event) {
    var $dropdown = $(event.currentTarget);
    var selection = $dropdown.val();

    $('#forms_panel form').hide();
    $('#forms_panel #' + selection).show();
}

function customerDropdownEvent(event) {
    var $form = $(this).parent();
    $form.submit();
}

function formByEmployeeSubmit(event) {
    event.preventDefault();

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    // send to server using AJAX
    $.ajax({
        type: "POST",
        url: develop_server_name+'/SearchController/searchByEmployee',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });
}

function formByPassportSubmit(event) {
    event.preventDefault();

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    // send to server using AJAX
    $.ajax({
        type: "POST",
        url: develop_server_name+'/SearchController/searchByPassport',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });

}