<?php
$user_id = require 'get_user_id.php';

if(!isset($_SESSION['user_type'])){
    http_response_code(500);
    exit('');
}

$user_type = $_SESSION['user_type'];

if($user_type !== 'ADMIN'){
    http_response_code(403);
    exit('Forbidden');
}


