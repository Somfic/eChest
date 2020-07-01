<?php
require_once './core/init.php';

$user = new User();
$user->logout();

Result::success('You were logged out', 'You were succesfully logged out', 'index.php');
