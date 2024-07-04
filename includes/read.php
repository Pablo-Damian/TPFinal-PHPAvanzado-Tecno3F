<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'Database.php';
include_once 'Items.php';

$database = new Database();
$db = $database->getConnection();
$items = new Items($database);

$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null;

$result = $items->read($id);

if ($result) {
    $itemRecords = ["items" => $result];
    http_response_code(200);
    echo json_encode($itemRecords);
} else {
    http_response_code(404);
    echo json_encode(["message" => "No item found."]);
}
?>