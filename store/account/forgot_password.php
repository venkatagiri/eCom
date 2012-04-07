<?php 
  require_once("../../core/init.php");
  if($session->is_logged_in()) { redirect_to('/'); }

  if(isset($_POST['send'])) {
    $email = __($_POST['email']);

    if(Customer::email_exists($email)) {
      $customer = Customer::find_by_email($email);
      // TODO: Reset password and send email!
      $success = "An email is sent to {$email} with the new password!";
    } else {
      $message = "Invalid Email Address!";
    }
  }

?>
<?php get_store_header('Account'); ?>

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>

<section role="main" id="main" class="only-section">

  <h1>Forgot Password</h1>
  <?php if($success != "") { ?>
    <p class="success"><?php echo $success; ?></p>
  <?php } else { ?>

  <form method="post" name="forgot_form" class="form">
    <div class="entry">
      <label for="email">Email Address</label>
      <input type="text" name="email" value="<?=@$email?>" />
    </div>
    <div clas="entry">
      <label for="submit"> </label>
      <input type="submit" name="send" value="Send" />
    </div>
  </form>

  <?php } ?>

</section>

<?php get_store_footer(); ?>