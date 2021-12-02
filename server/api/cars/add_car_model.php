<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_admin.php';

if(!isset($_POST['make'], $_POST['model'], $_POST['body_type'], $_POST['number_of_seats'], $_POST['power'], $_POST['transmission'])){
    http_response_code(400);
    exit('Invalid request');
}

$make = $_POST['make'];
$model = $_POST['model'];
$body_type = $_POST['body_type'];
$number_of_seats = $_POST['number_of_seats'];
$power = $_POST['power'];
$transmission = $_POST['transmission'];

if(!$make || !$model || !$body_type || !$number_of_seats || !$power || !$transmission){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("INSERT INTO car_models (make, model, body_type, number_of_seats, power, transmission)
    VALUES (:make, :model, :body_type, :number_of_seats, :power, :transmission)");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':make', $make);
$stmt->bindParam(':model', $model);
$stmt->bindParam(':body_type', $body_type);
$stmt->bindParam(':number_of_seats', $number_of_seats, PDO::PARAM_INT);
$stmt->bindParam(':power', $power, PDO::PARAM_INT);
$stmt->bindParam(':transmission', $transmission);

try {
    $stmt->execute();
    http_response_code(201);
    exit('Added new car model');
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
