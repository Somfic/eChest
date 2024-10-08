<?php
class Hash
{
    public static function make($string, $salt = '')
    {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length)
    {
        return substr(uniqid('', true), -$length);
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}
