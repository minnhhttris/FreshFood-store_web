<?php
use myproject\model\productmodel;

include __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/partials/header.php';

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

$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove_from_cart') {
    $productId = $_POST['product_id'];

    // Remove the selected product from the cart
    foreach ($cart as $index => $item) {
        if ($item['id'] === $productId) {
            unset($cart[$index]);
        }
    }

    $_SESSION['cart'] = array_values($cart);
    // Redirect back to the cart page after removing from cart
    header('Location: cart.php');
    exit;
}

?>

<section>
    <div class="container-fluid page-header mb-5">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Cart</h1>
        </div>
    </div>
    <div class="container py-5 mt-5">
        <h2>Your Shopping Cart</h2>

        <?php if (!empty($cart)) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item) : ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><img src="<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" style="width: 50px;"></td>
                            <td><?php echo number_format($item['price'], 0); ?> VND</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>
                                <!-- Form for removing from cart -->
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="remove_from_cart">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        <?php else : ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</section>

<?php
include_once __DIR__ . '/partials/footer.php';
?>
