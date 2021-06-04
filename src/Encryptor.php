<?php

namespace Cblink\FeiShu;

/**
 * Class Encryptor
 * @package Cblink\FeiShu
 * @see https://github.com/hsupu/feishu-bot-sdk-php/blob/master/src/Encryptor.php
 */
class Encryptor
{
    private const CIPHER_ALG = 'aes-256-cbc';

    private $key;

    public function __construct($key)
    {
        $this->key = self::sha256($key);
    }

    /**
     * webhook bot sha256
     *
     * @param $str
     * @param bool $raw_output
     * @return string
     */
    public static function hash_mac_sha256($str, $raw_output = true)
    {
        return hash_hmac('sha256', "", $str, $raw_output);
    }

    public static function sha256($str, $raw_output = true)
    {
        return hash('sha256', utf8_encode($str), $raw_output);
    }

    private static function get_iv_length()
    {
        return \openssl_cipher_iv_length(self::CIPHER_ALG);
    }

    public function encryptBytes($bytes)
    {
        $iv = \openssl_random_pseudo_bytes(self::get_iv_length());
        $options = OPENSSL_RAW_DATA; # PKCS#7 padding
        return $iv . \openssl_encrypt($bytes, self::CIPHER_ALG, $this->key, $options, $iv);
    }

    public function decryptBytes($bytes)
    {
        $iv = substr($bytes, 0, self::get_iv_length());
        $bytes = substr($bytes, self::get_iv_length());
        $options = OPENSSL_RAW_DATA; # PKCS#7 padding
        return \openssl_decrypt($bytes, self::CIPHER_ALG, $this->key, $options, $iv);
    }

    public function encryptString($str)
    {
        $b = utf8_encode($str);
        $b = $this->encryptBytes($b);
        return base64_encode($b);
    }

    public function decryptString($str)
    {
        $b = base64_decode($str);
        $b = $this->decryptBytes($b);
        return utf8_decode($b);
    }
}