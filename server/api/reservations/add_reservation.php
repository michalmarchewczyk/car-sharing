<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

$user_id = require('../users/get_user_id.php');

if(!isset($_POST['car_id'], $_POST['start_time'], $_POST['end_time'])){
    http_response_code(400);
    exit('Invalid request');
}

$car_id = $_POST['car_id'];
$start_time = date('Y-m-d', $_POST['start_time']/1000);
$end_time = date('Y-m-d', $_POST['end_time']/1000);

if(!$car_id || !$start_time || !$end_time){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("INSERT INTO reservations (user_id, car_id, start_time, end_time)
 VALUES (:user_id, :car_id, :start_time, :end_time)");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
$stmt->bindParam(':start_time', $start_time);
$stmt->bindParam(':end_time', $end_time);

try {
    $stmt->execute();
    http_response_code(201);
    $id = $db->lastInsertId();
    http_response_code(201);
    exit($id);
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
