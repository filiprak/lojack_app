<?php

namespace Geodistance;

class Location
{
    // We'll need another constant here,
    // when we'll start using GPS on Mars
    const EARTH_RADIUS = 6371000;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @throw \InvalidArgumentException
     */
    public function __construct($latitude, $longitude)
    {
        if (!is_float($latitude) || !is_float($longitude)) {
            throw new \InvalidArgumentException('coordinates must be of type float');
        }

        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function latitude()
    {
        return deg2rad($this->latitude);
    }

    /**
     * @return float
     */
    public function longitude()
    {
        return deg2rad($this->longitude);
    }
}

function meters(location $x, location $y, $precision = 0)
{
    $deltaLatitude = $y->latitude() - $x->latitude();
    $deltaLongitude = $y->longitude() - $x->longitude();

    $angle = asin(
        sqrt(
            pow(sin($deltaLatitude * 0.5), 2)
            + cos($x->latitude()) * cos($y->latitude())
            * pow(sin($deltaLongitude * 0.5), 2)
        )
    ) * 2;

    return round(location::EARTH_RADIUS * $angle, $precision);
}

function kilometers(location $x, location $y, $precision = 0)
{
    return round(meters($x, $y) * 0.001, $precision);
}

function miles(location $x, location $y, $precision = 0)
{
    return round(meters($x, $y) * 0.000621371, $precision);
}

function centimeters(location $x, location $y, $precision = 0)
{
    return round(meters($x, $y) * 100, $precision);
}

function yards(location $x, location $y, $precision = 0)
{
    return round(meters($x, $y) * 1.09361, $precision);
}

function feet(location $x, location $y, $precision = 0)
{
    return round(meters($x, $y) * 3.28083, $precision);
}
