<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Bookmark.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    http_response_code(400);
    echo json_encode(["message" => "Bookmark ID is required"]);
    exit;
}

$id = (int) $data->id;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid ID"]);
    exit;
}

$bookmark = new Bookmark();
$result = $bookmark->get($id);

if ($result) {
    http_response_code(200);
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Bookmark not found"]);
}
