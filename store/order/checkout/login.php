<?php 
  require_once("../../../core/init.php");

  if(!$session->get('order_id')) redirect_to('/'); // Invalid Request

  $order = Order::find_by_id($session->get('order_id'));

  if(!$order) redirect_to('/'); // Invalid Request! LOG HERE

  // If the customer is already logged, associate the order to the customer and redirect to address.
  if($session->is_customer_logged_in()) {
    $customer = $session->get_customer();
    $order->customer_id = $customer->id;
    if($order->save()) {
      redirect_to("address");
    } else {
      die('order save failed!'); // TODO: Delete order and corresponding tables & log here!
    }
  }

  if(isset($_POST['continue'])) {
    if(!isset($_POST['have-password'])) {
      $message = "Please select one of the options below email!";
    } else if($_POST['have-password'] == '1') {
      $email = __($_POST['email']);
      $password = __($_POST['password']); // TODO: Hashing(bcrypt)

      $customer = Customer::find_one("email = '{$email}' AND password = '{$password}'");

      if(!$customer) {
        $message = 'Invalid Email/Password. Try again!';
      } else {
        $order->customer_id = $customer->id;
        if($order->save()) {
          $session->login($customer->email);
          redirect_to("address");
        } else {
          die('order save failed!'); // TODO: Delete order and corresponding tables & log here!
        }
      }
    } else if($_POST['have-password'] == '0') {
      $email = __($_POST['email']);
      $new_password = __($_POST['new-password']); // TODO: Hashing(bcrypt)
      $confirm_password = __($_POST['confirm-password']);

      if(Customer::email_exists($email)) {
        $message = "Email already exists!";
      } else if($new_password != $confirm_password) {
        $message = "Passwords don't match!";
      } else {
        $customer = new Customer();
        $customer->email = $email;
        $customer->password = $new_password;
        if($customer->save()) {
          $order->customer_id = $customer->id;
          if($order->save()) {
            $session->login($customer->email);
            redirect_to("address");
          } else {
            die('order save failed!'); // TODO: Delete order and corresponding tables & log here!
          }
        } else {
          $message = 'Customer creation failed! please try again!';
        }
      }
    }
  }

  if(isset($_GET['email'])) $email = $_GET['email'];

?>
<?php get_store_meta('Login | Checkout | Shopping Cart'); ?>

<body>
<header><div class="wrapper">
  <h1><?php echo STORE_NAME; ?></h1>
</div></header>

<div class="content wrapper shopping-cart-page">

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>

<aside>
  <div class="box">
    <h6 class="header">Order Summary</h6>
    <div class="container" style="padding:10px">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
      <tbody>
        <tr >
          <td width="50%" valign="top" align="left" class="stronge">Items</td>
          <td valign="top" align="left">: <?php echo $order->no_of_products; ?></td>
        </tr>
        <tr>
          <td width="50%" valign="top" align="left" class="stronge">Grand Total</td>
          <td valign="top" align="left">: Rs. <?php echo $order->total_amount; ?></td>
      </tbody>
    </table>
    </div>
  </div>
</aside>

<section role="main" id="main">
<h1>1. Login</h1>

<form method="post" name="login_form" class="form">
  <div class="entry" style="margin:10px 0 20px 0;">
    <label style="font-size:110%;">Your email address</label>
    <input type="text" name="email" value="<?php echo @$email; ?>"/><br />
  </div>

  <div style="font-size:110%">Do you have an account with <?php echo STORE_NAME; ?>?</div>

  <div class="entry" style="background: #F4F4F4;padding:5px 10px;">
    <table><tr>
      <td>
        <input type="radio" name="have-password" onclick="$('#have-password').hide(); $('#dont-have-password').show(); " style="margin-right:10px;" value="0"/>
      </td>
      <td>No, I am a new customer.<br />
      <span class="small">(Enter a new password. An account will be created for future use with the store)</span></td>
    </tr></table>
    <div class="entry" id="dont-have-password" style="display:none;margin-top:10px;">
      <label style="font-size:110%;">New Password</label>
      <input type="password" name="new-password" style="margin:0 0 5px 10px;" /><br />
      <label style="font-size:110%;">Confirm Password</label>
      <input type="password" name="confirm-password" style="margin:0 10px;" />
    </div>
  </div>

  <div class="entry" style="background: #F4F4F4;padding:5px 10px;">
    <table><tr>
      <td>
        <input type="radio" name="have-password" onclick="$('#have-password').show(); $('#dont-have-password').hide(); " style="margin-right:10px;" value="1"/>
      </td>
      <td>Yes, I have an account & password.<br />
      <span class="small">(Sign into your existing account for faster checkout)</span></td>
    </tr></table>
    <div class="entry" id="have-password" style="display:none;margin-top:10px;">
      <label style="font-size:110%;min-width:0;">Password</label>
      <input type="password" name="password" style="margin:0 10px;" />
      <a href="/account/forgot_password">Forgot Password?</a>
    </div>
  </div>

  <div clas="entry">
    <input type="image" name="continue" value="Continue" src="/img/continue.png" />
  </div>
</form>

</section>

<?php get_store_footer(); ?>