<?php

namespace Travis;

class Bitstamp {

    /**
     * Array of public methods (not requiring auth).
     *
     * @var     array
     */
    public static $public_methods = array(
        'ticker',
        'order_book',
        'transactions',
        'eur_usd'
    );

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

        // detect public method
        $is_public = in_array($method, static::$public_methods);

        // capture arguments
        $arguments = isset($args[0]) ? $args[0] : array();

        // if public method...
        if ($is_public)
        {
            // build query
            $query = '';
            foreach ($arguments as $key => $value)
            {
                $query .= $key.'='.urlencode($value).'&';
            }

            // amend url
            $endpoint = $endpoint.'?'.$query;
        }

        // setup curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        if (!$is_public)
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arguments);
        }
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

    /**
     * Return a signature string based on input vars.
     *
     * @param   string  $id
     * @param   string  $key
     * @param   string  $secret
     * @param   int     $nonce
     * @return  string
     */
    public static function sign($id, $key, $secret, $nonce)
    {
        return strtoupper(hash_hmac('SHA256', $nonce.$id.$key, $secret));
    }

}