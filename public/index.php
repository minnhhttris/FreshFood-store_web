<?php

use myproject\model\productmodel;
use myproject\model\usersmodel;

include __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/partials/header.php';

$product = new productmodel();
$user = new usersmodel();
$newProducts = $product->getNewstProducts(12);
?>

<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="./img/carousel-1.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-7">
                                <h1 class="display-2 mb-5 animated slideInDown">Organic Food Is Good For Health</h1>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="./img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-7">
                                <h1 class="display-2 mb-5 animated slideInDown">Natural Food Is Always Healthy</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" >
                <div class="about-img position-relative overflow-hidden p-5 pe-0">
                    <img class="img-fluid w-100" src="./img/index1.jpg">
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 mb-4">Best Organic Fruits And Vegetables</h1>
                <p class="mb-4">At Fresh Food, we work with local farmers and producers to bring you peak-quality, high-integrity organic fruits and vegetables.
                    We want to offers for everyone fresh and green meals in order to enhance your health, your life. Everyday!</p>
                <p><i class="fa fa-check text-primary me-3"></i>Natural origin</p>
                <p><i class="fa fa-check text-primary me-3"></i>No pesticides</p>
                <p><i class="fa fa-check text-primary me-3"></i>Fresh and green</p>

            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Product Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="section-header text-start mb-5" style="max-width: 500px;">
                    <h1 class="display-5 mb-3">New Our Products</h1>
                    <p>New ours product really fresh and good for your skin. They have just been havested from ours the organic garden.</p>
                </div>
            </div>
        </div>
        <div>
            <div class="fade show p-0 active">
                <div class="row g-4">

                    <?php

                    if ($newProducts && count($newProducts)) {
                        foreach ($newProducts as $product) {
                            $formattedPrice = number_format($product['price'], 0);

                            echo '<div class="col-xl-3 col-lg-4 col-md-6"">
                                <div class="product-item">
                                    <div class="position-relative bg-light overflow-hidden" style="width: 295.98px; height: 250px; overflow: hidden;">
                                        <img class="img-fluid w-100" src="' . $product['img'] . ' " alt="" style="object-fit: cover; width: 100%; height: 100%;" >
                                        <div class="bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">New</div>
                                    </div>
                                    <div class="text-center p-4">
                                        <a class="d-block h5 mb-2" href="/public/oneproduct.php?id=' . $product["id"] . '">' . $product['name'] . '</a>
                                        <span class="text-primary me-1" href="/product-product.php?id=' . $product['id'] . '">Price: ' . $formattedPrice . ' VND</span>
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
                                </div>
                            </div>';
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product End -->
<?php
include_once __DIR__ . '/partials/footer.php';
?>