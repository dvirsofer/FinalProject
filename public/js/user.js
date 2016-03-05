(function() {
    $('#add_user_form').submit(addUser);
})();

function addUser(event){
    event.preventDefault();

    var $form = $(event.currentTarget);
    var data = $form.serialize();

    $.ajax({
        type: "POST",
        url: 'http://52.25.230.58/UserProfileController/newUser',
        data: data,
        success: function(result) {
            console.log(result);
        }
    });

}


