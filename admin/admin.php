<?php
  require_once "../connect.php";

  # Authentication


  # Change order status
  if( isset( $_POST['order_status'] ) ){
    extract($_POST);
    $stmt = $pdo->prepare("UPDATE `orders` SET `status` = :order_status WHERE `id` = :order_id");
    $stmt->bindValue(':order_status', $order_status);
    $stmt->bindValue(':order_id', $order_id);
    $stmt->execute();
  }

  function getInventory() {
    global $pdo;
    $query = "SELECT * FROM inventory";
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

$inventory = getInventory();
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ICp</title>

  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<style>
  .tablerow {
  counter-reset: rowNumber;
}

.tablerow tr::before {
  display: table-cell;
  counter-increment: rowNumber;
  content: counter(rowNumber) ".";
  padding-right: 0.3em;
  text-align: center;
  font-weight: 1000;
}
</style>
<body>

  <?php if( isset($_SESSION['alert']) ){ ?>
  <div id="custom-alert" class="floating-notif" >
    <span class="fas fa-check" style="margin-right: 0.5rem;" ></span>
    <span>Order status changed</span>
  </div>
  <script type="text/javascript">
    setTimeout(() => {
      $("#custom-alert").fadeIn();
      setTimeout(() => {
        $("#custom-alert").fadeOut();
      }, 3000);
    }, 1000);
  </script>
  <?php } unset($_SESSION['alert']); ?>


  
  <div class="container" style="margin-top: 1rem;" >
  <h1>ORDERS</h1>
    <table class="table table-striped" >
      <thead>
        <tr>
        <th>NO.</th>
          <th>Order</th>
          <th>Customer</th>
          <th>Ordered</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="tablerow">
        <?php
          $sql = "SELECT *, orders.id AS 'order_id'
              FROM `orders`
              INNER JOIN `login`
              ON login.id = orders.customer_id
              ORDER BY orders.date_added ASC";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach($orders as $row){
        ?>

        <tr>
            <td>
              <code><?php echo $row['group_order']; ?></code>
              <div><?php echo $row['product_name']; ?></div>
            </td>
            <td>
              <strong><?php echo $row['order_username']; ?></strong>
              <div>Mobile: <?php echo $row['order_phonenumber']; ?></div>
              <div>Address: <?php echo $row['order_address']; ?></div>
            </td>
            <td>
              <?php echo date('M d, Y g:ia', strtotime($row['date_added'])); ?>
            </td>
            <td>
              <form action="index.php" method="POST" >
                <input type="hidden" name="order_status"  value="0" />
                <input type="hidden" name="order_id"  value="<?php echo $row['order_id']; ?>" />
                <button style="opacity: <?php echo ($row['status'] != 0) ? ".5" : "1"; ?>;" class="btn form-control btn-primary" >Queued</button>
              </form>
              <form action="index.php" method="POST" >
                <input type="hidden" name="order_status"  value="1" />
                <input type="hidden" name="order_id"  value="<?php echo $row['order_id']; ?>" />
                <button style="opacity: <?php echo ($row['status'] != 1) ? ".5" : "1"; ?>;" class="btn form-control btn-info" >OFD</button>
              </form>
              <form action="index.php" method="POST" >
                <input type="hidden" name="order_status"  value="2" />
                <input type="hidden" name="order_id"  value="<?php echo $row['order_id']; ?>" />
                <button style="opacity: <?php echo ($row['status'] != 2) ? ".5" : "1"; ?>;" class="btn form-control btn-success" >Delivered</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

<!-- ____________________________________________________________________________ -->
<br><br>
<h1>INVENTORY</h1>
<table class="table table-striped" >
      <thead>
        <tr>
        <th>NO.</th>
        <th>ID</th>
        <th>Image</th>
        <th>Product Name</th>
        <th>Stock</th>
        <th>Description</th>
        <th>Dimension</th>
        <th>Price</th>
        <th>Action</th>
        </tr>
      </thead>
      <tbody class="tablerow">
      <?php foreach ($inventory as $item) { ?>
            <tr>
                <td><?php echo $item['product_id']; ?></td>
                <td><img src="image/<?php echo $item['product_image']; ?>" alt= " " style="width: 3rem; height: 3rem; border-radius: 5px;"<?php echo $item['product_name']; ?>></td>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['product_stock']; ?></td>
                <td><?php echo $item['product_description']; ?></td>
                <td><?php echo $item['product_dimension']; ?></td>
                <td>₱<?php echo number_format($item['product_price'], 2); ?></td>               
                <!-- <td>
                    <a href="admin_update.php?id=<?php echo $item['product_id']; ?>">Edit</a>
                    <a href="admin_delete.php?id=<?php echo $item['product_id']; ?>">Delete</a>
                </td> -->
                <td>
              <form action="index.php" method="POST" >
                <input type="hidden" name="order_status"  value="0" />
                <input type="hidden" name="order_id"  value="<?php echo $row['order_id']; ?>" />
                <button style="opacity: <?php echo ($row['status'] != 0) ? ".5" : "1"; ?>;" class="btn form-control btn-success" >Edit</button>
              </form>
              <form action="index.php" method="POST" >
                <input type="hidden" name="order_status"  value="1" />
                <input type="hidden" name="order_id"  value="<?php echo $row['order_id']; ?>" />
                <button style=" <?php echo ($row['status'] != 1) ? ".5" : "1"; ?>;" class="btn form-control btn-danger" >Delete</button>
              </form>
            </td>
            </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>