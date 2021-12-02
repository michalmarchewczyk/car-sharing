<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_admin.php';

if(!isset($_GET['id'])){
    http_response_code(400);
    exit('Invalid request');
}

$id = $_GET['id'];

if(!$id){
    http_response_code(400);
    exit('Invalid request');
}


$stmt = $db->prepare("SELECT make, model, body_type, number_of_seats, power, transmission FROM car_models
    WHERE id=:id");

if (!$stmt) {
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $num = $stmt->rowCount();
    if($num < 1){
        http_response_code(404);
        exit("Car model with given id doesn't exist");
    }
    $car_model = $stmt->fetchAll()[0];
    http_response_code(200);
    echo json_encode($car_model, JSON_THROW_ON_ERROR);
} catch (PDOException | JsonException $ex) {
    http_response_code(500);
    exit($ex->getMessage());
}
