<?php
// Read the JSON file containing products
$jsonString = file_get_contents('../../assets/json/items.json');
$products = json_decode($jsonString, true);

// Sanitize and validate the input data
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
$p_name = filter_input(INPUT_POST, 'p_name', FILTER_SANITIZE_STRING);
$p_desc = filter_input(INPUT_POST, 'p_desc', FILTER_SANITIZE_STRING);
$p_price = filter_input(INPUT_POST, 'p_price', FILTER_SANITIZE_STRING);

// Check if a new image file was uploaded
if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] == 0) {
    // Define the allowed image types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    // Extract the image name and temporary file path
    $img_name = $_FILES['newImage']['name'];
    $tmp = $_FILES['newImage']['tmp_name'];
    // Get the file extension
    $file_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

    // Check if the file is an allowed image type
    if (in_array($file_ext, $allowed_types)) {
        // Set the relative directory path
        $relative_dir = "../../";
        // Generate a unique file name to prevent overwriting
        $finalImage = "assets/images/Products/" . uniqid('prod_', true) . '.' . $file_ext;

        // Move the uploaded file to the final image location
        move_uploaded_file($tmp, $relative_dir . $finalImage);
    } else {
        // Handle the error for invalid file types
        // echo "Error: Invalid file type. Only JPG, JPEG, PNG, & GIF files are allowed.";
        exit;
    }
} else {
    // Use the existing image if no new image was uploaded
    $final_image = filter_input(INPUT_POST, 'existingImage', FILTER_SANITIZE_STRING);
}

// Update the product details in the array
foreach ($products as &$product) {
    if ($product['id'] == $product_id) {
        $product['title'] = $p_name;
        $product['description'] = $p_desc; // Update the description
        $product['price'] = $p_price;
        $product['image'] = $final_image;
        break;
    }
}
unset($product); // Unset the reference to avoid unexpected behavior

// Encode the updated products array to JSON format
$newJsonString = json_encode($products, JSON_PRETTY_PRINT);

// Write the updated JSON string to the file
if (file_put_contents('../../assets/json/items.json', $newJsonString)) {
    // echo "true";
} else {
    // echo "Error updating the products file.";
}
?>