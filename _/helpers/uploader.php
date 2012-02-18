<?php

class Uploader {
  protected $upload_errors = array(
    UPLOAD_ERR_OK           => "No errors.",
    UPLOAD_ERR_INI_SIZE     => "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL      => "Partial upload.",
    UPLOAD_ERR_NO_FILE      => "No file.",
    UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
	);
	private $file;
	private $target_path;
	public $errors;
	public $file_name;
	
  function __construct($file = false, $target_path = false) {
    $this->file = $file;
    $this->target_path = $target_path;
    $this->errors = array();
  }
  
  public function is_uploaded() {
    if(!$this->file || empty($this->file) || !is_array($this->file)
        || !$this->target_path || empty($this->target_path)) {
      $this->errors[] = "No file was uploaded.";
      return false;
    }
    if ($this->file['error'] != 0) {
      $this->errors[] = $this->upload_errors[$this->file['error']];
      return false;
    }
    $exts = explode("/", $this->file['type']);
    $extension = $exts[1];
    
    $this->file_name = random_string(6).'.'.$extension;
    if(move_uploaded_file(
        $this->file['tmp_name'], 
        $this->target_path."/".$this->file_name)) {
      unset($this->file['tmp_name']);
      return true;
    }
    
    return false;
  }

}

?>
