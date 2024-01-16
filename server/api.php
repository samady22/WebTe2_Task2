<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Call database class
require_once('./Database.php');
require_once('./ApiController.php');
$database = new Database();
// Connect to DB
$db = $database->getConnection();

$apiController = new MyApiController();
$requestMethod =  isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        $apiController->read($db);
        break;
    case 'POST':
        $apiController->create($db, $_POST);
        break;
    case 'PUT':
        if (isset($_POST['_method'])) {
            $apiController->update($db, $_POST['menu_id'], $_POST);
        } else {
            parse_str(file_get_contents('php://input'), $_PUT);
            $apiController->update($db, $_GET['id'], $_PUT);
        }
        break;
    case 'DELETE':
        if (isset($_POST['_method'])) {
            $apiController->delete($db, $_POST['menu_id']);
        } else {
            $id = $_GET['id'];
            $apiController->delete($db, $id);
        }
        break;
}
