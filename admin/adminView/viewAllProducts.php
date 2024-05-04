<!-- Start of Product Items -->
<div class="table-responsive">
  <h2>Product Items</h2>

  <!-- Start of Table -->
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">Product Image</th>
        <th class="text-center">Product Name</th>
        <th class="text-center">Price</th>
        <th class="text-center" colspan="2">Actions</th>
      </tr>
    </thead>

    <?php
    // Read the JSON file
    $json = file_get_contents('../../assets/json/items.json');

    // Decode the JSON file into an associative array
    $products = json_decode($json, true);

    // Loop through each product in the products array
    foreach ($products as $product) {
      ?>

      <!-- Start of Table Row -->
      <tr>
        <td><img height='100px' src='../<?= $product["image"] ?>'></td>
        <td><?= $product["title"] ?></td>
        <td><?= $product["price"] ?> SEK</td>
        <td><button class="btn btn-primary" style="height:40px"
            onclick="itemEditForm('<?= $product['id'] ?>')">Edit</button></td>
        <td><button class="btn btn-danger" style="height:40px"
            onclick="itemDelete('<?= $product['id'] ?>')">Delete</button>
        </td>
      </tr>
      <!-- End of Table Row -->

      <?php
    }
    ?>
  </table>
  <!-- End of Table -->

  <!-- Button to Trigger the Modal -->
  <button type="button" class="btn btn-secondary " style="height:40px" data-toggle="modal" data-target="#myModal">
    Add Product
  </button>

  <!-- Start of Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Start of Modal Content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Product Item</h4>
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
        <div class="modal-body">

          <!-- Start of Form -->
          <form enctype='multipart/form-data' onsubmit="addItems()" method="POST">
            <div class="form-group">
              <label for="name">Product Name:</label>
              <input type="text" class="form-control" id="p_name" required>
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" class="form-control" id="p_price" required>
            </div>
            <div class="form-group">
              <label for="desc">Description:</label>
              <input type="text" class="form-control" id="p_desc" required>
            </div>
            <div class="form-group">
              <label for="file">Choose Image:</label>
              <input type="file" class="form-control-file" id="file" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" id="upload" style="height:40px">Add Item</button>
            </div>
          </form>
          <!-- End of Form -->

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      <!-- End of Modal Content-->

    </div>
  </div>
  <!-- End of Modal -->

</div>
<!-- End of Product Items -->