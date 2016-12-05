<?php defined('BASEPATH') or exit('No direct script access allowed');

class Asset extends MX_Controller{

	private $config;

	function __construct(){
		parent::__construct();
		$this->load->helper('file');
	}

	function fetch(){
		$seg=$this->uri->segment_array();
	    $module=$seg[2];
		$file_path="";
		for($i=3;$i<=count($seg);$i++){
			$file_path.="/".$seg[$i];
		}
		if(!empty($module)&&!empty($file_path)){
			if(file_exists(APPPATH.'modules/'.$module.'/assets'.$file_path)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets'.$file_path),APPPATH.'modules/'.$module.'/assets')!==false){
				$path=APPPATH.'modules/'.$module.'/assets'.$file_path;
				if(filesize($path)){
					if(strtolower(substr(strrchr($path,'.'),1))=='svg'){
						$type='image/svg+xml';
					}else{
						$type=get_mime_by_extension($path);
					}
					header('Content-type: '.$type);
					header('Content-Length: '.filesize($path));
					readfile($path);
					return;
				}
			}
		}
		show_404();
	}

}
