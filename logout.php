<?php
require_once './core/init.php';

$user = new User();
$user->logout();

Result::success('You were logged out', 'See you soon!', 'index.php');
