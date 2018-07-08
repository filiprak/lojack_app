<?php include "header.php" ?>

<body>
<div class="top-msg">Drag markers to change points latitude and longitude</div>
<div id="map"></div>
<div class="container">
    <div class="row">
        <div class="col-sm-6 text-center">
            <div class="form-group mt-4">
                <label for="lat1">Point 1</label>
                <input type="text" class="form-control" id="lat1" placeholder="Latitude">
                <div class="invalid-tooltip">
                    Invalid latitude value (must be -90 to 90)
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="lng1" placeholder="Longitude">
                <div class="invalid-tooltip">
                    Invalid longitude value (must be -180 to 180)
                </div>
            </div>
        </div>
        <div class="col-sm-6 text-center">
            <div class="form-group mt-4">
                <label for="lat1">Point 2</label>
                <input type="text" class="form-control" id="lat2" placeholder="Latitude">
                <div class="invalid-tooltip">
                    Invalid latitude value (must be -90 to 90)
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="lng2" placeholder="Longitude">
                <div class="invalid-tooltip">
                    Invalid longitude value (must be -180 to 180)
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mt-4">
                <div id="loader-wrapper" class="text-center">
                    <button id="calculate-btn" class="btn btn-dark">
                        <span>Calculate distance</span>
                    </button>
                    <span class="loader"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--modal window-->
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modal-message"></p>
                <ul id="modal-errors"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>

<!--js scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="libs/bootstrap-4.1.1/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-zh1Q8gbii7kVdHQMFFPLZKfENijdr2w"></script>

<script src="js/map.js"></script>
<script src="js/app.js"></script>

<script>
    const app = new App();
</script>