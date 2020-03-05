$(function () {
    $(".help-text p.support").hide()
});
$(".back-link").click(function (e) {
    e.preventDefault();
    $(".help-text").show(500);

})

$(".toggle-list").click(function (e) {
    e.preventDefault();
    // $(".help-text").hide(500);
    $("#list-view").html("");
    $(".full-location").each(function () {
        console.log(this.value);
        var arr = this.value.split("|");
        $("#list-view").append('<div class="col-md-12 col-sm-12">' +
            '<i class="fa fa-map-marker" aria-hidden="true"></i><a href='+arr[0]+'>'+arr[1]+'</a>' +
            '<img src="/svg/arrow.svg" class="arrow" style="margin-top: -4px; display: none;" alt="Get in touch">' +
            '</div>');
    })

});
var titleLength = 47;
var descriptionLength = 180;
if ($(window).width() >= 768 && $(window).width() < 1024) {
    titleLength = 30;
    descriptionLength = 100;
} else if ($(window).width() >= 1024 && $(window).width() < 1249) {
    titleLength = 35;
    descriptionLength = 120;
}
trimText(titleLength, $(".article-box .title"));
trimText(descriptionLength, $(".article-box .description p"));

function trimText(count, object) {
    object.each(function () {
        var content = $(this).text();
        if (content.length > count) {

            var c = content.substr(0, count);
            $(this).html(c + "...");
        }
    })
}

var map;
var markerList = [];

