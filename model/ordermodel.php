<?php
namespace myproject\model;

include_once __DIR__ . '/../config/connect.php';

class ordermodel {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function insertOrder($product_id, $quantity,  $fullname, $phonenumber, $address, $notes) {
        $productNew = (Int)$product_id;
        $quantityNew = (Int)$quantity;
        $stmt = $this->db->prepare("INSERT INTO orders (product_id, quantity,  fullname, phonenumber, address, notes) VALUES (:product_id, :quantity, :fullname, :phonenumber, :address, :notes)");
        $stmt->bindParam('product_id', $productNew, \PDO::PARAM_INT);
        $stmt->bindParam('quantity', $quantityNew, \PDO::PARAM_INT);
        $stmt->bindParam('fullname', $fullname, \PDO::PARAM_STR);
        $stmt->bindParam('phonenumber', $phonenumber, \PDO::PARAM_STR);
        $stmt->bindParam('address', $address, \PDO::PARAM_STR);
        $stmt->bindParam('notes', $notes, \PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }

    
}
?>
