<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

class TmpFile {
	var $handler;
	var $size;
	
	function __construct() {
		$this->handler = tmpfile();
	}
	
	function write($contents) {
		$this->size += strlen($contents);
		fwrite($this->handler, $contents);
	}
	
	function send() {
		fseek($this->handler, 0);
		fpassthru($this->handler);
		fclose($this->handler);
	}
	
}
