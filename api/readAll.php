<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Bookmark.php';

$bookmark = new Bookmark();
$bookmarks = $bookmark->getAll();

http_response_code(200);
echo json_encode($bookmarks);
