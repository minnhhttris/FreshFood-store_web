<?php

namespace myproject\model;

include_once __DIR__ . '/../config/connect.php';
$db = connectDB();

class productmodel
{
    public function getAll()
    {
        $db = connectDB();
        $stmt = $db->prepare("SELECT * FROM product");
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }

    public function getTotalProducts($type = null)
{
    $db = connectDB();
    if ($type === null) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM product");
        $stmt->execute();
    } else {
        $stmt = $db->prepare("SELECT COUNT(*) FROM product WHERE type = :type");
        $stmt->execute(['type' => $type]);
    }

    return $stmt->fetchColumn();
}

    public function get($type = null, $page = 1)
    {
        $db = connectDB();
        $PAGESIZE = 12;
        $skip = ($page - 1) * $PAGESIZE;
        if ($type === null) {
            $stmt = $db->prepare("SELECT * FROM product ORDER BY id LIMIT :limit OFFSET :skip");
            $stmt->bindParam('limit', $PAGESIZE, \PDO::PARAM_INT);
            $stmt->bindParam('skip', $skip, \PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("SELECT * FROM product WHERE type = :type ORDER BY id LIMIT :limit OFFSET :skip");
            $stmt->bindParam('limit', $PAGESIZE, \PDO::PARAM_INT);
            $stmt->bindParam('skip', $skip, \PDO::PARAM_INT);
            $stmt->bindParam('type', $type, \PDO::PARAM_STR);
            $stmt->execute();
        }
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }

    public function getID($id = null)
    {
        $db = connectDB();
        if ($id === null) {
            $stmt = $db->prepare("SELECT * FROM product");
            $stmt->execute();
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $products;
        } else {
            $stmt = $db->prepare("SELECT * FROM product WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $product = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $product;
        }
    }


    public function getNewstProducts($limit)
    {
        $db = connectDB();
        $stmt = $db->prepare("SELECT * FROM product ORDER BY date_entered DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        $latestProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $latestProducts;
    }

    public function edit($id, $name, $price, $type, $img)
    {
        $db = connectDB();
        try {

            if ($img) {
                $target_dir = dirname(__DIR__) . "\\public\\img\\";
                $uniqueId = uniqid();
                $target_file = $target_dir . 'f' . $uniqueId . '.' . pathinfo($img["name"], PATHINFO_EXTENSION);
                if (move_uploaded_file($img["tmp_name"], $target_file)) {
                    $imageUrl = "\\public\\img\\" . 'f' . $uniqueId . '.' . pathinfo($img["name"], PATHINFO_EXTENSION);
                    $stmt = $db->prepare("UPDATE product SET name = :name, price = :price, type = :type, img = :img WHERE id = :id");
                    $stmt->execute(["id" => $id, "name" => $name, "price" => $price, "type" => $type, "img" => $imageUrl]);
                }
            } else {
                $stmt = $db->prepare("UPDATE product SET name = :name, price = :price, type = :type WHERE id = :id");
                $stmt->execute(["id" => $id, "name" => $name, "price" => $price, "type" => $type]);
            }
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


 
    public function create($name, $price, $type, $image)
{
    $target_dir = dirname(__DIR__) . "\\public\\img\\";
    $uniqueId = uniqid();
    $target_file = $target_dir . 'f' . $uniqueId . '.' . pathinfo($image["name"], PATHINFO_EXTENSION);

    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        $db = connectDB();
        $imageUrl = "\\public\\img\\" . 'f' . $uniqueId . '.' . pathinfo($image["name"], PATHINFO_EXTENSION); 
        $stmt = $db->prepare("INSERT INTO product (name, price, type, img) VALUES (:name, :price, :type, :imageUrl)");
        $stmt->execute(["name" => $name, "price" => $price, "type" => $type, "imageUrl" => $imageUrl]);
        return "success";
    } else {
        return false;
    }
}

public function deleteProduct($id)
{
    $db = connectDB();
    try {
        $stmt = $db->prepare("DELETE FROM product WHERE id = :id");
        $stmt->execute(["id" => $id]);
        return true;
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
}
