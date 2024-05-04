// Initialize cart from local storage or as an empty array
let cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];

// Get the checkout element
let checkOut = document.getElementById('items');

// Initialize total price
let total = 0;

// Iterate over each item in the cart
cart.forEach(item => {
    // Update total price
    total += item.price * item.quantity;

    // Add item to checkout
    checkOut.innerHTML +=
        `
        <tr>
            <td>${item.title}<strong class="mx-2">x</strong> ${item.quantity}</td>
            <td>${item.price} SEK</td>
        </tr>
    `;
});

// Display subtotal and total price
checkOut.innerHTML += `
    <tr>
        <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
        <td class="text-black">${total.toFixed(2)} SEK</td>
    </tr>
    <tr>
        <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
        <td class="text-black font-weight-bold"><strong>${total.toFixed(2)} SEK</strong></td>
    </tr>
`;

$(document).ready(function() {
    $('#checkoutForm').on('submit', function(e) {
        // Assuming 'cart' is defined and accessible here
        let cartData = JSON.stringify(cart);

        // Function to set a cookie
        function setCookie(name, value, daysToLive) {
            let cookieValue = encodeURIComponent(value);
            let date = new Date();
            date.setTime(date.getTime() + (daysToLive * 24 * 60 * 60 * 1000));
            let expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + cookieValue + ";" + expires + ";path=/";
        }

        // Set the 'cart' cookie with the cart data, set to expire in 1 day
        setCookie('cart', cartData, 1);

        // Remove the cart from localStorage
        localStorage.removeItem('cart');
    });
});