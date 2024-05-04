<?php
// Read the JSON file containing products
$jsonString = file_get_contents('../../assets/json/items.json');
$products = json_decode($jsonString, true);

// Check if the delete request has been submitted
if (isset($_POST['record'])) {
    // Retrieve the product ID from the form and sanitize the input
    $p_id = filter_input(INPUT_POST, 'record', FILTER_SANITIZE_NUMBER_INT);

    // Iterate through the products to find the matching product ID
    foreach ($products as $key => $product) {
        if ($product['id'] == $p_id) {
            // Remove the product from the array
            unset($products[$key]);
            // Re-index the array to maintain sequential indexes
            $products = array_values($products);
            break; // Exit the loop after the product is found and deleted
        }
    }

    // Encode the updated products array to JSON format
    $newJsonString = json_encode($products, JSON_PRETTY_PRINT);

    // Write the updated JSON string to the file
    if (file_put_contents('../../assets/json/items.json', $newJsonString)) {
        // echo "Product Item Deleted";
    } else {
        // echo "Not able to delete";
    }
}
?>