<?php
class Result
{
    public static function success($title = '', $message = '', $redirectUrl = null)
    {
        Session::set('result-type', 'success');
        self::prepareResult($title, $message, $redirectUrl);
    }

    public static function error($title = '', $message = '', $redirectUrl = null)
    {
        Session::set('result-type', 'error');
        self::prepareResult($title, $message, $redirectUrl);
    }

    private static function prepareResult($title, $message, $redirectUrl)
    {
        Session::set('result-title', $title);
        Session::set('result-message', $message);
        Session::set('result-redirect', $redirectUrl);
        Redirect::to('/result.php');
    }
}
