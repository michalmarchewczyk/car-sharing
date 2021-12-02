<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_admin.php';

if(!isset($_POST['id'])){
    http_response_code(400);
    exit('Invalid request');
}

$id = $_POST['id'];

if(!$id){
    http_response_code(400);
    exit('Invalid request');
}


$stmt = $db->prepare("DELETE FROM car_models WHERE id=:id");

if (!$stmt) {
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num < 1){
        http_response_code(404);
        exit("Car model with given id doesn't exist");
    }
    http_response_code(200);
    exit("Deleted car model");
} catch (PDOException | JsonException $ex) {
    if($ex->getCode()==='23000'){
        http_response_code(400);
        exit('Delete all cars of this model first before deleting this model');
    }
    http_response_code(500);
    exit($ex->getMessage());
}
