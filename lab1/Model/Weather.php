<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Weather
 *
 * @author webre
 */
class Weather implements Weather_Interface
{

    //put your code here
    private $url;

    public function __construct()
    {

    }

    public function get_cities()
    {
        $string = file_get_contents(__CITIES_FILE);
        $cities = json_decode($string, true);

        $egyption_cities = array_filter($cities, function ($city) {
            return $city["country"] === "EG";
        });
        return $egyption_cities;
    }

    public function get_weather($cityId)
    {
        $apiKey = "ab88e9304267befb6062a70e4ebda67c";
        $apiUrl = sprintf(__WEATHER_URL, $cityId, $apiKey);
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        return $data;


    }

    public function get_current_time()
    {

    }

}
