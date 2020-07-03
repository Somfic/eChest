<?php
session_start();
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'database' => 'echest'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

spl_autoload_register(function ($class) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/' . $class . '.php';
});

$db = new database(
    Config::get('mysql/host'),
    Config::get('mysql/username'),
    Config::get('mysql/password'),
    Config::get('mysql/database')
);

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/sanitize.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/greeting.php';

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = $db->where('hash', $hash)->getOne('users_session');

    if ($db->count > 0) {
        $user = new User($hashCheck['user_id']);
        $user->login();
    }
}
