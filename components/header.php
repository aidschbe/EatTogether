<?php
include_once("components/session.php");
include_once("components/imports.php");
?>

<header class="static-top p-3 mb-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap" />
                </svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
                <li><a href="#" class="nav-link px-2 text-white">About</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
            </form>

            <div class="text-end">
                <?php

                if (isset($_SESSION['userId'])) {
                    echo "<i class='bx bx-envelope m-1'></i>";
                    echo "<a href='account.php' class='btn btn-outline-light m-1'>Account</a>";
                    echo "<a href='groups.php' class='btn btn-outline-light m-1'>My Groups</a>";

                    echo
                    "
                        <form method='POST' style='display: inline'>
                            <button type='submit' name='logout' class='btn btn-warning m-1'>Logout</button>
                        </form>
                    ";

                    if (isset($_POST['logout'])) {
                        $userFunctions->logout();
                    }
                } else {

                    echo "<a href='login.php' class='btn btn-outline-light m-1'>Login</a>";
                    echo "<a href='register.php' class='btn btn-warning m-1'>Register</a>";
                }




                ?>
            </div>
        </div>
    </div>
</header>