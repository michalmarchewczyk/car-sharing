<?php
include('../headers.php');
include('../db/db.php');
include '../phpqrcode.php';
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

$stmt = $db->prepare("SELECT id, user_id, car_id, start_time, end_time, status
    FROM reservations WHERE user_id=:user_id AND id=:id AND status='ACTIVE'");

if (!$stmt) {
    http_response_code(500);
    exit();
}

$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':id', $id);

$reservation = null;

try {
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount() < 1){
        http_response_code(500);
        exit("Active reservations with given id doesn't exist");
    }
    $reservation = $stmt->fetchAll()[0];
} catch (PDOException | JsonException $ex) {
    http_response_code(500);
    exit($ex->getMessage());
}

$code = 'Reservation';
$code .= ';number='.$reservation['id'];
$code .= ';user_id='.$reservation['user_id'];
$code .= ';car_id='.$reservation['car_id'];
$code .= ';start_time='.$reservation['start_time'];
$code .= ';end_time='.$reservation['end_time'];

QRCode::png($code);




