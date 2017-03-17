function init() {
    let geocoder = new google.maps.Geocoder();

    document.getElementById('convert').addEventListener('click', function() {
        let address = document.getElementById('address').value;
        let loc = geocodeLoc(geocoder, address, (loc) => {
            document.getElementById('result').innerHTML = `${loc}`;
        });
    });

    document.getElementById('getLoc').addEventListener('click', function() {
        getCurPos(({ lng, lat }) => {
            document.getElementById('curLoc').innerHTML = `longitude: ${lng}, latitude: ${lat}`;
        });
    });

    document.getElementById('calcDistance').addEventListener('click', function() {
        let address = document.getElementById('address').value;

        geocodeLoc(geocoder, address, (dest) => {
            // TODO: use promises
            getCurPos((origin) => {
                calcDistance(origin, dest, (result) => {
                    let distance = result.distance.text;
                    document.getElementById('dist').innerHTML = `distance: ${distance}`;
                });
            });
        });
    });

    document.getElementById('calc').addEventListener('click', function() {
        calcDistPerLoc(geocoder);
    });

}

function calcDistPerLoc(geocoder, tableIndexOfLoc) {
    // setup some defaults
    geocoder = geocoder || new google.maps.Geocoder();
    tableIndexOfLoc = tableIndexOfLoc || 4;

    // create a new column for distances
    document.getElementById("headings").innerHTML += "<th>Distance</th>";

    getCurPos((origin) => {
        // loop through each row in the table and grab the location.
        // convert the location to a Geolocation (lat, long), then
        // call the Google Maps APIs to calculate the distance from the current location to the property location
        let table = document.getElementsByTagName("table")[0];
        for (let i = 1, row; row = table.rows[i]; i++) {

            let loc = row.cells[tableIndexOfLoc].innerHTML;

            geocodeLoc(geocoder, loc, (dest) => {
                // TODO: use promises?
                calcDistance(origin, dest, (result) => {
                    let data = "N/A";
                    if (result.hasOwnProperty('distance')) {
                        data = `<td>${result.distance.text}</td>`;
                    } else {
                        data = `<td>${data}</td>`;
                    }

                    table.rows[i].innerHTML += data;
                });
            });
        }
    });
}

function geocodeLoc(geocoder, address, callback) {
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            let loc = results[0].geometry.location;
            callback(loc)
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function getCurPos(callback) {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // http://wesbos.com/destructuring-renaming/
            let { longitude: lng, latitude: lat } = position.coords;
            callback({ lng, lat });
        }, function() {
            alert(getGeoLocFail());
        });
    } else {
        // Browser doesn't support Geolocation
        alert(getNoGeoLocError());
    }
}

function calcDistance(source, destination, cb) {
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
            let result = response.rows[0].elements[0];
            cb(result);
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