<!-- Start of Container -->
<div class="container table-responsive">

    <!-- Start of Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>

        <?php
        // Include the database connection file
        include_once "../config/dbconnect.php";

        // Get the order ID from the GET request
        $ID = $_GET['orderID'];

        // Read the JSON file containing products
        $productsJson = file_get_contents('../../assets/json/items.json');

        // Decode the JSON data into a PHP array
        $products = json_decode($productsJson, true);

        // SQL query to select all details for the given order ID
        $sql = "SELECT * FROM order_details WHERE order_id = $ID";

        // Execute the SQL query
        $result = $conn->query($sql);

        // Check if the query returned any rows
        if ($result->num_rows > 0) {
            // Loop through each row in the result
            while ($row = $result->fetch_assoc()) {
                // Get the product ID from the row
                $product_id = $row['productId'];
                ?>

                <!-- Start of Table Row -->
                <tr>
                    <?php
                    // Find the product in the decoded JSON data
                    foreach ($products as $product) {
                        // Check if the product ID matches the one in the row
                        if ($product['id'] == $product_id) {
                            ?>

                            <!-- Display the product image and title -->
                            <td><img height="80px" src="../<?= $product["image"] ?>"></td>
                            <td><?= $product["title"] ?></td>

                            <?php
                            // Break the loop after finding the product
                            break;
                        }
                    }
                    ?>

                    <!-- Display the quantity and price -->
                    <td><?= $row["quantity"] ?></td>
                    <td><?= $row["price"] ?> SEK</td>
                </tr>
                <!-- End of Table Row -->

                <?php
            }
        } else {
            // Display a message if no order details were found
            echo "No order details found.";
        }
        ?>
    </table>
    <!-- End of Table -->

</div>
<!-- End of Container -->