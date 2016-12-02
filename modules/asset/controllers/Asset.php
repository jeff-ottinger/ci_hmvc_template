<?php defined('BASEPATH') or exit('No direct script access allowed');

class Asset extends MX_Controller{

	private $config;

	function __construct(){
		parent::__construct();
		$this->load->helper('file');
	}

	function fetch(){
		$seg=$this->uri->segment_array();
	    if($seg[2]=='i'){
			$module=$seg[3];
			$eval=false;
			$i=4;
		}elseif($seg[2]=='e'){
			$module=$seg[3];
			$eval=true;
			$i=4;
		}else{
			$module=$seg[2];
			$eval=false;
			$i=3;
		}
		$file_path="";
		for($i;$i<=count($seg);$i++){
			$file_path.="/".$seg[$i];
		}
		if(!empty($module)&&!empty($file_path)){
			if(file_exists(APPPATH.'modules/'.$module.'/assets'.$file_path)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets'.$file_path),APPPATH.'modules/'.$module.'/assets')!==false){
				$path=APPPATH.'modules/'.$module.'/assets'.$file_path;
			}else{
				show_404();
				exit();
			}
			if(filesize($path)){
				if(strtolower(substr(strrchr($path,'.'),1))=='svg'){
					$type='image/svg+xml';
				}else{
					$type=get_mime_by_extension($path);
				}
				header('Content-type: '.$type);
				header('Content-Length: '.filesize($path));
				if($eval){
					include($path);
				}else{
					readfile($path);
				}
				return;
			}
		}
		show_404();
	}
	
	function contents($data){
	    $seg=explode('/',$data);
	    if($seg[2]=='i'){
	        $module=$seg[3];
	        $eval=false;
	        $i=4;
	    }elseif($seg[2]=='e'){
	        $module=$seg[3];
	        $eval=true;
	        $i=4;
	    }elseif($seg[2]=='ie'){
	        $module=$seg[3];
	        $eval=true;
	        $i=4;
	    }else{
	        $module=$seg[2];
	        $eval=false;
	        $i=3;
	    }
	    $file_path="";
	    for($i;$i<count($seg);$i++){
	        $file_path.="/".$seg[$i];
	    }
	    if(!empty($module)&&!empty($file_path)){
	        if(file_exists(APPPATH.'modules/'.$module.'/assets'.$file_path)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets'.$file_path),APPPATH.'modules/'.$module.'/assets')!==false){
	            $path=APPPATH.'modules/'.$module.'/assets'.$file_path;
	        }else{
	            show_404();
	            exit();
	        }
	        if(filesize($path)){
	            if($eval){
	                include($path);
	            }else{
	                readfile($path);
	            }
	            return;
	        }
	    }
	    show_404();
	}

}