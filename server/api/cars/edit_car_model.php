<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_admin.php';

if(!isset($_POST['id'], $_POST['make'], $_POST['model'], $_POST['body_type'], $_POST['number_of_seats'], $_POST['power'], $_POST['transmission'])){
    http_response_code(400);
    exit('Invalid request');
}

$id = $_POST['id'];
$make = $_POST['make'];
$model = $_POST['model'];
$body_type = $_POST['body_type'];
$number_of_seats = $_POST['number_of_seats'];
$power = $_POST['power'];
$transmission = $_POST['transmission'];

if(!$id || !$make || !$model || !$body_type || !$number_of_seats || !$power || !$transmission){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("UPDATE car_models SET make=:make, model=:model, body_type=:body_type, number_of_seats=:number_of_seats,
    power=:power, transmission=:transmission WHERE id=:id");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $id);
$stmt->bindParam(':make', $make);
$stmt->bindParam(':model', $model);
$stmt->bindParam(':body_type', $body_type);
$stmt->bindParam(':number_of_seats', $number_of_seats, PDO::PARAM_INT);
$stmt->bindParam(':power', $power, PDO::PARAM_INT);
$stmt->bindParam(':transmission', $transmission);

try {
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num < 1){
        http_response_code(404);
        exit("Car model with given id doesn't exist");
    }
    http_response_code(200);
    exit('Edited car model');
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
