<?php
    function json_response($code, $message="", $data=null, $errors=[]) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            "code" => $code,
            "message" => $message,
            "data" => $data,
            "errors" => $errors
        ]);
        exit;
    }

    function filter_req_type($allowed=[]) {
        $type = $_SERVER['REQUEST_METHOD'];
        if (!in_array($type, $allowed)) {
            json_response(400, "Method '".$type."' is not allowed for this endpoint.
                Allowed method types are: ".json_encode($allowed));
        }
    }

    function is_correct_latlng($latlng) {
        $lat = floatval($latlng[0]);
        $lng = floatval($latlng[1]);
        return ($lat >= -90.0 && $lat <= 90.0 &&
            $lng >= -180.0 && $lng <= 180.0);
    }

    function query_params() {
        $parts = parse_url($_SERVER['REQUEST_URI']);
        $query = [];
        if (isset($parts['query']))
            parse_str($parts['query'], $query);
        return $query;
    }
?>