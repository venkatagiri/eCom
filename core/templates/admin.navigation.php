<nav>
  <ul class="wrapper">
    <li>
      <a href="/admin/index">Dashboard</a>
    </li>
    <li class="category">
      <a>Catalog</a>
      <table class="sub_nav"><tr><td class="col">
        <a href="/admin/products">Products</a>
        <a href="/admin/categories">Categories</a>
        <a href="/admin/brands">Brands</a>
        <a href="/admin/attributes">Attributes</a>
      </td></tr></table>
    </li>
    <li>
      <a href="/admin/orders">Orders</a>
    </li>
    <li>
      <a href="/admin/customers">Customers</a>
    </li>
    <li class="category">
      <a>Extensions</a>
      <table class="sub_nav"><tr><td class="col">
        <a href="/admin/banners">Banners</a>
        <a href="/admin/featured">Featured</a>
      </td></tr></table>
    </li>
    <?php if(is_logged_in()) { ?>
    <li class="right">
      <a href="/admin/logout">Logout</a>
    </li>
    <?php } ?>
  </ul>
</nav>
