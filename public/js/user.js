(function() {
    $('#add_user_form').submit(addUser);
})();

function addUser(event){
    event.preventDefault();

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: develop_server_name+'/UserProfileController/newUser',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });

}


