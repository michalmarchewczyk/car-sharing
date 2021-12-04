<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_moderator.php';

$stmt = $db->prepare("SELECT reservations.id, user_id, car_id, start_time, end_time, status, first_name, last_name
    FROM reservations LEFT JOIN users on users.id = reservations.user_id");

if (!$stmt) {
    http_response_code(500);
    exit();
}

try {
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $car_models = $stmt->fetchAll();
    http_response_code(200);
    echo json_encode($car_models, JSON_THROW_ON_ERROR);
} catch (PDOException | JsonException $ex) {
    http_response_code(500);
    exit($ex->getMessage());
}
