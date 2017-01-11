<?php
include 'utils/functions.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
} else { // Else proceed to home page
    require 'templates/head.php';
    require 'dashboard.php';
    require 'templates/footer.php';
}
