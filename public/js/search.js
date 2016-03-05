(function() {
    $('#forms_panel form').hide();
    $('#search_dropdown').on('change', searchDropdownEvent);
    $('#customers_dropdown').on('change', customerDropdownEvent);
    $('#form_by_passport').submit(formByPassportSubmit);
    $('#workers').DataTable({
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
    event.preventDefault();

    var $dropdown = $(event.currentTarget);
    var selection = $dropdown.val();
    var data = $dropdown.serialize();

    $('#customer').text(selection);
    $('#customer').show();
    $.ajax({
        type: "POST",
        url: 'http://52.25.230.58/Customers/getCustomerInfoById',
        data: data,
        success: function(result) {
            // console.log(result);
            $('#workers tbody').html(result);
            $('#workers').dataTable()._fnAjaxUpdate();
            $('#workers').DataTable({
                responsive: true
            });
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
        url: 'http://52.25.230.58/SearchController/searchByPassport',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });

}