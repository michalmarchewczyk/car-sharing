<?php
include('../headers.php');
session_start();

include('../db/db.php');
$db = get_db();

if(!isset($_POST['email'], $_POST['password'])){
    http_response_code(400);
    exit('Invalid request');
}
$email = $_POST['email'];
$password = $_POST['password'];


$stmt = $db->prepare("SELECT id, type, password FROM users WHERE email=:email AND type!='BANNED' AND type!='WAITING'");
if(!$stmt){
    http_response_code(500);
    exit();
}
$stmt->bindParam(':email', $email);

try {
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
}catch(PDOException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}

$num = $stmt->rowCount();
if($num < 1){
    http_response_code(404);
    exit("User doesn't exist");
}

$fetched_user = $stmt->fetchAll()[0];

$hashed_password = $fetched_user['password'];
if(!$hashed_password){
    http_response_code(404);
    exit("User doesn't exist");
}

$password_check = password_verify($password, $hashed_password);
if($password_check){
    http_response_code(200);
    $user_id = $fetched_user['id'];
    $_SESSION['user_id'] = $user_id;
    $user_type = $fetched_user['type'];
    $_SESSION['user_type'] = $user_type;
    exit("Logged in");
}
http_response_code(401);
exit("Wrong password");
