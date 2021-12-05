<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

$user_id = require('../users/get_user_id.php');

if(!isset($_POST['id'])){
    http_response_code(400);
    exit('Invalid request');
}

$id = $_POST['id'];

if(!$id){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("UPDATE reservations SET status='CANCELLED' WHERE id=:id AND user_id=:user_id");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num < 1){
        http_response_code(404);
        exit("Reservation with given id doesn't exist");
    }
    http_response_code(200);
    exit('Cancelled reservation');
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
