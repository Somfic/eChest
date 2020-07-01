<?php
class Redirect
{
    public static function to($path = null)
    {
        if (isset($path)) {
            header("Location: {$path}");
            exit();
        }
    }
}
