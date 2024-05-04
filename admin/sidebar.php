<!-- Sidebar -->
<div class="sidebar" id="mySidebar">
    <!-- Sidebar Header -->
    <div class="side-header">
        <!-- Logo -->
        <img src="./assets/images/logo.png" width="120" height="120" alt="Sweddeco Admin">
        <!-- Greeting -->
        <h5 style="margin-top:10px;">Hello, <?= $_SESSION["firstName"] ?></h5>
    </div>

    <!-- Horizontal Rule -->
    <hr style="border:1px solid; background-color:#3b5d50; border-color:#3B3131;">

    <!-- Close Button -->
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a>

    <!-- Navigation Links -->
    <a href="./"><i class="fa fa-home"></i> Dashboard</a>
    <a href="#customers" onclick="showCustomers()"><i class="fa fa-users"></i> Customers</a>
    <a href="#products" onclick="showProductItems()"><i class="fa fa-th"></i> Products</a>
    <a href="#orders" onclick="showOrders()"><i class="fa fa-list"></i> Orders</a>
</div>