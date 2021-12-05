<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_admin.php';

if(!isset($_POST['id'], $_POST['mileage'], $_POST['year'], $_POST['color'], $_POST['price'])){
    http_response_code(400);
    exit('Invalid request');
}

$id = $_POST['id'];
$mileage = $_POST['mileage'];
$year = $_POST['year'];
$color = $_POST['color'];
$price = $_POST['price'];

if(!$id || !$mileage || !$year || !$color || !$price){
    http_response_code(400);
    exit('Invalid request');
}

$stmt = $db->prepare("UPDATE cars SET mileage=:mileage, year=:year, color=:color, price=:price WHERE id=:id");

if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $id);
$stmt->bindParam(':mileage', $mileage);
$stmt->bindParam(':year', $year);
$stmt->bindParam(':color', $color);
$stmt->bindParam(':price', $price);

try {
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num < 1 && !isset($_FILES['image'])){
        http_response_code(404);
        exit("Car with given id doesn't exist");
    }
    http_response_code(200);
    exit('Edited car');
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
