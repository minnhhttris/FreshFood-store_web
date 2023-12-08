<?php

use myproject\model\UsersModel;

include_once __DIR__ . '/partials/header.php';
include __DIR__ . '/../vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userModel = new UsersModel();
        $user = $userModel->verifyUser($email, $password);

        if ($user) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Log in fail, please check email or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        echo "Invalid request";
        exit();
    }
}

?>


<section>
    <div class="container-fluid page-header-login">
        <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger mb5" style="background-color: rgba(255, 128, 128, 0.5);" role="alert">
                        <strong>Đăng nhập thất bại!</strong> <br/> ' . $_SESSION['error_message'] . '
                    </div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-5 display-5 fw-bold ls-tight px-5">

                    <span class="animated slideInDown" style="color: #008080;">Organic food - The best choice for health and the environment.</span>
                </h1>

            </div>

            <div class="col-lg-6 mb-5 mb-lg-0 position-relative" style="margin-top: 100px;">
                <div class="card bg-glass" style="background-color: rgba(255, 255, 255, 0.8); border-radius: 10px; width: 70%">
                    <div class="card-body py-5 px-md-5">
                        <form id="loginForm" class="px-5" method="POST" action="#">
                            <p class="display-3 mb-5 text-center mt-2" style="color: #008080;">Login</p>

                            <div class="form-outline mb-2">
                                <label class="form-label text-dark" for="email-login">Email Address</label>
                                <input type="email" id="email-login" name="email" class="form-control" placeholder="Enter email address" />

                            </div>

                            <div class="form-outline mb-2">
                                <label class="form-label text-dark" for="password-login">Password</label>
                                <input type="password" id="password-login" name="password" class="form-control" placeholder="Enter password" />

                            </div>

                            <!-- <div class="form-check mb-4">
                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                                <label class="form-check-label" for="form2Example33">
                                    Remember me
                                </label>
                            </div> -->


                            <div class="d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn text-white mb-4" style="background-color: #008080;">
                                    Login
                                </button>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="mb-0 text-dark">Don't have an account?
                                    <a href="signup.php" style="color: #008080;">Sign Up</a>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $("#loginForm").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 50
                },
                email: {
                    required: true,
                    email: true
                },
                agree: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Email is required.",
                    email: "Please enter a valid email."
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 8 characters."

                },
                agree: {

                }
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
            }
        });
    });
    $("#logout").on("click", function(e) {
        e.preventDefault();
        console.log("Logout button clicked");
        $.ajax({
            type: "POST",
            url: "login.php",
            data: {
                action: 'logout'
            },
            success: function(response) {
                if (response.trim() === "Logout success") {
                    location.reload(true);
                } else {
                    alert("Logout fail! " + response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error: " + textStatus + " - " + errorThrown);
            }
        });
    });
</script>

<?php
include_once __DIR__ . '/partials/footer.php';
?>