<?php
class Redirect
{
    public static function to($path = null)
    {
        if (isset($path)) {
            echo "<script>console.log('Redirect to " . $path . "');</script>";
            echo "<script>window.location.replace('" . $path . "') </script>";
        }
    }
}
