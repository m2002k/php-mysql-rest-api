<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Bookmark.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->title) || !isset($data->url)) {
    http_response_code(400);
    echo json_encode(["message" => "Missing title or URL"]);
    exit;
}

$title = htmlspecialchars(strip_tags($data->title));
$url = filter_var($data->url, FILTER_VALIDATE_URL);

if (!$url) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid URL format"]);
    exit;
}

$bookmark = new Bookmark();
$success = $bookmark->create($title, $url);

if ($success) {
    http_response_code(201);
    echo json_encode(["message" => "Bookmark created"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to save bookmark"]);
}