function initMap() {
    var center = {lat: -41.838875, lng: 171.7799};
    var zoom = 5;

    var mapOptions = {
        zoom: zoom,
        center: center,
        zoomControl: true,
        scaleControl: true,
        styles: [
            {
                "featureType": "all",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "weight": "2.00",
                        "color" : "#baf4c4"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#9c9c9c"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#7b7b7b"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#baf4c4"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#070707"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            }
        ]

    };
    map = new google.maps.Map(document.getElementById('map-section'), mapOptions);
    var lis = $('.address');
    for (var i = 0; i < lis.length; i++) {
        mapAddress(map, lis[i].value);
    }

}

function mapAddress(map, address) {
    var arr = address.split("|");
    if (arr[3] == "") {
        if (arr[1] == "locations/auckland-central") {
            var coveredAreas = "Parnell, Newmarket, Remuera, Grey Lynn, Onehunga";
        } else if (arr[1] == "locations/west-auckland") {
            var coveredAreas = "Waitakere, Henderson, Glen Eden, New Lynn, Te Atatu";
        } else if (arr[1] == "locations/north-shore") {
            var coveredAreas = "Takapuna, Devonport, Northcote, Albany, Glenfield";
        } else if (arr[1] == "locations/franklin") {
            var coveredAreas = "Pukekohe, Waiuku, Wairoa";
        } else if (arr[1] == "locations/rodney") {
            var coveredAreas = "Wellsford, Warkworth, Helensville, Kumeu, sMuriwai";
        } else if (arr[1] == "locations/manukau") {
            var coveredAreas = "Manukau, East Tamaki, Otahuhu";
        } else if (arr[1] == "locations/manawatu") {
            var coveredAreas = "Palmerston North, Feilding, Whanganui, Manawatu, Tangimoana, Kimbolton, Rongotea, Rangiwahia";
        } else if (arr[1] == "locations/invercargill") {
            var coveredAreas = "Invercargill, Gore, Bluff, Fiordland, Riverton, Edendale, Lumsden, Winton";
        } else if (arr[1] == "locations/tauranga") {
            var coveredAreas = "Tauranga, Mount Maunganui, Papamoa, Bethlehem, Te Puke, Te Puna, Omokoroa, Waihi";
        } else if (arr[1] == "locations/whangarei") {
            var coveredAreas = "Whangarei, Dargaville, Kerikeri, Paihia, Waipu, Kaitaia, Opononi, Kaikohe";
        } else if (arr[1] == "locations/waikato") {
            var coveredAreas = "Hamilton, Huntly, Raglan, Tokoroa, Cambridge, Tu Kuiti, Matamata, Tirau";
        } else if (arr[1] == "locations/hawkes-bay") {
            var coveredAreas = "Napier, Hastings, Waipawa, Eskdale, Taradale, Havelock North, Ahuriri";
        } else if (arr[1] == "locations/queenstown-wanaka") {
            var coveredAreas = "Queenstown, Wanaka";
        } else if (arr[1] == "locations/wellington") {
            var coveredAreas = "Wellington Central, Porirua, Upper Hutt, Lower Hutt, Kapiti, Petone, Otaki, Miramar, Lyall Bay";
        } else if (arr[1] == "locations/thames-coromandel") {
            var coveredAreas = "Thames, Whangamata, Tairua, Pauanui, Waihi, Paeroa, Whitianga, Coromandel Town";
        } else if (arr[1] == "locations/cambridge-surrounding-areas") {
            var coveredAreas = "Cambridge, Ely, Bury St Edmunds, Duxford, Cambourne, Newmarket";
        } else if (arr[1] == "locations/surrey-hampshire") {
            var coveredAreas = "Esher, Woking, Weybridge, Virginia Water, Chobham, Farnborough, Guildford, Aldershot, Farnham, Godalming, Haslemere, Cranleigh";
        } else if (arr[1] == "locations/north-nottinghamshire") {
            var coveredAreas = "Chesterfield, Mansfield, Newark, Nottingham, Rufford, Southwell, Worksop";
        } else if (arr[1] == "locations/bristol") {
            var coveredAreas = "Bristol, North Somerset, South Gloucestershire, Bath, North East Somerset";
        } else if (arr[1] == "locations/south-west-london") {
            var coveredAreas = "Balham, Brixton, Chessington, Clapham, Hampton, Kew, Kingston Upon thames, Lambeth, Merton, Mitchamv, Morden, New Malden, Putney, Richmond Upon Thames, Roehampton, Streatham Common, Tooting, Wansworth, Surbiton, Teddington, Tolworth, Twickenham, Vauxhall, West Norwood";
        } else if (arr[1] == "locations/greater-london-south") {
            var coveredAreas = "Addington, Beckenham, Biggin Hill, Bromley, Chislehurst, Croydon, Orpington, Selsdon, Sutton, Thornton Heath";
        } else if (arr[1] == "locations/pensacola") {
            var coveredAreas = "Pensacola, Escambia, Santa Rosa Counties";
        } else if (arr[1] == "locations/gold-coast") {
            var coveredAreas = "Gold Coast";
        } else if (arr[1] == "locations/sydney") {
            var coveredAreas = "Inner West, Inner South West, Sutherland, South West, Outer West, Blue Mountains";
        } else if (arr[1] == "locations/Illawarra") {
            var coveredAreas = "Illawarra";
        } else if (arr[1] == "locations/central-coast") {
            var coveredAreas = "Central Coast";
        } else if (arr[1] == "locations/melbourne") {
            var coveredAreas = "Inner East, South East, Mornington Peninsula, North East, Outer East, Inner, Inner South";
        }
    } else {
        var coveredAreas = arr[3];
    }


    var infowindow = new google.maps.InfoWindow();
    var contentString = "<a href='/" + arr[1] + "'><div class='map-title'>" + arr[2] + "</div><div class='map-address'><i class='fa fa-map-marker'></i> " + arr[0] + "</div><div>Covers the following areas:<br/><b>" + coveredAreas + "</b></div><br/><a class='map-link' href='/" + arr[1] + "'>View location</a></a>";
    var marker = new google.maps.Marker({
        map: map,
        title: arr[4],
        url: arr[1],
        // icon: "https://mt.google.com/vt/icon?color=ff004C13&name=icons/spotlight/spotlight-waypoint-blue.png",
        icon: "https://maps.google.com/mapfiles/ms/micons/blue-dot.png",
        position: {
            lat: parseFloat(arr[5]),
            lng: parseFloat(arr[6])
        }
    });
    marker.addListener('click', function () {
        map.setZoom(15);
        map.setCenter(marker.getPosition());
        infowindow.setContent(contentString);
        infowindow.open(map, marker);
    });
    markerList.push(marker);

}


var button = document.querySelector("input.form");
var userSelectLat;
var userSelectLng;
var userMarker = [];
var userCircle = [];
//add an event listener which executes the callback function, geoLocation, when the Submit button is clicked
button.addEventListener("click", getLocation);

function getLocation(event) {

    event.preventDefault();
    var in_area = [];
    //store city entered into a variable, put it in quotes, and add that to the geocode URL
    var city = document.querySelector("input#destination.inputBox").value + ", New Zealand";
    var cityInQuotes = "\"" + city + "\""
    var geocodeURL = "https://maps.googleapis.com/maps/api/geocode/json?address=" + city + "&key=AIzaSyBuHcqN5QvGKS2Jq7Q44V_jiohv9MxJQZM";
    //return JSON and
    // console.log(geocodeURL);
    if (city) {
        clearPrevious(userMarker, userCircle);
        $.get(geocodeURL, printCoordinates)
    }
}

function printCoordinates(results) {
    if (results.status === "ZERO_RESULTS") {
        // $(".help-text p").html("Can’t find what you’re looking for?  <a href='#' class='toggle-list'>Try view our full list of locations.</a>")
    } else {

        $(".list-toggle").show();
        $(".help-text p.support").hide()
        userSelectLat = results.results[0].geometry.location.lat;
        userSelectLng = results.results[0].geometry.location.lng;
        // console.log('arrayresults = '+userSelectLat,userSelectLng);
    }
    $(".help-text").show(500);
    //re-center map based on new location
    var relocate = new google.maps.LatLng(userSelectLat, userSelectLng);
    map.setCenter(relocate);
    var marker = new google.maps.Marker({
        id: "user",
        map: map,
        position: relocate,
        icon: {
            url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png"
        }
    });
    marker.id = "searchID";
    userMarker.push(marker);
    map.setZoom(12);
    findNearby(document.querySelector("input#destination.inputBox").value, marker, true);

}

$('#current-location').click(function () {
    clearPrevious(userMarker, userCircle);
    $(".help-text").show(500);
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (pos) {
            var position = {
                lat: pos.coords.latitude,
                lng: pos.coords.longitude
            };
            var marker = new google.maps.Marker({
                map: map,
                position: position
            });
            marker.id = "searchID";
            userMarker.push(marker);
            map.setZoom(12);
            map.setCenter(marker.getPosition());
            findNearby(position, marker, false);

        }, function (error) {
            $(".list-toggle").hide();
            $(".help-text p.support").show()
        });
    }

})

