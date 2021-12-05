<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require '../users/guard_is_moderator.php';

$stmt = $db->prepare("SELECT cars.id, car_models.id as model_id, year, mileage, color, availability, price,
    make, model, body_type, number_of_seats, power, transmission, COUNT(reservations.id) as count FROM cars
    LEFT JOIN car_models on car_models.id = cars.model_id 
    LEFT JOIN reservations on cars.id = reservations.car_id AND (reservations.status = 'WAITING' OR reservations.status = 'CONFIRMED')
    GROUP BY cars.id");

if (!$stmt) {
    http_response_code(500);
    exit();
}

try {
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $car_models = $stmt->fetchAll();
    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($car_models, JSON_THROW_ON_ERROR);
} catch (PDOException | JsonException $ex) {
    http_response_code(500);
    exit($ex->getMessage());
}
