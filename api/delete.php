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
$success = $bookmark->delete($id);

if ($success) {
    http_response_code(200);
    echo json_encode(["message" => "Bookmark deleted"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to delete bookmark"]);
}
