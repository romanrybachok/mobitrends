<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.06.2020
 * Time: 12:44
 */

namespace App\Model\Commute\Google;

//get Google distance and return duration based on default speed
class DistanceCommuter extends GoogleCommuter
{
    /**
     * @throws \Exception
     */
    public function getCommutingDuration()
    {
        $info = $this->getGoogleInfo();

        $distance = $info['distance'];

        $commutingDuration = $distance / self::DEFAULT_SPEED;

        //convert hours to minutes
        $this->commutingDuration = round($commutingDuration*60);

        return $this->commutingDuration;
    }
}