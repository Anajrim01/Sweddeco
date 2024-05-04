<?php
// Read the JSON file containing products
$jsonString = file_get_contents('../../assets/json/items.json');
$products = json_decode($jsonString, true);

// Check if the upload form has been submitted
if (isset($_POST['upload'])) {
    // Retrieve product details from the form and sanitize the input
    $ProductName = filter_input(INPUT_POST, 'p_name', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'p_desc', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'p_price', FILTER_SANITIZE_STRING);

    // Check if the uploaded file is set and is an image
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['file']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        // Verify the file type is allowed
        if (in_array(strtolower($filetype), $allowed)) {
            $temp = $_FILES['file']['tmp_name'];

            // Generate a unique name for the image to prevent overwriting
            $newFileName = uniqid('prod_', true) . '.' . $filetype;
            $relative_dir = "../../";
            $finalImage = "assets/images/Products/" . $newFileName;

            // Move the uploaded file to the final image location
            move_uploaded_file($temp, $relative_dir . $finalImage);

            // Create a new product array
            $newProduct = array(
                "id" => count($products) + 1, // Assign a new ID to the product
                "title" => $ProductName,      // Set the product name
                "description" => $desc,       // Set the product description
                "price" => $price,            // Set the product price
                "image" => $finalImage        // Set the image path
            );

            // Add the new product to the existing products array
            $products[] = $newProduct;

            // Encode the updated products array to JSON format
            $newJsonString = json_encode($products, JSON_PRETTY_PRINT);

            // Write the updated JSON string to the file
            if (file_put_contents('../../assets/json/items.json', $newJsonString)) {
                // echo "Records added successfully.";
            } else {
                // echo "Error updating the products file.";
            }
        } else {
            // echo "Error: Only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    } else {
        // echo "Error: No file uploaded or file upload error.";
    }
}
?>