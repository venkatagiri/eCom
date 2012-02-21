<?php

class Pagination {
  public $current_page;
  public $per_page;
  public $total_count;
  
  function __construct($current_page=1, $total_count=0, $per_page=12) {
    $this->current_page = (int)$current_page;
    $this->total_count = (int)$total_count;
    $this->per_page = (int)$per_page;
  }
  public function offset() {
    return $this->per_page * ($this->current_page - 1);
  }
  public function total_pages() {
    return ceil($this->total_count/$this->per_page);
  }
  public function previous_page() {
    return $this->current_page - 1;
  }
  public function next_page() {
    return $this->current_page + 1;
  }
  public function previous_exists() {
    return ($this->previous_page() >= 1) ? true : false;
  }
  public function next_exists() {
    return ($this->next_page() <= $this->total_pages()) ? true : false;
  }
}

?>
