function init() {
    let geocoder = new google.maps.Geocoder();

    document.getElementById('convert').addEventListener('click', function() {
        let address = document.getElementById('address').value;
        geocodeLoc(geocoder, address);
    });

    document.getElementById('getLoc').addEventListener('click', function() {
        getCurPos();
    });

    document.getElementById('calcDistance').addEventListener('click', function() {
        let address = document.getElementById('address').value;

        let origin = getCurPos();
        origin = origin || { lat: 51.48186434912856, lng: -0.006291893827160496 };
        let dest = geocodeLoc(geocoder, address);
        dest = dest || { lat: 51.5073509, lng: -0.12775829999998223 };
        calcDistance(origin, dest);
    });
}

function geocodeLoc(geocoder, address) {
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            let loc = results[0].geometry.location;
            // let { lat, lng } = loc;
            document.getElementById('result').innerHTML = `${loc}`;
            return loc;
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
            return '';
        }
    });
}

function getCurPos() {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let { longitude: lng, latitude: lat } = position.coords;
            document.getElementById('curLoc').innerHTML = `longitude: ${lng}, latitude: ${lat}`;
            return { lng, lat };
        }, function() {
            alert(getGeoLocFail());
            return '';
        });
    } else {
        // Browser doesn't support Geolocation
        alert(getNoGeoLocError());
        return '';
    }
}

function calcDistance(source, destination) {
    let service = new google.maps.DistanceMatrixService;
    service.getDistanceMatrix({
        origins: [source],
        destinations: [destination],
        travelMode: 'DRIVING',
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function(response, status) {
        if (status !== 'OK') {
            alert('Error was: ' + status);
        } else {
            // console.log(JSON.stringify(response, null, 2));
            let result = response.rows[0].elements[0];
            if (result.hasOwnProperty('distance')) {
                let distance = result.distance.text;
                document.getElementById('dist').innerHTML = `distance: ${distance}`;
            } else {
                console.log('No results found.');
            }
        }
    });
}

/**
 *      Original functions taken from example code
 */

// https://developers.google.com/maps/documentation/javascript/examples/geocoding-simple
function initGeocode() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: -34.397, lng: 150.644}
    });
    var geocoder = new google.maps.Geocoder();

    document.getElementById('submit').addEventListener('click', function() {
        geocodeAddress(geocoder, map);
    });
}

function geocodeAddress(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location
            });
            let loc = results[0].geometry.location;
            let { lat, lng } = loc;
            let info = document.getElementById('result').innerHTML = loc;
            console.log(JSON.stringify(loc, null, 2));
            console.log(`lat: ${loc.lat}, long: ${loc.lng}`);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

// https://developers.google.com/maps/documentation/javascript/examples/distance-matrix
function initDistance() {
    var bounds = new google.maps.LatLngBounds;
    var markersArray = [];

    var origin1 = {lat: 55.93, lng: -3.118};
    var origin2 = 'Greenwich, England';
    var destinationA = 'Stockholm, Sweden';
    var destinationB = {lat: 50.087, lng: 14.421};

    var destinationIcon = 'https://chart.googleapis.com/chart?' +
        'chst=d_map_pin_letter&chld=D|FF0000|000000';
    var originIcon = 'https://chart.googleapis.com/chart?' +
        'chst=d_map_pin_letter&chld=O|FFFF00|000000';
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 55.53, lng: 9.4},
        zoom: 10
    });
    var geocoder = new google.maps.Geocoder;

    var service = new google.maps.DistanceMatrixService;
    service.getDistanceMatrix({
        origins: [origin1, origin2],
        destinations: [destinationA, destinationB],
        travelMode: 'DRIVING',
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function(response, status) {
        if (status !== 'OK') {
            alert('Error was: ' + status);
        } else {
            var originList = response.originAddresses;
            var destinationList = response.destinationAddresses;
            var outputDiv = document.getElementById('output');
            outputDiv.innerHTML = '';
            deleteMarkers(markersArray);

            var showGeocodedAddressOnMap = function(asDestination) {
                var icon = asDestination ? destinationIcon : originIcon;
                return function(results, status) {
                    if (status === 'OK') {
                        map.fitBounds(bounds.extend(results[0].geometry.location));
                        markersArray.push(new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            icon: icon
                        }));
                    } else {
                        alert('Geocode was not successful due to: ' + status);
                    }
                };
            };

            for (var i = 0; i < originList.length; i++) {
                var results = response.rows[i].elements;
                geocoder.geocode({'address': originList[i]},
                    showGeocodedAddressOnMap(false));
                for (var j = 0; j < results.length; j++) {
                    geocoder.geocode({'address': destinationList[j]},
                        showGeocodedAddressOnMap(true));
                    outputDiv.innerHTML += originList[i] + ' to ' + destinationList[j] +
                        ': ' + results[j].distance.text + ' in ' +
                        results[j].duration.text + '<br>';
                }
            }
        }
    });
}

function deleteMarkers(markersArray) {
    for (var i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
    }
    markersArray = [];
}

// https://developers.google.com/maps/documentation/javascript/geolocation

function initGeoLoc() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 6
    });
    var infoWindow = new google.maps.InfoWindow({map: map});

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation
        ? getGeoLocFail()
        : getNoGeoLocError());
}

function getNoGeoLocError() {
    return `Error: Your browser doesn't support geolocation.`;
}

function getGeoLocFail() {
    return 'Error: The Geolocation service failed.';
}