<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require 'guard_is_admin.php';

$stmt = $db->prepare("SELECT id, first_name, last_name, type, email FROM users");

if(!$stmt){
    http_response_code(500);
    exit();
}

try {
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $users = $stmt->fetchAll();
    http_response_code(200);
    echo json_encode($users, JSON_THROW_ON_ERROR);
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
