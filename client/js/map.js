function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        //gestureHandling: 'cooperative',
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: true,
        center: {lat: 52, lng: 21},
        zoom: 7,
        styles: GoogleMapStyle
    });

    return map;
}