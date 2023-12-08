<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FreshFood - Organic Food</title>
    <meta content="width=device-width, initial-scale=1.0" shrink-to-fit=no name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/public/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/./css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <!-- <link href="/public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet"> -->

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/public/css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 ">
        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5" >
            <a href="index.php" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold m-0" style="color: #006666;">FreshFood</span></h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav p-3 ms-auto p-lg-0">
                    <a href="index.php" class="nav-item nav-link" style="color: #006666;">Home</a>
                    <a href="product.php" class="nav-item nav-link" style="color: #006666;">Product</a>
                    
                </div>
                <div class="d-none d-lg-flex ms-2 me-2">
                    <a class="btn-sm-square bg-white rounded-circle ms-3" id="search-button" href="">
                        <small class="fa fa-search text-body"></small>
                    </a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="cart.php">
                        <small class="fa fa-shopping-bag text-body"></small>
                    </a>

                    <?php
                    // session_start();
                    if (isset($_SESSION['user'])) {
                        echo
                        '<a>
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #006666">
                                        ' . $_SESSION['user'] . '
                                    </a>
                                    <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item" href="">Email: ' . (isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A') . '</a></li>
                                        <li><form method="POST" action="/public/logout.php"><button type="submit" class="btn btn-light">Logout</button></form></li>
                                    </ul>
                                </div>
                        </a>';
                    } else {
                        echo
                        '<a class="btn-sm-square bg-white rounded-circle ms-3" href="login.php">
                                    <small class="fa fa-user text-body"></small>
                        </a>';
                    }
                    ?>
                    
                </div>
            </div>
        </nav>
    </div>
    