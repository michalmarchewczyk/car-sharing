<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_admin.php';

if(!isset($_POST['model_id'], $_POST['year'], $_POST['mileage'], $_POST['color'])){
    http_response_code(400);
    exit('Invalid request');
}

$model_id = $_POST['model_id'];
$year = $_POST['year'];
$mileage = $_POST['mileage'];
$color = $_POST['color'];

if(!$model_id || !$year || !$mileage || !$color){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("INSERT INTO cars (model_id, year, mileage, color) VALUES (:model_id, :year, :mileage, :color)");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':model_id', $model_id, PDO::PARAM_INT);
$stmt->bindParam(':year', $year, PDO::PARAM_INT);
$stmt->bindParam(':mileage', $mileage, PDO::PARAM_INT);
$stmt->bindParam(':color', $color);

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
