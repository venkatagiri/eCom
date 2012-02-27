<?php
  require_once("../../core/init.php");
  check_login();
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('page'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  
  list($pg, $banners) = Banner::find_with_pagination('1=1', $page, 10);
  
  if(empty($banners)) {
    $error = "No Banners to show";
  }
?>
<?php get_admin_header('Banners'); ?>

<h1>Banners<a href="new" class="new" title="Add a new Banner">+</a></h1>

<?php if(isset($error)) { ?>

<div class="error"><?php echo $error; ?></div>

<?php } else {?>

<table class="table">
  <tr class="header">
    <th>Name</th>
    <th style="width:15%;">Type</th>
    <th style="width:5%;">Width</th>
    <th style="width:5%;">Height</th>
    <th style="width:40%;">Link</th>
    <th style="width:5%;">Visible</th>
    <th style="width:5%;"></th>
  </tr>
  <?php foreach($banners as $banner): ?>
  <tr>
    <td><?php echo $banner->name; ?></td>
    <td><?php echo $BANNER_TYPES[$banner->type]; ?></td>
    <td><?php echo $banner->width; ?>px</td>
    <td><?php echo $banner->height; ?>px</td>
    <td><?php echo $banner->link; ?></td>
    <td style="text-align:center;"><input type="checkbox" disabled="disabled" <?php if($banner->visible == '1') echo " checked='checked' "; ?>/></td>
    <td><a href="show?id=<?php echo $banner->id; ?>">Edit</a></td>
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
