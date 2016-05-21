/**
 * Created by IgorB on 14/05/2016.
 */

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

$("#get_worker_form").submit(function(e) {

    var url = "http://52.25.230.58/public/webservice/workers_webservice.php";  // the script where you handle the form input.

    $.ajax({
        type: "POST",
        url: url,
        data: $("#get_worker_form").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#workers_to_choose").html(data);
            // alert(data); // show response from the php script.
        }
    });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});




function set_activity_item(item) {
    // change input value
    $("[name='new_area_field']").val(item);
    // hide proposition list
    $('#new_area_field_list').hide();


}

$(function() {
    $("#settlement_list_id").mouseout(function () {
      //  $("#settlement_list_id").css("display", "none");
    });

    $("#new_area_field_list").mouseout(function () {
        //$("#new_area_field_list").css("display", "none");
    });

})

