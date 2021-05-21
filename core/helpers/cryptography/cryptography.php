<?php

namespace helpers;

class Cryptography
{
    public function verify($key, $hmac)
    {
        if (hash_equals($key, $hmac)) {
            return true;
        } else {
            return false;
        }
    }
    public function encrypt($data, $secret)
    {
        if (!empty($secret) && !empty($data)) {
            try {
                $key = hash_hmac("sha256", $data, $secret);
                return $key;
            } catch (Exception $e) {
                return $e;
            }
        } else {
            throw "Parametros vazios";
        }
    }
}
