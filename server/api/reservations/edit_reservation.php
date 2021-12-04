<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_moderator.php';

if(!isset($_POST['id'], $_POST['start_time'], $_POST['end_time'])){
    http_response_code(400);
    exit('Invalid request');
}

$id = $_POST['id'];
$start_time = date('Y-m-d', $_POST['start_time']/1000);
$end_time = date('Y-m-d', $_POST['end_time']/1000);

if(!$id || !$start_time || !$end_time){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("UPDATE reservations SET start_time=:start_time, end_time=:end_time WHERE id=:id");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $id);
$stmt->bindParam(':start_time', $start_time);
$stmt->bindParam(':end_time', $end_time);

try {
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num < 1){
        http_response_code(404);
        exit("Reservation with given id doesn't exist");
    }
    http_response_code(200);
    exit('Edited reservation');
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
