<?php

use myproject\model\productmodel;
use myproject\model\ordermodel;

include __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/partials/header.php';

$productmodel = new productmodel();

if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {
    $id = $_GET['id'] ?? null;
    $product = $productmodel->getID($id);
    

    if (!$product) {
        echo "Product not found!";
    }

    
    if ($product && isset($product['price'])) {
        $productPrice = $product['price'];
        $formattedPrice = number_format($productPrice, 0, '.', ',') . ' VND';
    } else {
        echo "Invalid product data!";
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
   
    $fullname = $_POST['fullname'];
    $phonenumber = $_POST['phonenumber'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];
    
    $total_price = $quantity * $productPrice;

    $ordermodel = new ordermodel();
    $result = $ordermodel->insertOrder($product_id, $quantity, $fullname, $phonenumber, $address, $notes);
    if ($result) {
        echo "Order successfully!";
        header('Location: product.php');
    }

}
?>


<section>
    <div class="container-fluid page-header-login">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class=" position-relative" style="margin-top: 100px;">
                <div class="card bg-glass" style="background-color: rgba(255, 255, 255, 0.5); border-radius: 10px;">
                    <div class="card-body py-5 px-md-5 d-flex align-items-center justify-content-center">
                        <form id="OrdersForm" class="p-3" style="border: 1px solid #ccc; border-radius: 10px;" method="POST" action="">
                            <div class="row d-flex align-items-center justify-content-center py-2">
                                <legend>Product</legend>

                                <div class="product-menu-img col-md-4">
                                    <img src="<?php echo $product['img'] ?>" alt="" class="img-responsive img-curve w-50">
                                </div>

                                <div class="product-menu-desc col-md-8">
                                    <a class="text-dark"> <?php echo $product['name'] ?></a>
                                    <p class="product-price" id="price">
                                        <?php echo $formattedPrice; ?>
                                    </p>
                                    <div class="order-lable"></div>
                                    <input type="number" name="quantity" class="input-responsive" value="1" id="quantity" required>
                                    <span>Kg</span>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>"/>
                            <div class="row">
                                <legend class="mt-4">Your Information</legend>
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="fullname">Full Name</label>
                                        <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter name.." required />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" id="phonenumber" name="phonenumber" class="form-control" placeholder="Enter phone number.." required />
                                </div>
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control" placeholder="Enter address.." required />
                            </div>


                            <div class="form-outline mb-4">
                                <label class="form-label" for="notes">Notes</label>
                                <input class="form-control" id="notes" name="notes" rows="3" placeholder="What do you want to require?" required/>
                            </div>

                            <div>
                                <h5 id="total_price"><span id="display_total"><?php echo $formattedPrice; ?></span></h5>
                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                <button type="submit"  class="btn btn-primary mb-4 ">
                                    Buy now
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const price = parseFloat(<?php echo $productPrice; ?>);
    const inputquantity = document.querySelector('#quantity');
    const total = document.querySelector('#display_total');

    updateTotal();

    inputquantity.addEventListener('input', function(e) {
        updateTotal();
    });

    function updateTotal() {
        const quantity = parseFloat(inputquantity.value);
        const totalPrice = quantity * price;
        total.innerHTML = `Total: ${totalPrice.toFixed(0)} VND`;
    }



    $(document).ready(function() {
        $("#OrdersForm").validate({
            rules: {
                fullname: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                phonenumber: {
                    required: true,
                    minlength: 10,
                    maxlength: 15,
                    number: true
                },
                address: {
                    required: true,
                    minlength: 5
                },
                notes: {
                    required: true,
                    minlength: 2
                },

            },
            messages: {
                fullname: {
                    required: "Please enter your full name.",
                    minlength: "Full name must be at least 3 characters.",
                    maxlength: "Full name must be at most 50 characters."
                },
                phonenumber: {
                    required: "Please enter your phone number.",
                    minlength: "Phone number must be at least 10 characters.",
                    maxlength: "Phone number must be at most 15 characters.",
                    number: "Please enter a valid phone number."
                },
                address: {
                    required: "Please enter your address.",
                    minlength: "Address must be at least 5 characters."
                },
                notes: {
                    required: "Notes must be at least 2 characters. If you don't have required, please enter 'no'!",
                    minlength: "Notes must be at least 2 characters. If you don't have required, please enter 'no'!"
                },

            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            
        });
    });
</script>

<?php
include_once __DIR__ . '/partials/footer.php';
?>