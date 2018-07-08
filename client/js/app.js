function App() {
    const self = this;

    const initialp1 = {lat: 51.142093, lng: 21.060696099999973};
    const initialp2 = {lat: 53.142093, lng: 22.060696099999973};

    self.map = initMap();
    self.controls = {
        lat1: $('#lat1'),
        lng1: $('#lng1'),
        lat2: $('#lat2'),
        lng2: $('#lng2'),
        calcbtn: $('#calculate-btn')
    };

    self.markers = [
        new google.maps.Marker({
            position: initialp1,
            map: self.map,
            draggable: true,
            title: "Point 1"
        }),
        new google.maps.Marker({
            position: initialp2,
            map: self.map,
            draggable: true,
            title: "Point 2"
        })
    ];
    self.polyline = new google.maps.Polyline({
        path: [initialp1, initialp2],
        geodesic: true,
        strokeColor: '#ff341e',
        strokeOpacity: 1.0,
        strokeWeight: 5,
        map: self.map
    });
    self.refreshPolyline = function () {
        self.polyline.setPath(self.markers.map(function (m) {
            return { lat: m.position.lat(), lng: m.position.lng() };
        }));
    };

    // bind markers lat lng data bidirectionally
    for(const i in self.markers) {
        const pointnr = parseInt(i) + 1;
        const marker = self.markers[i];

        // bind markers -> controls
        google.maps.event.addListener(marker, 'drag', function(e) {
            const latlng = e.latLng;

            if (latlng) {
                self.controls['lat' + pointnr].val(latlng.lat());
                self.controls['lng' + pointnr].val(latlng.lng());
                self.controls['lat' + pointnr].removeClass('is-invalid');
                self.controls['lng' + pointnr].removeClass('is-invalid');
                self.refreshPolyline();

            } else console.warn("Cannot find latLng in marker drag event data");
        });

        // bind controls -> markers
        self.controls['lat' + pointnr].on('input', function (e) {
            const newlat = e.target.value;
            if (is_correct_latlng([newlat, 0])) {
                marker.setPosition(new google.maps.LatLng(parseFloat(newlat), marker.position.lng()));
                $(e.target).removeClass('is-invalid');
                self.refreshPolyline();
            } else $(e.target).addClass('is-invalid');

        });
        self.controls['lng' + pointnr].on('input', function (e) {
            const newlng = e.target.value;
            if (is_correct_latlng([0, newlng])) {
                marker.setPosition(new google.maps.LatLng(marker.position.lat(), parseFloat(newlng)));
                $(e.target).removeClass('is-invalid');
                self.refreshPolyline();
            } else $(e.target).addClass('is-invalid');
        })
    }

    // bind button callback
    self.controls['calcbtn'].click(function () {
        const coords = {
            lat1: self.controls['lat1'].val(),
            lng1: self.controls['lng1'].val(),
            lat2: self.controls['lat2'].val(),
            lng2: self.controls['lng2'].val()
        };

        if (is_correct_latlng([coords.lat1, coords.lng1]) && is_correct_latlng([coords.lat2, coords.lng2])) {
            $('#loader-wrapper').addClass('active');
            $.ajax({
                url: '../api/distance.php?' + $.param(coords),
                method: 'GET',
                success: function (data) {
                    display_modal("Success", "Distance between points: <strong>" + data.data.meters + "m (" +
                        data.data.kilometers + "km) </strong>");
                },
                error: function (err) {
                    console.error(err);
                    display_modal("Error", "Something went wrong...", err.errors);
                },
                complete: function() { $('#loader-wrapper').removeClass('active'); },
                dataType: 'json'
            });
        }
    });

    // init form field values
    for(const i in self.markers) {
        const pointnr = parseInt(i) + 1;
        const marker = self.markers[i];

        self.controls['lat' + pointnr].val(marker.position.lat());
        self.controls['lng' + pointnr].val(marker.position.lng());
        self.controls['lat' + pointnr].removeClass('is-invalid');
        self.controls['lng' + pointnr].removeClass('is-invalid');
    }
}

function display_modal(title, message, errors) {
    $('.modal').modal('show');
    $('.modal #modal-title').html(title);
    $('.modal #modal-message').html(message);
    var htmlerrors = "";
    for (var i in errors) {
        htmlerrors += "<li>" + errors[i] + "</li>"
    }
    $('.modal #modal-errors').html(htmlerrors);
}

function is_correct_latlng(latlng) {

    try {
        const lat = parseFloat(latlng['0']);
        const lng = parseFloat(latlng['1']);

        return (!isNaN(lng) && !isNaN(lat) && lat >= -90 && lat <= 90 && lng <= 180 && lng >= -180);
    } catch (e) {
        console.warn("Parsing lat lng: ", e);
        return false;
    }
}