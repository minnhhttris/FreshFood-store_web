<?php

use myproject\model\UsersModel;

include __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/partials/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userModel = new UsersModel();
    $result = $userModel->addUser($email, $username, $password);

    if ($result) {
        echo "Sign up successfully!>";
        header("Location: login.php");
    }
}
?>



<section>
    <div class="container-fluid page-header-login">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-5 display-5 fw-bold ls-tight px-5">
                    <!-- FreshFood <br /> -->
                    <span style="color: #008080;">Organic food - The secret to a healthy and long life.</span>
                </h1>

            </div>

            <div class="col-lg-6 mb-2 mb-lg-0 position-relative " style="margin-top: 100px;">
                <div class="card bg-glass" style="background-color: rgba(255, 255, 255, 0.8); border-radius: 10px; width: 80%; height: 70%;">
                    <div class="card-body py-5 px-md-5">
                        <!-- Form -->
                        <form id="signupForm" class="px-5" method="POST" action="#">
                            <p class="display-3 mb-5 text-center mt-1" style="color: #008080;">Sign up</p>

                            <div class="form-outline mb-2">
                                <label class="form-label text-dark" for="username">User Name</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" />
                            </div>

                            <div class="form-outline mb-2">
                                <label class="form-label text-dark" for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" />
                            </div>

                            <div class="form-outline mb-2">
                                <label class="form-label text-dark" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" />
                            </div>

                            <div class="form-outline mb-2">
                                <label class="form-label text-dark" for="repeatpassword">Confirm password</label>
                                <input type="password" id="repeatpassword" name="repeatpassword" class="form-control" placeholder="Confirm your password" />
                            </div>

                            <div class="form-check d-flex justify-content-center mb-2">
                                <input class="form-check-input me-2" type="checkbox" value="agree" name="agree" id="form2Example3cg" />
                                <label class="form-check-label" for="form2Example3g">I agree all statements</label>
                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn text-white mb-2" style="background-color: #008080;" name="signup" value="Sign Up">Sign up</button>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="mb-0 text-dark">Have already an account?
                                    <a href="login.php" style="color: #008080;">Login here</a>
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
        $("#signupForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 50
                },
                repeatpassword: {
                    required: true,
                    minlength: 8,
                    maxlength: 50,
                    equalTo: "#password"
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
                username: {
                    required: "Username must be at least 3 characters.",
                    minlength: "Username must be at least 3 characters.",
                    maxlength: "Username must be at most 50 characters."
                },
                email: {
                    required: "Email is required.",
                    email: "Please enter a valid email."
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 8 characters."
                },
                repeatpassword: {
                    required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
                },
                agree: {
                    required: "You must agree to the terms."
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
</script>

<?php
include_once __DIR__ . '/partials/footer.php';
?>