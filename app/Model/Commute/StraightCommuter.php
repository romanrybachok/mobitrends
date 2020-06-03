<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.06.2020
 * Time: 12:44
 */

namespace App\Model\Commute;


class StraightCommuter extends AbstractCommuter
{
    const EARTH_RADIUS_KM = 6371;

    public function getCommutingDuration()
    {
        $distance = $this->getStraightDistance();

        $commutingDuration = $distance / self::DEFAULT_SPEED;

        //convert hours to minutes
        $this->commutingDuration = round($commutingDuration*60);

        return $this->commutingDuration;
    }

    private function getStraightDistance()
    {
        $degreeLat = deg2rad($this->workCoordsLatitude - $this->homeCoordsLatitude);
        $degreeLong = deg2rad($this->workCoordsLongitude - $this->homeCoordsLongitude);

        $degreeLat1 = deg2rad($this->homeCoordsLatitude);
        $degreeLat2 = deg2rad($this->workCoordsLatitude);

        $subResult = sin($degreeLat/2) * sin($degreeLat/2) +
            sin($degreeLong/2) * sin($degreeLong/2) * cos($degreeLat1) * cos($degreeLat2);

        $result = 2 * atan2(sqrt($subResult), sqrt(1-$subResult));

        return self::EARTH_RADIUS_KM * $result;
    }
}