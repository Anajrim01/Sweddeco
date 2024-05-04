<!-- Start of Container -->
<div class="container p-5">

  <h4>Edit Product Detail</h4>
  <?php
  // Fetch the product ID from the POST request
  $ID = $_POST['record'];

  // Get the contents of the JSON file
  $jsonString = file_get_contents('../../assets/json/items.json');

  // Decode the JSON string to an associative array
  $products = json_decode($jsonString, true);

  // Loop through each product in the products array
  foreach ($products as &$product) {
    // Check if the product ID matches the ID from the POST request
    if ($ID == $product['id']) {
      ?>
      <!-- Start of Form -->
      <form id="update-Items" onsubmit="updateItems()" enctype='multipart/form-data'>
        <!-- Product ID -->
        <div class="form-group">
          <input type="text" class="form-control" id="product_id" value="<?= $product['id'] ?>" hidden>
        </div>

        <!-- Product Name -->
        <div class="form-group">
          <label for="name">Product Name:</label>
          <input type="text" class="form-control" id="p_name" value="<?= $product['title'] ?>">
        </div>

        <!-- Product Description -->
        <div class="form-group">
          <label for="desc">Product Description:</label>
          <input type="text" class="form-control" id="p_desc" value="<?= $product['description'] ?>">
        </div>

        <!-- Unit Price -->
        <div class="form-group">
          <label for="price">Unit Price:</label>
          <input type="number" class="form-control" id="p_price" value="<?= $product['price'] ?>">
        </div>

        <!-- Product Image -->
        <div class="form-group">
          <img width='200px' height='150px' src='../<?= $product["image"] ?>'>
          <div>
            <label for="file">Choose Image:</label>
            <input type="text" id="existingImage" class="form-control" value="<?= $product['image'] ?>" hidden>
            <input type="file" id="newImage" value="">
          </div>
        </div>

        <!-- Update Button -->
        <div class="form-group">
          <button type="submit" style="height:40px" class="btn btn-primary">Update Item</button>
        </div>
        <!-- End of Form -->
      </form>
      <?php
    }
  }
  ?>
</div>
<!-- End of Container -->