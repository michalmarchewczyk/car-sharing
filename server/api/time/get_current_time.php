<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require_once "../users/get_user_id.php";

$stmt = $db->prepare("SELECT value FROM configuration WHERE name='current_timestamp'");

if(!$stmt){
    http_response_code(500);
    exit();
}

try {
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount() < 1){
        http_response_code(500);
        exit("");
    }
    $users = $stmt->fetchAll()[0];
    http_response_code(200);
    echo json_encode($users, JSON_THROW_ON_ERROR);
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
