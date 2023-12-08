<?php
include_once __DIR__ . '/partials/header.php';
include_once __DIR__ . '/../model/productmodel.php';

use myproject\model\productmodel;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $img = $_FILES["img"];
    $productModel = new productmodel();
    $result = $productModel->create($name, $price, $type, $img);
    if ($result) {
        echo "<input type='hidden' id='successMessage' value='Product created successfully'>";
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
                            <p class="display-3 mb-5 text-center mt-2" style="color: #008080;">Add New Product</p>

                            <div class="form-outline mb-4">
                                <label class="form-label text-dark" for="form3Example2">Name Product</label>
                                <input name="name" type="text" id="form3Example2" class="form-control" />

                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label text-dark" for="form3Example3">Price</label>
                                <input name="price" type="number" id="form3Example3" class="form-control" />

                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label text-dark" for="form3Example4">Image Product</label>
                                <input name="img" type="file" id="form3Example4" class="form-control" />

                            </div>

                            <div class="form-outline mb-4">
                                <div class="row">
                                    <div class="col-6">

                                        <input name="type" type="radio" id="vegetable" value="vegetable" checked/>
                                        <label class="form-label text-dark" for="vegetable">Vegetable</label>
                                    </div>
                                    <div class="col-6">
                                        <input name="type" type="radio" id="fruit" value="fruit" checked/>
                                        <label class="form-label text-dark" for="fruit">Fruit</label>
                                    </div>
                                </div>

                            </div>

                            <!-- Submit button -->
                            <div class="d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn text-white mb-4" style="background-color: #008080;">
                                    Add
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

