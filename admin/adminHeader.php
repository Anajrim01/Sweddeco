<?php
// Check if logout is set in POST
if (isset($_POST['logout'])) {
    // Unset all session values
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the home page or login page
    header("Location: ../");
    exit();
}
?>

<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #3b5d50;">

    <!-- Home Button -->
    <div class="navbar-nav mr-auto">
        <button class="navbar-toggler openbtn" type="button" onclick="openNav()">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
    </div>

    <!-- Logo centered -->
    <a class="navbar-brand mx-auto" href="./">
        <img src="../assets/images/sweddeco_logo.png" width="80" height="80" alt="Sweddeco">
    </a>

    <!-- Logout to the right -->
    <div class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="" method="post">
                <button type="submit" name="logout" class="btn btn-link" style="color: #fff; font-size:25px;">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </button>
            </form>
        <?php endif; ?>
    </div>

</nav>