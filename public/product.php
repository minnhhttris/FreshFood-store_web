<?php

use myproject\model\productmodel;

include __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/partials/header.php';

$productmodel = new productmodel();
$type = $_GET['type'] ?? null;
$page = $_GET['page'] ?? 1;

$products = $productmodel->get($type, $page);

$newProducts = $productmodel->getAll();
$totalProducts = $productmodel->getTotalProducts($type);
?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-5">
    <div class="container">
        <h1 class="display-3 mb-3 animated slideInDown">Products</h1>
    </div>
</div>
<!-- Page Header End -->

<!-- Product Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="section-header text-start mb-5 " style="max-width: 500px;">
                    <h1 class="display-5 mb-3">Our Products</h1>
                    <p>Ours product always fresh and good for health. They are supplied from ours the organic garden.</p>
                </div>
            </div>
            <div class="col-lg-6 text-start text-lg-end slideInRight">
                <div>
                    <a href="/public/addproduct.php" class="btn me-2 mb-4" style="background-color: #008080; color:#fff;">Add Product</a>
                </div>
                <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary border-2" href="/public/product.php">My Products</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary border-2" href="/public/product.php?type=Vegetable">Vegetables</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary border-2" href="/public/product.php?type=Fruit">Fruits</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="fade show">
            <div class="p-0">
                <div class="row g-4">
                    <?php

                    if ($products && count($products)) {
                        foreach ($products as $product) {
                            $formattedPrice = number_format($product['price'], 0);

                            echo '
                            <div class="col-xl-3 col-lg-4 col-md-6 ">
                                <div class="product-item">
                                    <div class="position-relative bg-light overflow-hidden" style="width: 295.98px; height: 250px; overflow: hidden;">
                                        <img class="img-fluid w-100" src="' . $product['img'] . ' " alt="" style="object-fit: cover; width: 100%; height: 100%;" >
                                    </div>
                                    <div class="text-center p-4">
                                        <a class="d-block h5 mb-2" href="/public/oneproduct.php?id=' . $product["id"] . '">' . $product['name'] . '</a>
                                        <span class="text-primary me-1">Price: ' . $formattedPrice . ' VND</span>
                                        <span class="text-body text-decoration-line-through"></span>
                                    </div>
                                    <div class="d-flex border-top">
                                        <small class="w-50 text-center border-end py-2">
                                            <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Add to cart</a>
                                        </small>
                                        <small class="w-50 text-center py-2">
                                            <a class="text-body" href="/public/payment.php?id=' . $product["id"] . '"><i class="fa fa-shopping-bag text-primary me-2"></i>Buy Now</a>
                                        </small>
                                    </div>
                                    <div class="product-options">
                                        <a class="edit-btn text-white" href="/public/edit.php?id=' . $product["id"] . '">Edit product</a>
                                        <button class="delete-btn text-white" data-bs-toggle="modal" data-bs-target="#Modal" data-id="' . $product["id"] . '">Delete product</a>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                    <div class="d-flex align-items-center justify-content-center">
                        <ul class="pagination">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="/public/product.php?<?php echo $type != null ? "type=$type&" : "";
                                                                                echo $page > 1 ? "page=" . ($page - 1) : ""; ?>">
                                << </a>
                            </li>
                            <?php
                            $numPages = ceil($totalProducts / 12);
                            for ($i = 1; $i <= $numPages; $i++) {
                                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                                        <a class="page-link" href="/public/product.php?' . ($type != null ? "type=$type&" : "") . 'page=' . $i . '">' . $i . '</a>
                                    </li>';
                            }
                            ?>

                            <li class="page-item <?php echo $page >= $numPages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="/public/product.php?<?php echo $type != null ? "type=$type&" : "";
                                                                                echo $page < $numPages ? "page=" . ($page + 1) : ""; ?>">>></a>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product End -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete product?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                This action cannot be restored, confirm deletion.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="modal-submit" type="button" class="btn btn-primary">Agree</button>
            </div>
        </div>
    </div>
</div>


<script>
    const btnDeletes = document.querySelectorAll(".delete-btn");

    btnDeletes.forEach(function(button) {
        button.addEventListener("click", function(e) {
            const id = e.target.getAttribute("data-id");

            const modalSubmit = document.querySelector('#modal-submit');
            modalSubmit.addEventListener("click", function(e) {
                
                fetch(`/public/delete.php`, {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${id}`,
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === "Success") {
                            location.reload(); 
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                    });
            });
        });
    });
</script>

<?php
include_once __DIR__ . '/partials/footer.php';
?>