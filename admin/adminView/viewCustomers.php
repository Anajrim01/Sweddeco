<!-- Start of All Customers -->
<div class="table-responsive">
  <h2>All Customers</h2>

  <!-- Start of Table -->
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">Name</th>
        <th class="text-center">Email</th>
        <th class="text-center">Contact Number</th>
        <th class="text-center">Address</th>
        <th class="text-center">Joining Date</th>
      </tr>
    </thead>

    <?php
    // Include the database connection file
    include_once "../config/dbconnect.php";

    // SQL query to select all non-admin users
    $sql = "SELECT * FROM users WHERE isAdmin = 0";

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
      // Loop through each row in the result
      while ($row = $result->fetch_assoc()) {
        ?>

        <!-- Start of Table Row -->
        <tr>
          <td><?= $row["first_name"] ?>     <?= $row["last_name"] ?></td>
          <td><?= $row["email"] ?></td>
          <td><?= $row["contact_no"] ?></td>
          <td><?= $row["user_address"] ?></td>
          <td><?= $row["registered_at"] ?></td>
        </tr>
        <!-- End of Table Row -->

        <?php
      }
    }
    ?>
  </table>
  <!-- End of Table -->

</div>
<!-- End of All Customers -->