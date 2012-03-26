<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_GET['id']) && $_GET['id'] != "") {
    $customer = Customer::find_by_id($_GET['id']);
    if(!$customer) {
      return show_404();
    }
  } else {
    return show_404();
  }
  
?>
<?php get_admin_header('Show | Customers'); ?>

<h1>Customers</h1>

<form method="post" enctype="multipart/form-data" name="form_customer" class="form">
  <table class="details">
    <tr>
      <th>E-mail</th><td>:</td>
      <td><?php echo $customer->email; ?></td>
    </tr>
    <tr>
      <th>First Name</th><td>:</td>
      <td><?php echo $customer->first_name; ?></td>
    </tr>
    <tr>
      <th>Last Name</th><td>:</td>
      <td><?php echo $customer->last_name; ?></td>
    </tr>
    <tr>
      <th>Address</th><td>:</td>
      <td><?php echo $customer->address_1 . "<br />" . $customer->address_2; ?></td>
    </tr>
    <tr>
      <th>City</th><td>:</td>
      <td><?php echo $customer->city; ?></td>
    </tr>
    <tr>
      <th>Pincode</th><td>:</td>
      <td><?php echo $customer->pincode; ?></td>
    </tr>
    <tr>
      <th>State</th><td>:</td>
      <td><?php echo $customer->state; ?></td>
    </tr>
    <tr>
      <th>Telephone</th><td>:</td>
      <td><?php echo $customer->telephone; ?></td>
    </tr>
  </table>
  <!--
  <br />
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="save" value="Save" id="save" />
    <input type="button" name="back" value="Back to List" onclick="window.location='/admin/customers'" />
  </div>
-->
</form>

<?php get_admin_footer(); ?>