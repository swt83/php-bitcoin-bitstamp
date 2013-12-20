<?php

namespace Travis;

class Bitstamp {

    /**
     * Constructor.
     *
     * @param   string  $method
     * @param   array   $args
     * @return  array
     */
    public static function __callStatic($method, $args)
    {
        // determine endpoint
        $endpoint = 'https://www.bitstamp.net/api/'.$method.'/';

        // build query
        $arguments = isset($args[0]) ? $args[0] : array();
        $query = '';
        foreach ($arguments as $key => $value)
        {
            $query = $key.'='.urlencode($value).'&';
        }

        // build url
        $url = $endpoint.'?'.$query;

        // setup curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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