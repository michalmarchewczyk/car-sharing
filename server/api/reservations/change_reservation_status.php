<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_moderator.php';

if(!isset($_POST['id'], $_POST['status'])){
    http_response_code(400);
    exit('Invalid request');
}

$id = $_POST['id'];
$status = $_POST['status'];

if(!$id || !($status === 'CONFIRMED' || $status === 'CANCELLED' || $status=== 'ACTIVE' || $status=== 'DONE')){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("UPDATE reservations SET status=:status WHERE id=:id");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':status', $status);


try {
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num < 1){
        http_response_code(404);
        exit("Reservation doesn't exist or is already given status");
    }
    http_response_code(200);
    exit('Reservation updated successfully');
}catch(PDOException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