function clearPrevious(userMarker, userCircle) {
    $("#list-view").html("");
    for (var i = 0; i < userMarker.length; i++) {
        if (userMarker[i].id == "searchID") {
            //Remove the marker from Map
            userMarker[i].setMap(null);
            //Remove the marker from array.
            userMarker.splice(i, 1);
        }
    }
    for (var i in userCircle) {
        userCircle[i].setMap(null);
    }
    userCircle = []; // this is if you really want to remove them, so you reset the variable.
}

function findNearby(address, marker, search) {
    //In order to lookup the the position of a zip-code you can use the geocoding API:
    // https://developers.google.com/maps/documentation/geocoding/
    var geocode_api_base_url = "https://maps.googleapis.com/maps/api/geocode/json?";
    var params = {
        address: address,
        components: "country:nz",
        sensor: false,
        key: "AIzaSyBuHcqN5QvGKS2Jq7Q44V_jiohv9MxJQZM",
    }
    // This is the result set of markers in area
    var in_area = [];

    //  http://maps.googleapis.com/maps/api/geocode/json?address=05673&components=country:US&sensor=false
    $.getJSON(geocode_api_base_url + $.param(params), function (data) {
        var location, search_area, in_area = [];

        location = data['results'][0]['geometry']['location'];

        // We create a circle to look within:
        search_area = {
            map: map,
            fillColor: '#AA0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            center: new google.maps.LatLng(location.lat, location.lon),
            radius: 8046
        }

        search_area = new google.maps.Circle(search_area);
        userCircle.push(search_area);
        search_area.bindTo('center', marker, 'position');
        console.log(markerList);
        var title = [];
        $.each(markerList, function (i, marker) {
            if (search_area.getBounds().contains(marker.getPosition()) && google.maps.geometry.spherical.computeDistanceBetween(search_area.getCenter(), marker.getPosition()) <= search_area.getRadius()) {
                // title.indexOf(marker.getTitle()) === -1 ? title.push(marker.getTitle()) : console.log();
                if (title.indexOf(marker.getTitle()) === -1) {
                    title.push(marker.getTitle());
                    in_area.push(marker);
                }
            }
        });
        $("#list-view").html("");
        $.each(title, function (i, k) {
            // $("#list-view").append('<li onclick="location.href=&quot;/' + in_area[i].url + '&quot;" class="nearby-list"> <i class="fa fa-map-marker" aria-hidden="true"></i>' + k + '</li>');
        // <div class="col-md-12 col-sm-12 ">
        //         <i class="fa fa-map-marker" aria-hidden="true"></i> <a href="{{ entry.url }}">{{ entry.title }}</a> <img
        // class="arrow" style="margin-top: -4px; display: none" src="/svg/arrow.svg" alt="Get in touch">
        //         </div>
            $("#list-view").append('<div class="col-md-12 col-sm-12">' +
                '<i class="fa fa-map-marker" aria-hidden="true"></i><a href='+in_area[i].url+'>'+k+'</a>' +
                '<img src="/svg/arrow.svg" class="arrow" style="margin-top: -4px; display: none;" alt="Get in touch">' +
                '</div>');
        });
        if (search) {
            $("#number-location").html(title.length + " location(s) near " + document.querySelector("input#destination.inputBox").value);
        } else {
            $("#number-location").html(title.length + " location(s) near you");
        }
    });
}

$(document).scroll(function() {
    checkOffset();
});

function checkOffset() {
    var currentScroll = $(window).scrollTop();
    var fixmeTop = $('.services-image-block').offset().top;       // get initial position of the element
    if (currentScroll >= fixmeTop) {           // apply position: fixed if you
        $('#sticky-green').css({                      // scroll to that element or below it
            position: 'fixed',
            bottom: '0',
        });
    } else {                                   // apply position: static
        $('#sticky-green').css({                      // if you scroll above it
            position: 'static'
        });
    }

    if($('#sticky-green').offset().top + $('#sticky-green').height()
        >= $('#footer').offset().top - 10)
        $('#sticky-green').css('position', 'static');
    if($(document).scrollTop() + window.innerHeight < $('#footer').offset().top)
        $('#sticky-green').css('position', 'fixed'); // restore when you scroll up
}