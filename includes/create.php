<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'Database.php';
include_once 'Items.php';

$database = new Database();
$db = $database->getConnection();
$items = new Items($database);

$data = json_decode(file_get_contents("php://input"));

if ($data === null) {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create item. Data is incomplete or invalid JSON."));
    exit;
}

if(!empty($data->title) && 
   !empty($data->year) && !empty($data->description) && 
   !empty($data->price) && !empty($data->category_id)){

    $item = [
        'title' => $data->title,
        'year' => $data->year,
        'description' => $data->description,
        'price' => $data->price,
        'category_id' => $data->category_id,
        'created' => date('Y-m-d H:i:s'),
        'image_url' => isset($data->image_url) ? $data->image_url : null
    ];

    if($items->create($item)){
        http_response_code(201);
        echo json_encode(array("message" => "Item was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create item."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create item. Data is incomplete."));
}
?>