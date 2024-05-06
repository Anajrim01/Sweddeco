<?php
session_start();

include 'admin/config/dbconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	var_dump($_POST);
	// Validate inputs
	$firstName = trim($_POST['c_fname']);
	$lastName = trim($_POST['c_lname']);
	$userAddress = trim($_POST['c_address']) . ' ' . trim($_POST['c_address2']) . ', ' . trim($_POST['c_postal_zip']) . ', ' . trim($_POST['c_state_country']) . ', ' . trim($_POST['c_diff_country']);
	$orderNotes = trim($_POST['c_order_notes']);

	$isAdmin = 0; // Set default value

	// Check if user is logged in or not
	if (!isset($_SESSION["loggedin"])) {
		$email = trim($_POST['c_email_address']);
		$password = password_hash(trim($_POST['c_account_password']), PASSWORD_DEFAULT);
		$contactNo = trim($_POST['c_phone']);

		// User is not logged in, create an account
		$sql = "INSERT INTO users (first_name, last_name, email, password, contact_no, isAdmin, user_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
		if ($stmt = mysqli_prepare($conn, $sql)) {
			mysqli_stmt_bind_param($stmt, "sssssis", $firstName, $lastName, $email, $password, $contactNo, $isAdmin, $userAddress);
			if (mysqli_stmt_execute($stmt)) {
				$_SESSION["loggedin"] = true;
				$_SESSION["user_id"] = mysqli_insert_id($conn);
				$_SESSION["phone"] = $contactNo;
				$_SESSION["firstName"] = $firstName;
			} else {
				echo "Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}

	$contactNo = $_SESSION['phone'];

	// Now place the order
	$userId = $_SESSION["user_id"];
	$deliveryAddress = $userAddress;
	$payMethod = 'Swish'; // Set default value as no payment gateway
	$payStatus = 0; // Set default value
	$orderStatus = 0; // Set default value
	$fullName = $firstName . ' ' . $lastName;

	$sql = "INSERT INTO orders (user_id, customer, phone_no, delivery_address, pay_method, pay_status, order_status, order_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	if ($stmt = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt, "issssiis", $userId, $fullName, $contactNo, $deliveryAddress, $payMethod, $payStatus, $orderStatus, $orderNotes);
		if (mysqli_stmt_execute($stmt)) {
			$orderId = mysqli_insert_id($conn);
		} else {
			echo "Something went wrong. Please try again later.";
		}
		mysqli_stmt_close($stmt);
	}

	// Now add the products to the order_details table
	$cart = json_decode($_COOKIE['cart'], true);
	foreach ($cart as $item) {
		// Retrieve the product ID and quantity from your existing cart structure
		$productId = $item['id'];
		$quantity = $item['quantity'];

		// Now retrieve the price from the JSON structure
		$price = $item['price'];

		// Prepare your SQL statement with the order details
		$sql = "INSERT INTO order_details (order_id, quantity, price, productId) VALUES (?, ?, ?, ?)";
		if ($stmt = mysqli_prepare($conn, $sql)) {
			// Bind the parameters to the SQL statement
			mysqli_stmt_bind_param($stmt, "iiii", $orderId, $quantity, $price, $productId);

			// Execute the statement
			if (!mysqli_stmt_execute($stmt)) {
				echo "Something went wrong. Please try again later.";
			}

			// Close the prepared statement
			mysqli_stmt_close($stmt);
		}
	}

	// Redirect to thank you page
	header("location: thankyou.php");
	exit;
}
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Sweddeco">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<title>Sweddeco</title>
</head>

<body>
	<!-- Start Header/Navigation -->
	<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Sweddeco navigation bar">

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
					<li><a class="nav-link" href="login"><img src="assets/images/user.svg"></a></li>
					<li><a class="nav-link" href="cart"><img src="assets/images/cart.svg"></a></li>
				</ul>
			</div>
		</div>

	</nav>
	<!-- End Header/Navigation -->

	<!-- Start Hero Section -->
	<div class="hero">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="intro-excerpt">
						<h1>Checkout</h1>
					</div>
				</div>
				<div class="col-lg-7">

				</div>
			</div>
		</div>
	</div>
	<!-- End Hero Section -->

	<div class="sweddeco_co-section">
		<div class="container">

			<?php if (!isset($_SESSION["loggedin"])) { ?>
				<div class="row mb-5">
					<div class="col-md-12">
						<div class="border p-4 rounded" role="alert">
							Returning customer? <a href="login?return=<?php echo urlencode('checkout.php'); ?>">Click
								here</a> to login
						</div>
					</div>
				</div>
				<?php
			} ?>

			<form class="row" id="checkoutForm" method="POST">
				<div class="col-md-6 mb-5 mb-md-0">
					<h2 class="h3 mb-3 text-black">Billing Details</h2>
					<div class="p-3 p-lg-5 border bg-white">
						<div class="form-group">
							<label for="c_diff_country" class="text-black">Country <span
									class="text-danger">*</span></label>
							<select id="c_diff_country" class="form-control" name="c_diff_country" required>
								<option value="" disabled selected>Select a country</option>
								<option value="Sweden">Sweden</option>
								<option value="Norway">Norway</option>
								<option value="Denmark">Denmark</option>
								<option value="Finland">Finland</option>
							</select>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label for="c_fname" class="text-black">First Name <span
										class="text-danger">*</span></label>
								<input type="text" class="form-control" id="c_fname" name="c_fname" required>
							</div>
							<div class="col-md-6">
								<label for="c_lname" class="text-black">Last Name <span
										class="text-danger">*</span></label>
								<input type="text" class="form-control" id="c_lname" name="c_lname" required>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-12">
								<label for="c_address" class="text-black">Address <span
										class="text-danger">*</span></label>
								<input type="text" class="form-control" id="c_address" name="c_address"
									placeholder="Street address" required>
							</div>
						</div>

						<div class="form-group mt-3">
							<input type="text" class="form-control" id="c_address2" name="c_address2"
								placeholder="Apartment, suite, unit etc. (optional)">
						</div>

						<div class="form-group row">
							<div class="col-md-6">
								<label for="c_state_country" class="text-black">State / Country <span
										class="text-danger">*</span></label>
								<input type="text" class="form-control" id="c_state_country" name="c_state_country"
									required>
							</div>
							<div class="col-md-6">
								<label for="c_postal_zip" class="text-black">Zip Code<span
										class="text-danger">*</span></label>
								<input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip" required>
							</div>
						</div>

						<?php if (!isset($_SESSION["loggedin"])) { ?>
							<div class="form-group row mb-5">
								<div class="col-md-6">
									<label for="c_email_address" class="text-black">Email Address <span
											class="text-danger">*</span></label>
									<input type="text" class="form-control" id="c_email_address" name="c_email_address"
										required>
								</div>
								<div class="col-md-6">
									<label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="c_phone" name="c_phone"
										placeholder="Phone Number" required>
								</div>
							</div>

							<div class="form-group">
								<div class="py-2 mb-4">
									<p class="mb-3">Create an account by entering the information below. If you are a
										returning customer please login at the top of the page.</p>
									<div class="form-group">
										<label for="c_account_password" class="text-black">Account Password <span
												class="text-danger">*</span></label>
										<input type="password" class="form-control" id="c_account_password"
											name="c_account_password" placeholder="" required>
									</div>
								</div>
							</div>
						<?php } ?>

						<div class="form-group">
							<label for="c_order_notes" class="text-black">Order Notes</label>
							<textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" maxlength="512"
								class="form-control" placeholder="Write your notes here..."></textarea>
						</div>

					</div>
				</div>
				<div class="col-md-6">

					<div class="row mb-5">
						<div class="col-md-12">
							<h2 class="h3 mb-3 text-black">Coupon Code</h2>
							<div class="p-3 p-lg-5 border bg-white">

								<label for="c_code" class="text-black mb-3">Enter your coupon code if you have
									one</label>
								<div class="input-group w-75 couponcode-wrap">
									<input type="text" class="form-control me-2" id="c_code" placeholder="Coupon Code"
										aria-label="Coupon Code" aria-describedby="button-addon2">
									<div class="input-group-append">
										<button class="btn btn-black btn-sm" type="button"
											id="button-addon2">Apply</button>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="row mb-5">
						<div class="col-md-12">
							<h2 class="h3 mb-3 text-black">Your Order</h2>
							<div class="p-3 p-lg-5 border bg-white">
								<table class="table site-block-order-table mb-5">
									<thead>
										<th>Product</th>
										<th>Total</th>
									</thead>
									<tbody id="items">
									</tbody>
								</table>

								<div class="border p-3 mb-3">
									<h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse"
											href="#collapsebank" role="button" aria-expanded="false"
											aria-controls="collapsebank">Direct Bank Transfer</a></h3>

									<div class="collapse" id="collapsebank">
										<div class="py-2">
											<p class="mb-0">Make your payment directly into our bank account. Please use
												your Order ID as the payment reference. Your order won't be shipped
												until the funds have cleared in our account.</p>
										</div>
									</div>
								</div>

								<div class="border p-3 mb-3">
									<h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse"
											href="#collapsecheque" role="button" aria-expanded="false"
											aria-controls="collapsecheque">Swish</a></h3>

									<div class="collapse" id="collapsecheque">
										<div class="py-2">
											<p class="mb-0">Make your payment directly into our bank account. Please use
												your Order ID as the payment reference. Your order won't be shipped
												until the funds have cleared in our account.</p>
										</div>
									</div>
								</div>

								<div class="border p-3 mb-5">
									<h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse"
											href="#collapsepaypal" role="button" aria-expanded="false"
											aria-controls="collapsepaypal">Paypal</a></h3>

									<div class="collapse" id="collapsepaypal">
										<div class="py-2">
											<p class="mb-0">Make your payment directly into our bank account. Please use
												your Order ID as the payment reference. Your order won't be shipped
												until the funds have cleared in our account.</p>
										</div>
									</div>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-black btn-lg py-3 btn-block">Place
										Order</button>
								</div>

							</div>
						</div>
					</div>

				</div>
			</form>
			<!-- </form> -->
		</div>
	</div>

	<!-- Start Footer Section -->
	<footer class="footer-section">
		<div class="container relative">

			<div class="sofa-img">
				<img src="assets/images/sofa.png" alt="Image" class="img-fluid">
			</div>

			<div class="row">
				<div class="col-lg-8">
					<div class="subscription-form">
						<h3 class="d-flex align-items-center"><span class="me-1"><img
									src="assets/images/envelope-outline.svg" alt="Image"
									class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

						<form action="#!" class="row g-3">
							<div class="col-auto">
								<input type="text" class="form-control" placeholder="Enter your name">
							</div>
							<div class="col-auto">
								<input type="email" class="form-control" placeholder="Enter your email">
							</div>
							<div class="col-auto">
								<button class="btn btn-primary">
									<span class="fa fa-paper-plane"></span>
								</button>
							</div>
						</form>

					</div>
				</div>
			</div>

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="assets/js/checkout.js"></script>
</body>

</html>