<!-- Start of Orders Button -->
<div id="ordersBtn" class="table-responsive">
  <h2>Order Details</h2>

  <!-- Start of Table -->
  <table class="table table-striped">
    <thead>
      <tr>
        <th>O.N.</th>
        <th>Customer</th>
        <th>Contact</th>
        <th>Order Date</th>
        <th>Payment Method</th>
        <th>Notes</th>
        <th>Order Status</th>
        <th>Payment Status</th>
        <th>More Details</th>
      </tr>
    </thead>

    <?php
    // Include database connection
    include_once "../config/dbconnect.php";

    // SQL query to select all orders
    $sql = "SELECT * from orders";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any rows in the result
    if ($result->num_rows > 0) {
      // Fetch each row from the result
      while ($row = $result->fetch_assoc()) {
        ?>

        <!-- Start of Table Row -->
        <tr>
          <td><?= $row["order_id"] ?></td>
          <td><?= $row["customer"] ?></td>
          <td><?= $row["phone_no"] ?></td>
          <td><?= $row["order_date"] ?></td>
          <td><?= $row["pay_method"] ?></td>
          <td><?= $row["order_notes"] ?></td>

          <!-- Order Status -->
          <?php
          if ($row["order_status"] == 0) {
            ?>
            <td><button class="btn btn-danger" onclick="ChangeOrderStatus('<?= $row['order_id'] ?>')">Pending </button></td>
            <?php
          } else {
            ?>
            <td><button class="btn btn-success" onclick="ChangeOrderStatus('<?= $row['order_id'] ?>')">Delivered</button></td>
            <?php
          }

          // Payment Status
          if ($row["pay_status"] == 0) {
            ?>
            <td><button class="btn btn-danger" onclick="ChangePay('<?= $row['order_id'] ?>')">Unpaid</button></td>
            <?php
          } else if ($row["pay_status"] == 1) {
            ?>
              <td><button class="btn btn-success" onclick="ChangePay('<?= $row['order_id'] ?>')">Paid </button></td>
            <?php
          }
          ?>

          <!-- More Details -->
          <td><a class="btn btn-primary openPopup" data-href="./adminView/viewEachOrder.php?orderID=<?= $row['order_id'] ?>"
              href="javascript:void(0);">View</a></td>
        </tr>
        <!-- End of Table Row -->
        <?php
      }
    }
    ?>

  </table>
  <!-- End of Table -->

</div>
<!-- End of Orders Button -->

<!-- Start of Modal -->
<div class="modal fade" id="viewModal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Start of Modal Content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Order Details</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="order-view-modal modal-body">

      </div>
    </div>
    <!-- End of Modal Content-->

  </div>
</div>
<!-- End of Modal -->

<!-- Start of Script -->
<script>
  // Function to open the order view modal  
  $(document).ready(function () {
    $('.openPopup').on('click', function () {
      var dataURL = $(this).attr('data-href');

      $('.order-view-modal').load(dataURL, function () {
        $('#viewModal').modal({ show: true });
      });
    });
  });
</script>
<!-- End of Script -->