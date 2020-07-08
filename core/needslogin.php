<?php

// Get the current user
$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('/login.php');
    exit();
}
