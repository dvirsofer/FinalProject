
var map;
var infoWindow;


$(function() {

    initMap();

    downloadUrl("http://52.25.230.58/public/webservice/googleMapWebService.php");


    var customIcons = {
        other: {
            icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
        },
        moshav: {
            icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
        },

        kibbutz: {
            icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
        }
    };

    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    }

    function initMap() {
        var mapDiv = document.getElementById('map');
        map = new google.maps.Map(mapDiv, {
            center: {lat:  32.076672, lng: 34.855951},
            zoom: 12
        });
        infoWindow = new google.maps.InfoWindow;

    }





    function downloadUrl(url) {

        var jqxhr = $.ajax(url)
            .done(function(xml) {

                putMarkers(xml);

            })
            .fail(function() {
                alert( "error" );
            })

    }


    function putMarkers(data) {

        var xml =data['documentElement'];
        var markers = xml.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            var address = markers[i].getAttribute("address");
            var type = (markers[i].getAttribute("type")=="")?"other":markers[i].getAttribute("type");
            var point = new google.maps.LatLng(
                parseFloat(markers[i].getAttribute("lat")),
                parseFloat(markers[i].getAttribute("lng")));
            var html = "<b>" + name + "</b> <br/>" + address;
            var icon = customIcons[type] || {};
            var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: icon.icon
            });
            bindInfoWindow(marker, map, infoWindow, html);
        }
    }

});


//auto Complete settlement
function autoCompleteEmployer() {

    var min_length = 1;
    var keyword = $('#settlement_id').val();
    if (keyword.length >= min_length) {
        $.ajax({
            url: 'http://52.25.230.58/public/webservice/customer_refresh.php',
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

//auto Complete settlement
function autoCompleteField() {

    var min_length = 1;
    var keyword = $("[name='new_area_field']").val();
    if (keyword.length >= min_length) {
        $.ajax({
            url: 'http://52.25.230.58/public/webservice/field_refresh.php',
            type: 'POST',
            data: {keyword: keyword},
            success: function (data) {
                $('#new_area_field_list').show();
                $('#new_area_field_list').html(data);
            }
        });
    } else {
        $('#new_area_field_list').hide();
    }
}

function set_item(item,latlog) {
    // change input value
    $('#settlement_id').val(item);
    // hide proposition list
    $('#settlement_list_id').hide();

    map.setCenter(latlog);

    $.ajax({
        url: 'http://52.25.230.58/public/webservice/customer_fields.php',
        type: 'POST',
        data: {customer_name: item},
        success: function (data) {
            $('#extra-form-group').html(data);
        }
    });
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
