<?php
session_start();
if(!isset($_SESSION['user_id'])){
    http_response_code(401);
    exit('Not logged in');
}
return $_SESSION['user_id'];
