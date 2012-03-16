<?php
  require_once("../../core/init.php");
  check_login();
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('page'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  
  list($pg, $brands) = Brand::find_with_pagination('1=1', $page, 10);
  
  if(empty($brands)) {
    $error = "No Brands to show";
  }

?>
<?php get_admin_header('Brands'); ?>

<h1>Brands<a href="new" class="new" title="Add a new Brand">+</a></h1>

<?php if(isset($error)) { ?>

<div class="error"><?php echo $error; ?></div>

<?php } else { ?>

<table class="table">
  <tr class="header">
    <th style="width:25%;">Name</th>
    <th style="width:30%;">Description</th>
    <th>Categories</th>
    <th style="width:5%;">Visible</th>
    <th style="width:5%;"></th>
  </tr>
  <?php foreach($brands as $brand): ?>
  <tr>
    <td><?php echo $brand->name; ?></td>
    <td><?php echo $brand->description; ?></td>
    <td><?php echo $brand->categories(); ?></td>
    <td style="text-align:center;"><input type="checkbox" disabled="disabled" <?php if($brand->visible == '1') echo "checked='checked'"; ?>/></td>
    <td><a href="show?id=<?php echo $brand->id; ?>">Edit</a></td>
  </tr>
  <?php endforeach; ?>
</table>

<div class="page_controls">
<?php
    if($pg->total_pages() > 1) {
      if($pg->previous_exists()) {
        echo "<a href='?page={$pg->previous_page()}' >&laquo; Previous</a>&nbsp;&nbsp;";
      }
      for($i=1; $i<=$pg->total_pages(); $i++) {
        if($i == $page) {
          echo "&nbsp;&nbsp;<strong>{$i}</strong>&nbsp;&nbsp;";
        } else {
          echo "&nbsp;&nbsp;<a href='?page={$i}'>{$i}</a>&nbsp;&nbsp;";
        }
      }
      if($pg->next_exists()) {
        echo "&nbsp;&nbsp;<a href='?page={$pg->next_page()}' >Next &raquo;</a>";
      }      
    }
?>
</div>

<?php } ?>

<?php get_admin_footer(); ?>