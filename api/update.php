<?php
// Check Request Method
if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode('Method Not Allowed');
    return;
}

// Response Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');

include_once '../db/Database.php';
include_once '../models/Todo.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Todo object
$todo = new Todo($dbConnection);

// Get the HTTP PUT request JSON body
$data = json_decode(file_get_contents("php://input"));
if (!$data || !$data->id || !$data->done) {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameters id and done in the JSON body.')
    );
    return;
}

$todo->setId($data->id);
$todo->setDone($data->done);

// Update the ToDo item
if ($todo->update()) {
    echo json_encode(
        array('message' => 'A todo item was updated.')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a todo item was not updated.')
    );
}
