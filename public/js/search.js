(function() {
    $('#forms_panel form').hide();
    $('#search_dropdown').on('change', searchDropdownEvent);
    $('#customers_dropdown').on('change', customerDropdownEvent);
    $('#form_by_employee').submit(formByEmployeeSubmit);
    $('#form_by_name').submit(formByNameSubmit);
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
            var workers = JSON.parse(result);
            var search = document.getElementById("select_worker");
            createOptions(workers, search);

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
            var workers = JSON.parse(result);
            var search = document.getElementById("select_worker");
            createOptions(workers, search);
        }
    });

}

function formByNameSubmit(event) {
    event.preventDefault();

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    // send to server using AJAX
    $.ajax({
        type: "POST",
        url: develop_server_name+'/SearchController/searchByName',
        data: data,
        success: function(result) {
            var workers = JSON.parse(result);
            var search = document.getElementById("select_worker");
            createOptions(workers, search);
        }
    });
}

function createOptions(workers, search) {
    search.length = 0;

    var newSearch = document.createElement('option');
    newSearch.text = 'חיפוש נוסף';
    newSearch.value = '0';
    search.add(newSearch);
    var i = 0;
    for(i; i < workers.length; i++) {
        var newOption = document.createElement('option');
        newOption.text = workers[i]['first_name'] + " " + workers[i]['last_name'];
        newOption.value = workers[i]['id'];
        search.add(newOption);
    }
}


