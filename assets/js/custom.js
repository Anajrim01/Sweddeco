(function () {
	'use strict';

	// Function to initialize the tiny slider
	var tinyslider = function () {
		// Select all elements with class 'testimonial-slider'
		var el = document.querySelectorAll('.testimonial-slider');

		// Check if there are any elements
		if (el.length > 0) {
			// Initialize the slider
			var slider = tns({
				container: '.testimonial-slider',
				items: 1,
				axis: "horizontal",
				controlsContainer: "#testimonial-nav",
				swipeAngle: false,
				speed: 700,
				nav: true,
				controls: true,
				autoplay: true,
				autoplayHoverPause: true,
				autoplayTimeout: 3500,
				autoplayButtonOutput: false
			});
		}
	};

	// Call the tinyslider function
	tinyslider();

	// Function to handle plus and minus buttons
	var sitePlusMinus = function () {

		var value,
			quantity = document.getElementsByClassName('quantity-container');

		// Function to create bindings for increase and decrease buttons
		function createBindings(quantityContainer) {
			var quantityAmount = quantityContainer.getElementsByClassName('quantity-amount')[0];
			var increase = quantityContainer.getElementsByClassName('increase')[0];
			var decrease = quantityContainer.getElementsByClassName('decrease')[0];
			increase.addEventListener('click', function (e) { increaseValue(e, quantityAmount); });
			decrease.addEventListener('click', function (e) { decreaseValue(e, quantityAmount); });
		}

		// Function to initialize the bindings
		function init() {
			for (var i = 0; i < quantity.length; i++) {
				createBindings(quantity[i]);
			}
		};

		// Function to increase the value
		function increaseValue(event, quantityAmount) {
			value = parseInt(quantityAmount.value, 10);

			console.log(quantityAmount, quantityAmount.value);

			value = isNaN(value) ? 0 : value;
			value++;
			quantityAmount.value = value;
		}

		// Function to decrease the value
		function decreaseValue(event, quantityAmount) {
			value = parseInt(quantityAmount.value, 10);

			value = isNaN(value) ? 0 : value;
			if (value > 0) value--;

			quantityAmount.value = value;
		}

		// Initialize the bindings
		init();

	};

	// Call the sitePlusMinus function
	sitePlusMinus();

})()