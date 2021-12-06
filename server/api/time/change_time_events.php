<?php
include('../headers.php');
include('../db/db.php');
$db = get_db();

require_once "../users/guard_is_moderator.php";

if(!isset($_POST['reset_timestamp'], $_POST['skip_forward'], $_POST['skip_backward'])){
    http_response_code(400);
    exit("Invalid request");
}

$reset_timestamp = $_POST['reset_timestamp']==='true' ? 'ENABLE' : 'DISABLE';
$skip_forward = $_POST['skip_forward']==='true' ? 'ENABLE' : 'DISABLE';
$skip_backward = $_POST['skip_backward']==='true' ? 'ENABLE' : 'DISABLE';

$stmt0 = $db->prepare("ALTER EVENT reset_timestamp ".$reset_timestamp);
$stmt1 = $db->prepare("ALTER EVENT skip_forward ".$skip_forward);
$stmt2 = $db->prepare("ALTER EVENT skip_backward ".$skip_backward);

if(!$stmt0 || !$stmt1 || !$stmt2){
    http_response_code(500);
    exit();
}

try {
    $stmt0->execute();
    $stmt1->execute();
    $stmt2->execute();
    http_response_code(200);
    exit("Done");
}catch(PDOException | JsonException $ex){
    http_response_code(500);
    exit($ex->getMessage());
}
