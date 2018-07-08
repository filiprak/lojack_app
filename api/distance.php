<?php
    require "utils.php";
    require __DIR__."/../libs/geodistance-php/Location.php";

    // allow only get request for the endpoint
    filter_req_type(['GET']);
    $params = query_params();

    if (!isset($params['lat1']) || !isset($params['lng1']) || !isset($params['lat2']) || !isset($params['lng2']))
        json_response(400, "Missing required url parameters", null, [
            "Missing url parameters: all of [lat1, lng1, lat2, lng2] are required"
        ]);

    // get coordinates of two points from url string
    $lat1 = filter_var($params['lat1'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $lng1 = filter_var($params['lng1'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $lat2 = filter_var($params['lat2'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $lng2 = filter_var($params['lng2'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // validate parameters
    if (!is_correct_latlng([$lat1, $lng1]) && !is_correct_latlng([$lat2, $lng2])) {
        json_response(400, "Validation error", null, [
            "Invalid value of geo coordinates"
        ]);
    }

    // calculate the distance between points
    $p1 = new \Geodistance\Location(floatval($lat1), floatval($lng1));
    $p2 = new \Geodistance\Location(floatval($lat2), floatval($lng2));

    json_response(200, "OK", [
        "points" => [ "p1" => [floatval($lat1), floatval($lng1)], "p2" => [floatval($lat2), floatval($lng2)] ],
        "centimeters" => \Geodistance\centimeters($p1, $p2),
        "meters" => \Geodistance\meters($p1, $p2),
        "kilometers" => \Geodistance\kilometers($p1, $p2),
    ])

?>