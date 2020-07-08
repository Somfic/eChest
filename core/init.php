<?php
session_start();

include 'config.php';

spl_autoload_register(function ($class) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/' . $class . '.php';
});

$db = new Database(
    Config::get('mysql/host'),
    Config::get('mysql/username'),
    Config::get('mysql/password'),
    Config::get('mysql/database')
);

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/sanitize.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/greeting.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/timeago.php';

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = $db->where('hash', $hash)->getOne('users_session');

    if ($db->count > 0) {
        $user = new User($hashCheck['user_id']);
        $user->login();
    }
}
