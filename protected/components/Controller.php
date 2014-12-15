<?php
/**
 * - Master controller class
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

	public $layout='//layouts/main';
	public $menu=array();
	public $breadcrumbs=array();
	
	public function replace_tr($text) {
		$text = trim($text);
		$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ',"'",'!','?',',',';',':');
		$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-','','','','','','');
		$new_text = strtolower(str_replace($search,$replace,$text));
		return $new_text;
	}

	public function objectToArray($d) {
 		if (is_object($d)) {
			$d = get_object_vars($d);
		}
 		if (is_array($d)) {
 			return array_map(array($this, 'objectToArray'), $d);
		} else {
 			return $d;
 		}
 	}

 	function cleaner($string) {
   		$string = str_replace(' ', '-', $string);
   		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}

}