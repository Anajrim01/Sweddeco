// Initialize cart from local storage or as an empty array
let cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];

document.querySelectorAll('.product-item').forEach(item => {
    item.addEventListener('click', () => {
        // Elements for the offcanvas UI
        const offcanvasTitle = document.querySelector('#offcanvasRightLabel');
        const offcanvasBody = document.querySelector('#offcanvasRight .offcanvas-body');

        // Product details
        const title = item.querySelector('.product-title').textContent;
        const description = item.querySelector('.product-description').textContent;
        const price = item.querySelector('.product-price').textContent;
        const image = item.querySelector('.product-thumbnail').src;
        const productId = item.querySelector('.product-id').textContent;

        // Cart logic
        let res = cart.find(el => el.id == productId);

        // Update offcanvas UI with product details
        offcanvasTitle.textContent = title;
        offcanvasBody.innerHTML = `
            <!-- Start Product Display Section -->
            <img src="${image}" class="img-fluid product-thumbnail">
            <h3 class="product-title">${title}</h3>
            <p class="product-description">${description}</p>
            <strong class="product-price">${price}</strong>
            <!-- End Product Display Section -->
            
            <!-- Start Add To Cart Section -->
            <div class="add-to-cart">
                <input type="number" value="${(res !== undefined) ? res.quantity : 1}" min="1" class="quantity-input">
                <button class="add-to-cart-button">Add to cart</button>
            </div>
            <!-- End Add To Cart Section -->
        `;

        // Add to cart button event listener
        offcanvasBody.querySelector('.add-to-cart-button').addEventListener('click', () => {
            const quantityInput = offcanvasBody.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value, 10) || 1; // Default to 1 if input is invalid

            // Cart logic : Recheck in case adding item multiple times
            res = cart.find(el => el.id == productId);
            
            // If product is not in cart, add it
            if (res == undefined) {
                let product = {
                    id: productId,
                    title: title,
                    price: price.replace(" SEK", ""),
                    image: image,
                    quantity: quantity // Use the quantity from the input
                };
                cart.push(product);
            }
            // If product is in cart, update quantity
            else {
                res.quantity += quantity;
            }

            // Update local storage and cart
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
        });
    });
});

// Function to remove a product from the cart
function removeProduct(productId) {
    // Filter out the product to be removed
    let temp = cart.filter((item) => {
        return item.id != productId;
    });

    // Update local storage and cart
    localStorage.setItem('cart', JSON.stringify(temp));
    updateCart();
}

// Function to update cart items
function updateCart() {
    // Get cart from local storage
    cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];
    let cartItems = document.getElementById('cart-items');
    if (cartItems == undefined) 
        return;
    cartItems.innerHTML = '';

    // If cart is empty, display message
    if (cart == [] || cart.length == 0) {
        cartItems.innerHTML += `
        <tr>
            <td colspan="6" class="text-center">
                <strong class="text-black">Your cart is empty.</strong>
            </td>
        </tr>`;

        // Hide the options
        document.getElementById('coupon-row').style.display = 'none';
        document.getElementById('totals-row').style.display = 'none';
        
        // Update total price
        document.querySelectorAll('.total-price').forEach((item) => item.textContent = `0.00 SEK`);
        return;
    }

    // Calculate total price
    let total = 0;

    // Display each item in the cart
    cart.forEach(item => {
        total += item.price * item.quantity;
        cartItems.innerHTML += `
			<tr>
				<td class="product-thumbnail">
					<img src="${item.image}" alt="Image" class="img-fluid">
				</td>
				<td class="product-name">
					<h2 class="h5 text-black">${item.title}</h2>
				</td>
				<td>${item.price} SEK</td>
				<td>
					<div class="input-group mb-3 d-flex align-items-center quantity-container" style="margin-left: auto; margin-right: auto; max-width: 120px;">
						<div class="input-group-prepend">
							<button class="btn btn-outline-black js-btn-minus" onclick="updateQuantities(${item.id}, ${-1})" type="button">−</button>
						</div>
						<input type="text" class="form-control text-center" value="${item.quantity}" disabled>
						<div class="input-group-append">
							<button class="btn btn-outline-black js-btn-plus" onclick="updateQuantities(${item.id}, ${1})" type="button">+</button>
						</div>
					</div>
				</td>
				<td>${(item.price * item.quantity).toFixed(2)} SEK</td>
				<td><a href="#" class="btn btn-primary btn-sm" onclick="removeProduct(${item.id})">X</a></td>
			</tr>
		`;
    });

    // Update total price
    document.querySelectorAll('.total-price').forEach((item) => item.textContent = `${total.toFixed(2)} SEK`);
}

// Function to update quantities of a product
function updateQuantities(productId, quantity) {
    // Find product and update quantity
    for (let product of cart) {
        if (product.id == productId) {
            product.quantity += quantity;
            if (product.quantity <= 0)
                removeProduct(productId);
        }
    }

    // Update local storage and cart
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCart();
}


// Call updateCart on page load
updateCart();