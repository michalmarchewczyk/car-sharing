<?php

$user_id = require 'get_user_id.php';

include('../db/db.php');
$db = get_db();

$stmt = $db->prepare("SELECT id, first_name, last_name, type, email FROM users WHERE id=:id");
if(!$stmt){
    http_response_code(500);
    exit();
}

$stmt->bindParam(':id', $user_id);

try {
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
}catch(PDOException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}

$num = $stmt->rowCount();
if($num < 1){
    http_response_code(500);
    exit("User doesn't exist");
}

$fetched_user = $stmt->fetchAll()[0];

try {
    echo json_encode($fetched_user, JSON_THROW_ON_ERROR);
    exit();
} catch (JsonException $e) {
    exit('JSON error');
}
