<?php

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
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

// $GLOBALS['config'] = array(
//     'mysql' => array(
//         'host' => 'rdbms.strato.de',
//         'username' => 'U4208956',
//         'password' => 'Overkampweg125',
//         'database' => 'DB4208956'
//     ),
//     'remember' => array(
//         'cookie_name' => 'hash',
//         'cookie_expiry' => 604800
//     ),
//     'session' => array(
//         'session_name' => 'user',
//         'token_name' => 'token'
//     )
// );
