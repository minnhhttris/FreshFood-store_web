<?php
use myproject\model\productmodel;

include_once __DIR__ . '/partials/header.php';
include_once __DIR__ . '/../model/productmodel.php';

$productmodel = new productmodel();
$id = $_GET['id'] ?? null;
$product = $productmodel->getID($id);

function productExistsInCart($productId, $cart) {
    foreach ($cart as $item) {
        if ($item['id'] === $productId) {
            return true;
        }
    }
    return false;
}

if (!isset($_SESSION)) {
    session_start();
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCartBtn'])) {
//     $productId = $_POST['product_id'];
//     $product = $productmodel->getID($productId);

//     error_log('POST data: ' . json_encode($_POST));

//     if ($product !== null) {
//         addToCart($product);
//     }
// }

function addToCart($product) {
    global $cart;

    $productId = $product['id'];

    if (!productExistsInCart($productId, $cart)) {
        $cart[] = [
            'id' => $productId,
            'name' => $product['name'],
            'img' => isset($product['img']) ? $product['img'] : 'public/img/' . $product['name'],
            'price' => isset($product['price']) ? $product['price'] : 0,
            'quantity' => 1
        ];
    } else {
        foreach ($cart as &$item) {
            if ($item['id'] === $productId) {
                $item['quantity'] += 1;
                break;
            }
        }
    }

    $_SESSION['cart'] = $cart;

    error_log('Product added to cart: ' . json_encode($product));

    header('Location: cart.php?id=' . urlencode($product['id']));
    exit;
}
?>


<div class="container py-5 mt-5">
    <?php
    if ($product !== null) { 
        $formattedPrice = number_format($product['price'], 0);

        echo '
        <div class="row">
            <div class="col-md-6">
                <div class="product-image">
                    <img class="img-fluid" src="' . $product['img'] . '" alt="' . $product['name'] . '">
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <p class="display-5" style="color: #008080;">' . $product['name'] . '</p>

                <span class="lead me-3"> Price: ' . $formattedPrice . ' VND</span>
                <span class="lead text-decoration-line-through"></span>
                
                <div class="d-flex">
                    <button class="btn btn-primary me-2" type="submit" name="addToCartBtn" value="' . $product["id"] . '">
                        <i class="fa fa-eye text-white me-2"></i>Add to Cart
                    </button>
                    
                    <a class="btn btn-success" href="/public/payment.php?id=' . $product["id"] . '">
                        <i class="fa fa-shopping-bag text-white me-2"></i>Buy Now
                    </a>
                </div>

                <div class="product-options">
                    <a class="btn btn-info text-white" href="#">Edit Product</a>
                    <a class="btn btn-danger text-white" href="#">Delete Product</a>
                </div>
            </div>
        </div>';
    } else {
        echo '<div class="alert alert-danger">Don\'t find product</div>';
    }
    ?>
</div>

<?php
include_once __DIR__ . '/partials/footer.php';
?>