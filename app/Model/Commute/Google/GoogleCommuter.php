<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.06.2020
 * Time: 12:44
 */

namespace App\Model\Commute\Google;
use App\Model\Commute\AbstractCommuter;


abstract class GoogleCommuter extends AbstractCommuter
{
    /**
     * @throws \Exception
     */
    protected function getGoogleInfo()
    {
        $data = array(
            'origin' => $this->homeCoordsLatitude . ',' . $this->homeCoordsLongitude,
            'destination' => $this->workCoordsLatitude . ',' . $this->workCoordsLongitude,
            'key' => env('GOOGLE_API_KEY')
        );

        $url = env('GOOGLE_API_URL') . '?' . http_build_query($data);

        $ch = curl_init($url);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERAGENT, env('USER_AGENT'));

        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            $errorMsg = curl_error($ch);
            throw new \Exception('CURL Error: ' . $errorMsg);
        }

        $data = json_decode($output, true);

        if(!isset($data['routes'][0]['legs'][0]))
        {
            throw new \Exception('Wrong response format: ' . $output);
        }

        return array(
            'distance' => ceil($data['routes'][0]['legs'][0]['distance']['value'] / 1000),
            'duration' => ceil($data['routes'][0]['legs'][0]['duration']['value'] / 60)
        );
    }
}