<?php
// Start session
session_start();

// Check if admin is set in the session
if (!isset($_SESSION["admin"])) {
    // If not set, return 401 Unauthorized status code and exit
    http_response_code(401);
    die('{"message": "401: Unauthorized", "code": 0}');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <?php
    // Include header and sidebar
    include "./adminHeader.php";
    include "./sidebar.php";

    // Include database connection
    include_once "./config/dbconnect.php";
    ?>

    <div id="main-content" class="container allContent-section py-4">
        <div class="row">
            <!-- Start Total Users Card -->
            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-users  mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Users</h4>
                    <h5 style="color:white;">
                        <?php
                        // Query to get all non-admin users
                        $sql = "SELECT * from users where isAdmin=0";
                        $result = $conn->query($sql);
                        // Initialize count
                        $count = 0;
                        // If result has rows, increment count for each row
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $count++;
                            }
                        }
                        // Echo the count
                        echo $count;
                        ?>
                    </h5>
                </div>
            </div>
            <!-- End Total Users Card -->

            <!-- Start Total Products Card -->
            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-th mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Products</h4>
                    <h5 style="color:white;">
                        <?php
                        $json = file_get_contents('../assets/json/items.json');
                        $products = json_decode($json, true);
                        echo sizeof($products);
                        ?>
                    </h5>
                </div>
            </div>
            <!-- End Total Products Card -->
            
            <!-- Start Total Orders Card -->
            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-list mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total orders</h4>
                    <h5 style="color:white;">
                        <?php
                        $sql = "SELECT * from orders";
                        $result = $conn->query($sql);
                        $count = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $count = $count + 1;
                            }
                        }
                        echo $count;
                        ?>
                    </h5>
                </div>
            </div>
            <!-- End Total Orders Card -->

            <!-- Start Total Profit Card -->
            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-dollar mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Profit</h4>
                    <h5 style="color:white;">
                        <?php

                        $sql = "SELECT * from order_details";
                        $result = $conn->query($sql);
                        $profit = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $profit = $profit + $row['price'];
                            }
                        }
                        echo $profit . ' SEK';
                        ?>
                    </h5>
                </div>
            </div>
            <!-- End Total Profit Card -->
        </div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>