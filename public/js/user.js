$("#add_user_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    addUser(event);
});






function addUser(event){


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


