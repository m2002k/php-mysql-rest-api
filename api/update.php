<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Bookmark.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->title) || !isset($data->url)) {
    http_response_code(400);
    echo json_encode(["message" => "Missing id, title, or url"]);
    exit;
}

$id = (int) $data->id;
$title = htmlspecialchars(strip_tags($data->title));
$url = filter_var($data->url, FILTER_VALIDATE_URL);

if (!$url || $id <= 0) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid input"]);
    exit;
}

$bookmark = new Bookmark();
$success = $bookmark->update($id, $title, $url);

if ($success) {
    http_response_code(200);
    echo json_encode(["message" => "Bookmark updated"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to update bookmark"]);
}

