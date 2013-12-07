<?php

namespace Travis;

class Bitstamp
{
    public static function __callStatic($method, $args)
    {
        // determine endpoint
        $endpoint = 'https://www.bitstamp.net/api/ticker/';

        // build payload
        #$arguments = isset($args[0]) ? $args[0] : array();
        #$payload = urlencode(json_encode(array('apikey'=>$api_key) + $arguments));

        // setup curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);

        // catch errors
        if (curl_errno($ch))
        {
            #$errors = curl_error($ch);
            curl_close($ch);

            // return false
            return false;
        }
        else
        {
            curl_close($ch);

            // return array
            return json_decode($response);
        }
    }
}
