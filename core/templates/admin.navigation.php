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
    <li class="category">
      <a>Sales</a>
      <table class="sub_nav"><tr><td class="col">
        <a href="/admin/orders">Orders</a>
        <a href="/admin/customers">Customers</a>
      </td></tr></table>
    </li>
    <li class="category">
      <a>Extensions</a>
      <table class="sub_nav"><tr><td class="col">
        <a href="/admin/banners">Banners</a>
      </td></tr></table>
    </li>
    <li class="right">
      <form method="GET" action="/admin/search">
        <input type="text" name="q" id="search_box" value="" size="25" placeholder="Search and you will find it..." />
      </form>
    </li>
  </ul>
</nav>