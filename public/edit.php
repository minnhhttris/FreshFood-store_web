<?php

include __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/partials/header.php';
include_once __DIR__ . '/../config/connect.php';

use myproject\model\productmodel;
$productmodel = new productmodel();

$db = connectDB();

if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {
    $id = $_GET['id'] ?? null;
    $product = $productmodel->getID($id);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $query = 'SELECT name, price, img, type FROM product WHERE id=?';
        try {
            $statement = $db->prepare($query);
            $statement->execute([$_GET['id']]);
            $row = $statement->fetch();
        } catch (PDOException $e) {
            echo "Lỗi!!!";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product = new productmodel();
        $name = $_POST['name'];
        echo $name;
        $price = $_POST['price'];
        echo $price;
        $type = $_POST['type'];
        echo $type;
        $img = $_FILES["img"];

        $product->edit($id, $name, $price, $type, $img);

        header('Location: /public/product.php');
        exit;
    }
}


?>
<section>
    <div class="container-fluid page-header-login">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class=" position-relative" style="margin-top: 100px;">
                <div class="card bg-glass" style="background-color: rgba(255, 255, 255, 0.5); border-radius: 10px;">
                    <div class="card-body py-5 px-md-5 d-flex align-items-center justify-content-center">
                        <form class="px-5" method="Post" action="" enctype="multipart/form-data">
                            <p class="display-3 mb-5 text-center mt-2" style="color: #008080;">Edit Product</p>

                            <div class="form-outline mb-4">
                                <label class="form-label text-dark" for="form3Example2">Name Product</label>
                                <input name="name" type="text" id="form3Example2" class="form-control" value="<?php echo $product['name'] ?>" />

                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label text-dark" for="form3Example3">Price</label>
                                <input name="price" type="number" id="form3Example3" class="form-control" value="<?php echo $product['price'] ?>" />

                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label text-dark" for="form3Example4">Image Product</label>
                                <input name="img" type="file" id="form3Example4" class="form-control" value="<?php echo $product['img'] ?>" />

                            </div>

                            <div class="form-outline mb-4">
                                <div class="row">
                                    <div class="col-6">
                                        <input name="type" type="radio" id="form3Example4" value="Vegetable" <?php echo $product['type'] == "Vegetable" ? "checked" : "" ?> />
                                        <label class="form-label text-dark" for="form3Example4">Vegetable</label>
                                    </div>
                                    <div class="col-6">

                                        <input name="type" type="radio" id="form3Example4" value="Fruit" <?php echo $product['type'] == "Fruit" ? "checked" : "" ?> />
                                        <label class="form-label text-dark" for="form3Example4">Fruit</label>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn text-white mb-4" style="background-color: #008080;">
                                    Submit
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . '/partials/footer.php';
?>