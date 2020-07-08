<?php
require_once './core/init.php';

$user = new User();
$user->logout();

Logger::log('{name} logged out', $user);

Result::success('You were logged out', 'See you soon!', 'index.php');
