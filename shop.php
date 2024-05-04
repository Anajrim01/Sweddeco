<!doctype html>
<html lang="en">

<head>
	<!-- Meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Sweddeco">
	<link rel="shortcut icon" href="favicon.png">

	<!-- SEO tags -->
	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<!-- Stylesheets -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">

	<title>Sweddeco</title>
</head>

<body>
	<!-- Start Header/Navigation -->
	<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Sweddeco navigation bar">
		<div class="container">
			<!-- Brand -->
			<a class="navbar-brand" href="index">Sweddeco<span>.</span></a>

			<!-- Mobile menu button -->
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsSweddeco"
				aria-controls="navbarsSweddeco" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<!-- Navigation links -->
			<div class="collapse navbar-collapse" id="navbarsSweddeco">
				<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
					<li class="nav-item ">
						<a class="nav-link" href="index">Home</a>
					</li>
					<li class="active"><a class="nav-link" href="shop">Shop</a></li>
					<li><a class="nav-link" href="about">About us</a></li>
					<li><a class="nav-link" href="blog">Blog</a></li>
					<li><a class="nav-link" href="contact">Contact us</a></li>
				</ul>

				<!-- User and Cart links -->
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
						<h1>Shop</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Hero Section -->

	<!-- Start Product Section -->
	<div class="sweddeco_co-section product-section before-footer-section">
		<div class="container">
			<div class="row">
				<?php
				// Fetch items from JSON file
				$items = json_decode(file_get_contents('assets/json/items.json'), true);
				foreach ($items as $item) {
					echo '<div class="col-12 col-md-4 col-lg-3 mb-5">';
					echo '<a class="product-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight">';
					echo '<span style="display: none;" class="product-id">' . $item['id'] . '</span>';
					echo '<img src="' . $item['image'] . '" class="img-fluid product-thumbnail">';
					echo '<h3 class="product-title">' . $item['title'] . '</h3>';
					echo '<p class="product-description" style="display: none;">' . $item['description'] . '</p>';
					echo '<strong class="product-price">' . $item['price'] . ' SEK</strong>';
					echo '<span class="icon-cross">';
					echo '<img src="assets/images/cross.svg" class="img-fluid">';
					echo '</span>';
					echo '</a>';
					echo '</div>';
				}
				?>
			</div>

			<!-- todo: fix canvas for each item -->
			<!-- Offcanvas for product details -->
			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel"
				style="transition: all 0.1s ease-in-out 0s;">
				<div class="offcanvas-header">
					<h5 id="offcanvasRightLabel">Offcanvas right</h5>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
						aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<!-- Product details will be shown here -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Product Section -->

	<!-- Start Footer Section -->
	<footer class="footer-section">
		<div class="container relative">
			<div class="sofa-img">
				<img src="assets/images/sofa.png" alt="Image" class="img-fluid">
			</div>

			<div class="row">
				<div class="col-lg-8">
					<div class="subscription-form">
						<h3 class="d-flex align-items-center"><span class="me-1"><img src="assets/images/envelope-outline.svg"
									alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

						<!-- Subscription form -->
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

					<!-- Social media links -->
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
							<!-- Footer links -->
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
	<script src="assets/js/cart.js"></script>
</body>

</html>