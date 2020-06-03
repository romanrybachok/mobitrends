<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.06.2020
 * Time: 12:31
 */

namespace App\Model\Commute;


abstract class AbstractCommuter
{
    protected $homeCoordsLatitude;
    protected $homeCoordsLongitude;

    protected $workCoordsLatitude;
    protected $workCoordsLongitude;

    //time in minutes
    protected $commutingDuration = 0;

    //score transformation methods
    const SCORE_TRANSFORMATION_NO_TRANSFORMATION = '1';
    const SCORE_TRANSFORMATION_EVEN_DISTRIBUTION = '2';
    const SCORE_TRANSFORMATION_LOG_WITH_BASE_2 = '3';

    //default speed in km/h
    const DEFAULT_SPEED = 30;

    public function __construct($homeCoords, $workCoords)
    {
        $homeCoordsData = explode(',', $homeCoords);

        if(count($homeCoordsData) != 2)
        {
            throw new \Exception('Incorrect Home Coords: ' . $homeCoords);
        }

        $this->homeCoordsLatitude = $homeCoordsData[0];
        $this->homeCoordsLongitude = $homeCoordsData[1];

        $workCoordsData = explode(',', $workCoords);

        if(count($workCoordsData) != 2)
        {
            throw new \Exception('Incorrect Work Coords: ' . $workCoords);
        }

        $this->workCoordsLatitude = $workCoordsData[0];
        $this->workCoordsLongitude = $workCoordsData[1];
    }

    //Transform the result in minutes into a numeric score.
    public function getScore($method)
    {
        switch ($method) {
            case self::SCORE_TRANSFORMATION_NO_TRANSFORMATION:
                return $this->commutingDuration;
                break;
            case self::SCORE_TRANSFORMATION_EVEN_DISTRIBUTION:
                if($this->commutingDuration > 30)
                {
                    return 100;
                }
                else
                {
                    return round(($this->commutingDuration/30)*100);
                }
                break;
            case self::SCORE_TRANSFORMATION_LOG_WITH_BASE_2:
                if($this->commutingDuration <= 0)
                {
                    return 0;
                }
                else
                {
                    return round(log($this->commutingDuration, 2));
                }
                break;
            default:
                throw new \Exception('Incorrect transform method: ' . $method);
        }

    }

    abstract function getCommutingDuration();
}