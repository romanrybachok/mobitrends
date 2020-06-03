<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.06.2020
 * Time: 12:44
 */

namespace App\Model\Commute\Google;

//directly get Google time
class TimeCommuter extends GoogleCommuter
{
    /**
     * @throws \Exception
     */
    public function getCommutingDuration()
    {
        $info = $this->getGoogleInfo();

        $this->commutingDuration = $info['duration'];

        return $this->commutingDuration;
    }
}