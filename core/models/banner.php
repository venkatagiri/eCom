<?php

class Banner extends Base {
  static protected $table_name = "banners";
  static protected $db_fields = array('id', 'name', 'type', 'category_id', 
        'image', 'link', 'width', 'height', 'visible',
        'date_created', 'date_modified');
  public $id;
  public $name;
  public $type;
  public $category_id;
  public $image;
  public $link;
  public $width;
  public $height;
  public $visible;
  public $date_created;
  public $date_modified;
  
  static public function make($b) {
    $banner = new Banner();
    if(isset($b['id'])) $banner->id = $b['id'];
    $banner->name = $b['name'];
    $banner->type = $b['type'];
    $banner->category_id = $b['category_id'];
    $banner->image = @$b['image'];
    $banner->link = $b['link'];
    $banner->width = $b['width'];
    $banner->height = $b['height'];
    $banner->visible = $b['visible'] == '1' ? 1 : 0;
    return $banner;
  }
  
  public function category() {
    return Category::find_by_id($this->category_id);
  }
}

?>
