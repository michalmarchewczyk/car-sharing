<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

$user_id = require('../users/get_user_id.php');

$stmt = $db->prepare("SELECT reservations.id, user_id, car_id, start_time, end_time, status
    FROM reservations WHERE user_id=:user_id");

$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

if (!$stmt) {
    http_response_code(500);
    exit();
}

try {
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $reservations = $stmt->fetchAll();
    http_response_code(200);
    echo json_encode($reservations, JSON_THROW_ON_ERROR);
} catch (PDOException | JsonException $ex) {
    http_response_code(500);
    exit($ex->getMessage());
}
