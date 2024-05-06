<?php
// Start the session
session_start();
$errors = null;

// Check if the user has requested to logout
if (isset($_GET["logout"])) {
	// Clear all session variables
	$_SESSION = array();

	// Destroy the session
	session_destroy();
}

// Include the database connection file
require_once './admin/config/dbconnect.php';

// Check if the user is already logged in
if (isset($_SESSION["loggedin"])) {
	if ($_SESSION["loggedin"]) {
		if (isset($_SESSION["admin"])) {
			// Redirect to the admin page
			header("Location: ./admin");
			exit;
		} else {
			die("<h1>This is currently under the works. To manage your order kindly contact support :)</h1><br><h2><a href='?logout'>Logout</a></h2>");
		}
	}
}

// Check if the form was submitted
if (isset($_POST['email']) && isset($_POST['password'])) {
	// Get user input
	$userEmail = $_POST['email'];
	$userPassword = $_POST['password'];

	// Prepare a select statement
	$sql = "SELECT user_id, first_name, contact_no, password, isAdmin FROM users WHERE email = ?";

	if ($stmt = $conn->prepare($sql)) {
		// Bind variables to the prepared statement as parameters
		$stmt->bind_param("s", $param_email);

		// Set parameters
		$param_email = $userEmail;

		// Attempt to execute the prepared statement
		if ($stmt->execute()) {
			// Store result
			$stmt->store_result();

			// Check if email exists, if yes then verify password
			if ($stmt->num_rows == 1) {
				// Bind result variables
				$stmt->bind_result($id, $firstName, $phone, $hashedPassword, $admin);
				if ($stmt->fetch()) {
					if (password_verify($userPassword, $hashedPassword)) {
						// Store data in session variables
						$_SESSION["loggedin"] = true;
						$_SESSION["user_id"] = $id;
						$_SESSION["phone"] = $phone;
						$_SESSION["firstName"] = $firstName;

						if (isset($_GET['return'])) {
							$returnUrl = urldecode($_GET['return']);
							if ($admin)
								$_SESSION["admin"] = $admin;
							header('Location: ' . $returnUrl);
							exit;
						} else {
							if ($admin) {
								$_SESSION["admin"] = $admin;
								// Redirect admin to admin page
								header("Location: ./admin");
								exit;
							} else {
								// todo. Make a user page to manage their orders
								exit;
							}
						}

					} else {
						// Display an error message if password is not valid
						$errors = "Invalid email or password. Please try again.";
					}
				}
			} else {
				// Display an error message if email doesn't exist
				$errors = "Invalid email or password. Please try again.";
			}
		} else {
			$errors = "Oops! Something went wrong. Please try again later.";
		}

		// Close statement
		$stmt->close();
	}

	// Close connection
	$conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Sweddeco">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap5" />

	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<title>Sweddeco</title>
</head>

<body>

	<!-- Start Header/Navigation -->
	<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Sweddeco navigation bar">

		<div class="container">
			<a class="navbar-brand" href="index">Sweddeco<span>.</span></a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsSweddeco"
				aria-controls="navbarsSweddeco" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsSweddeco">
				<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
					<li class="nav-item ">
						<a class="nav-link" href="index">Home</a>
					</li>
					<li><a class="nav-link" href="shop">Shop</a></li>
					<li><a class="nav-link" href="about">About us</a></li>
					<li><a class="nav-link" href="blog">Blog</a></li>
					<li><a class="nav-link" href="contact">Contact us</a></li>
				</ul>

				<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
					<li><a class="nav-link" href="#"><img src="assets/images/user.svg"></a></li>
					<li><a class="nav-link" href="cart"><img src="assets/images/cart.svg"></a></li>
				</ul>
			</div>
		</div>

	</nav>
	<!-- End Header/Navigation -->

	<!-- Start Member Section -->
	<section class="gradient-form">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-xl-10">
					<div class="card rounded-3 text-black">
						<div class="row g-0">
							<div class="col-lg-6">
								<div class="card-body p-md-5 mx-md-4">

									<div class="text-center">
										<img src="assets/images/sweddeco_logo.png" style="width: 185px;" alt="logo">
										<h4 class="mt-1 mb-5 pb-1">Sweddeco</h4>
									</div>

									<form method="POST">
										<p>Please login to your account</p>

										<div class="form-floating mb-4">
											<input type="email" id="email" class="form-control" name="email"
												placeholder="" />
											<label class="form-label" for="email">Email</label>
										</div>

										<div class="form-floating mb-4">
											<input type="password" id="password" class="form-control" name="password"
												placeholder="" />
											<label class="form-label" for="password">Password</label>
										</div>
										<div class="text-danger small">
											<?php echo $errors; ?>
										</div>
										<div class="text-center pt-1 mb-5 pb-1">
											<button class="btn btn-primary btn-lg w-100 gradient-custom-2 loginbtn mb-3"
												type="submit">Log in</button>
											<a class="text-muted" href="#!">Forgot password?</a>
										</div>

										<!-- <div class="d-flex align-items-center justify-content-center pb-4">
											<p class="mb-0 me-2">Don't have an account?
												// ToDo: Switch to different panel
												<a href="#!">Create new</a>
											</p>
										</div> -->

									</form>

								</div>
							</div>
							<div class="col-lg-6 d-flex align-items-center gradient-custom-2">
								<div class="text-white px-3 py-4 p-md-5 mx-md-4">
									<h4 class="mb-4">Where Craftsmanship Meets Comfort</h4>
									<p class="small mb-0">At Sweddeco, we blend <strong>style</strong>,
										<strong>functionality</strong>,
										and <strong>comfort</strong> to craft <strong>exceptional interior
											spaces</strong>.<br>
										Our curated collection of furniture and
										decor is meticulously designed from <strong>premium materials</strong>,
										ensuring both <strong>aesthetics</strong> and <strong>durability</strong>.
										<br><br>Welcome to Sweddeco — <strong>where quality meets creativity</strong>.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Member Section -->

	<!-- Start Footer Section -->
	<footer class="footer-section">
		<div class="container relative">
			<div class="row g-5 mb-5">
				<div class="col-lg-4">
					<div class="mb-4 footer-logo-wrap"><a href="./" class="footer-logo">Sweddeco<span>.</span></a></div>
					<p class="mb-4">At Sweddeco, we create exceptional interior spaces that blend style,
						functionality, and comfort.
						Our curated collection of furniture and decor is crafted with excellent materials, ensuring
						both aesthetics and durability</p>

					<ul class="list-unstyled custom-social">
						<li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
					</ul>
				</div>


				<div class="col-lg-8">
					<div class="row links-wrap">
						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="about">About us</a></li>
								<li><a href="blog">Blog</a></li>
								<li><a href="contact">Contact us</a></li>
							</ul>
						</div>

						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="contact">Support</a></li>
								<li><a href="#">Knowledge base</a></li>
								<li><a href="#">Live chat</a></li>
							</ul>
						</div>

						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="#!">Jobs</a></li>
								<li><a href="about#team">Our team</a></li>
								<li><a href="privacy">Privacy Policy</a></li>
							</ul>
						</div>

						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<li><a href="#">Nordic Chair</a></li>
								<li><a href="#">Kruzo Aero</a></li>
								<li><a href="#">Ergonomic Chair</a></li>
							</ul>
						</div>
					</div>
				</div>

			</div>

			<div class="border-top copyright">
				<div class="row pt-4">
					<div class="col-lg-6">
						<p class="mb-2 text-center text-lg-start">Copyright &copy;
							<script>document.write(new Date().getFullYear());</script>. All Rights Reserved.
						</p>
					</div>

					<div class="col-lg-6 text-center text-lg-end">
						<ul class="list-unstyled d-inline-flex ms-auto">
							<li class="me-4"><a href="tos">Terms &amp; Conditions</a></li>
							<li><a href="privacy">Privacy Policy</a></li>
						</ul>
					</div>

				</div>
			</div>

		</div>
	</footer>
	<!-- End Footer Section -->

	<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>