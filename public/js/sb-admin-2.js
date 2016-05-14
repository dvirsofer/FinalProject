

//auto Complete settlement
function autoComplete() {

    var min_length = 1;
    var keyword = $('#settlement_id').val();
    if (keyword.length >= min_length) {
        $.ajax({
            url: 'http://52.25.230.58/public/webservice/city_refresh.php',
            type: 'POST',
            data: {keyword: keyword},
            success: function (data) {
                $('#settlement_list_id').show();
                $('#settlement_list_id').html(data);
            }
        });
    } else {
        $('#settlement_list_id').hide();
    }
}

function set_item(item) {
    // change input value
    $('#settlement_id').val(item);
    // hide proposition list
    $('#settlement_list_id').hide();
}






//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});