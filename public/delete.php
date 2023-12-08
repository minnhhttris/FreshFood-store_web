<?php
include_once __DIR__ . '/../model/productmodel.php';
include_once __DIR__ . '/../config/connect.php';

use myproject\model\productmodel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productModel = new productmodel();
    
    $id = $_POST['id'];

    try {
        $result = $productModel->deleteProduct($id);

        if ($result) {
            header('Content-Type: application/json');
            $res = array(
                "status" => "Success",
                "message" => "Delete Product Successfully",
            );
            echo json_encode($res);
            return;
        } else {
            header('Content-Type: application/json');
            $res = array(
                "status" => "Fail",
                "message" => "Delete Product Failed",
            );
            http_response_code(500);
            echo json_encode($res);
        }
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        $res = array(
            "status" => "Fail",
            "message" => "Delete Product Failed: " . $e->getMessage(),
        );
        http_response_code(500);
        echo json_encode($res);
    }
}
?>
