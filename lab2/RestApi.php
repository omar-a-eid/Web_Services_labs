<?php
require_once "vendor/autoload.php";
$db = new DbHandler();
$db->connect();

$urlParts = explode('/', $_SERVER['REQUEST_URI']);
$resource = $urlParts[3];
$resourceId = (isset($urlParts[4]) && is_numeric($urlParts[4])) ? (int)$urlParts[4] : 0;


function handleGet($resource, $resourceId)
{
    global $db;

    switch ($resource) {
        case 'products':
            if ($resourceId > 0) {
                $data = $db->get_record_by_id($resourceId);
            } else {
                $data = $db->query('product')->get();
            }
            break;
        default:
            $data = null;
            break;
    }

    return $data;
}


function handlePost($resource)
{
    global $db;
    
    switch ($resource) {
        case 'products':
            $postData = json_decode(file_get_contents("php://input"), true);
            if ($postData === null) {
                echo "Invalid JSON data";
                return;
            }
            $db->query('product')->insert($postData);
            echo "Item created";
            break;
        default:
            echo "Resource not supported for POST";
            break;
        }
}

function handlePut($resource, $resourceId)
{
    global $db;
    switch ($resource) {
        case 'products':
            $putData = json_decode(file_get_contents("php://input"), true);
            if ($putData === null) {
                echo "Invalid JSON data";
                return;
            }
            $db->query('product')->where('id', $resourceId)->update($putData);
            echo "Item updated";
            break;
        default:
            echo "Resource not supported for PUT";
            break;
    }
}

function handleDelete($resource, $resourceId)
{
    global $db;
    switch ($resource) {
        case 'products':
     $db->query('product')->where('id', $resourceId)->delete();

     echo "Item deleted";
     break;
 default:
     echo "Resource not supported for DELETE";
     break;
    }
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data = handleGet($resource, $resourceId);
        break;
    case 'POST':
        handlePost($resource);
        break;
    case 'PUT':
        handlePut($resource, $resourceId);
        break;
    case 'DELETE':
        handleDelete($resource, $resourceId);
        break;
    default:
        echo 'not supported';
        break;
}

$statusCode = is_null($data) ? 404 : 200;
http_response_code($statusCode);
header('Content-Type: application/json');

if (!empty($data)) {
    echo json_encode($data);
}