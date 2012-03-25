<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_POST['save'])) {
    $order = Order::find_by_id($_POST['order_id']);
    $order->status = $_POST['status'];
    if($order->save()) {
      $session->message("Order was updated successfully!");
      redirect_to("show?id={$order->id}");
    } else {
      $message = "Order updation failed! Please try again after sometime!";
    }
  }

  if(isset($_GET['id']) && $_GET['id'] != "") {
    $order = Order::find_by_id($_GET['id']);
    if(!$order) {
      return show_404();
    }
  } else {
    return show_404();
  }
  
?>
<?php get_admin_header('Show | Orders'); ?>

<h1>Orders</h1>

<form method="post" enctype="multipart/form-data" name="form_order" class="form">
  <input type="hidden" name="order_id" value="<?php echo $order->id; ?>" />

  <table id="details">
    <tr>
      <th>Order No.</th><td>:</td>
      <td><?php echo $order->id; ?></td>
    </tr>
    <tr>
      <th>Products</th><td>:</td>
      <td>
        <?php foreach($order->products() as $product) { ?>
          <?php echo $product->name; ?> - Rs. <?php echo $product->price; ?>
        <?php } ?>
      </td>
    </tr>
    <tr>
      <th>Total Amount</th><td>:</td>
      <td>Rs. <?php echo $order->total_amount; ?></td>
    </tr>
    <tr>
      <th>Customer Name</th><td>:</td>
      <td><?php echo $order->customer_name; ?></td>
    </tr>
    <tr>
      <th>Shipping Address</th><td>:</td>
      <td>
        <?php echo nl2br($order->customer_address); ?>
      </td>
    </tr>
    <tr>
      <th>Status</th><td>:</td>
      <td>
        <select name="status">
        <?php foreach($ORDER_STATUS as $key => $value) { ?>
          <option value="<?php echo $key; ?>" <?php if($order->status == $key) echo 'selected' ?>><?php echo $value; ?></option>
        <?php } ?>
      </td>
    </tr>
  </table>
  <br />
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="save" value="Save" id="save" />
    <input type="button" name="back" value="Back to List" onclick="window.location='/admin/orders'" />
  </div>
</form>

<?php get_admin_footer(); ?>