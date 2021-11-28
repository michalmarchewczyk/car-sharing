<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require 'guard_is_admin.php';

if(!isset($_POST['user_id'], $_POST['type'])){
    http_response_code(400);
    exit('Invalid request');
}

$user_id = $_POST['user_id'];
$type = $_POST['type'];

if(!$user_id || !($type === 'MODERATOR' || $type === 'CUSTOMER' || $type === 'BANNED')){
    http_response_code(400);
    exit('Invalid request');
}
$stmt = $db->prepare("UPDATE users SET type=:type WHERE id=:id AND type!='ADMIN'");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':type', $type);


try {
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num < 1){
        http_response_code(404);
        exit("User doesn't exist or is already given type");
    }
    http_response_code(200);
    exit('User updated successfully');
}catch(PDOException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
