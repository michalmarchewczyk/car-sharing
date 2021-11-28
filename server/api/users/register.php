<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

if(!isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'])){
    http_response_code(400);
    exit('Invalid request');
}
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];

if(!$first_name || !$last_name || !$email){
    http_response_code(400);
    exit('Invalid request');
}
if(!$password || strlen($password) < 4){
    http_response_code(400);
    exit('Invalid password');
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    http_response_code(400);
    exit('Invalid email');
}

$stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)");
if(!$stmt){
    http_response_code(500);
    exit();
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost'=>12]);

$stmt->bindParam(':first_name', $first_name);
$stmt->bindParam(':last_name', $last_name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashed_password);

try {
    $stmt->execute();
    http_response_code(201);
    exit('User created successfully');
}catch(PDOException $ex){
    if($ex->getCode()==='23000'){
        http_response_code(409);
        exit('Email is already taken');
    }
    http_response_code(500);
    exit($ex->getMessage());
}

