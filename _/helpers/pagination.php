<?php

class Pagination {
   public $currentPage;
   public $perPage;
   public $totalCount;
   
   function __construct($page=1, $perPage=5, $totalCount=0) {
      $this->currentPage = (int)$page;
      $this->perPage = (int)$perPage;
      $this->totalCount = (int)$totalCount;
   }
   public function offset() {
      return $this->perPage * ($this->currentPage - 1);
   }
   public function totalPages() {
      return ceil($this->totalCount/$this->perPage);
   }
   public function prevPage() {
      return $this->currentPage - 1;
   }
   public function nextPage() {
      return $this->currentPage + 1;
   }
   public function prevExists() {
      return ($this->prevPage() >= 1) ? true : false;
   }
   public function nextExists() {
      return ($this->nextPage() <= $this->totalPages()) ? true : false;
   }
}
?>