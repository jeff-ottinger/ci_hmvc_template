<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Assets{
	public $jsAssets,$cssAssets,$jsiAssets,$cssiAssets,$jsAliases,$cssAliases,$jsDisplayed,$cssDisplayed;
	public function __construct(){
		$this->jsDisplayed=array();
		$this->cssDisplayed=array();
		$this->jsAliases=array();
		$this->cssAliases=array();
		if(file_exists(APPPATH.'config/template_js.php')){
			include (APPPATH.'config/template_js.php');
			if(!empty($_jsAliases)){
				$this->jsAliases=array_merge($this->jsAliases,$_jsAliases);
			}
			if(!empty($_jsDefaults)){
				$this->js($_jsDefaults);
			}
			if(!empty($_jsiDefaults)){
				$this->js($_jsiDefaults);
			}
		}

		if(file_exists(APPPATH.'config/template_css.php')){
			include (APPPATH.'config/template_css.php');
			if(!empty($_cssAliases)){
				$this->cssAliases=array_merge($this->cssAliases,$_cssAliases);
			}
			if(!empty($_cssDefaults)){
				$this->css($_cssDefaults);
			}
			if(!empty($_cssiDefaults)){
				$this->css($_cssiDefaults);
			}
		}
	}
	public function js($asset=NULL){
		if(is_string($asset)){
			$asset=array($asset);
		}
		foreach($asset as $item){
			if(stripos($item,'asset/')===0){
				$segments=explode('/',$item);
			    $module=$segments[1];
				$filePath=str_replace('asset/'.$module.'/','',$item);
				$filePath=explode('?',$filePath)[0];
				if(is_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets/'.$filePath),APPPATH.'modules/'.$module.'/assets')!==false){
					$key=md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath);
					if(!isset($this->jsAssets[$key])){
						$this->jsAssets[$key]='/'.$item;
					}
				}
			}elseif(is_file(FCPATH.$item)&&stripos(realpath(FCPATH.$item),FCPATH)!==false){
				$key=md5_file(FCPATH.$item);
				if(!isset($this->jsAssets[$key])){
					$this->jsAssets[md5_file(FCPATH.$item)]='/'.$item;
				}
			}elseif(isset($this->jsAliases[$item])){
				$items=$this->jsAliases[$item];
				if(!is_array($items)){
					$items=array($items);
				}
				$this->js($items);
			}elseif(strtolower(substr($item,0,4))=='http'){
				$this->jsAssets[md5($item)]=$item;
			}
		}
	}
	public function jsinline($asset=NULL){
		if(is_string($asset)){
			$asset=array($asset);
		}
		foreach($asset as $item){
			if(stripos($item,'asset/')===0){
				$segments=explode('/',$item);
			    $module=$segments[1];
				$filePath=str_replace('asset/'.$module.'/','',$item);
				$filePath=explode('?',$filePath)[0];
				if(is_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets/'.$filePath),APPPATH.'modules/'.$module.'/assets')!==false){
					$key=md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath);
					if(!isset($this->jsiAssets[$key])){
						$this->jsiAssets[$key]=APPPATH.'modules/'.$module.'/assets/'.$filePath;
					}
				}
			}elseif(is_file(FCPATH.$item)&&stripos(realpath(FCPATH.$item),FCPATH)!==false){
				$key=md5_file(FCPATH.$item);
				if(!isset($this->jsiAssets[$key])){
					$this->jsiAssets[md5_file(FCPATH.$item)]=FCPATH.$item;
				}
			}elseif(isset($this->jsAliases[$item])){
				$items=$this->jsAliases[$item];
				if(!is_array($items)){
					$items=array($items);
				}
				$this->js($items);
			}elseif(strtolower(substr($item,0,4))=='http'){
				$this->jsiAssets[md5($item)]=$item;
			}
		}
	}
	public function printJS(){
		if(!empty($this->jsAssets)){
			foreach($this->jsAssets as $key=>$value){
				if(!in_array($key,$this->jsDisplayed)){
				    $this->jsDisplayed[]=$key;
				    print "\t<script type=\"text/javascript\" src=\"".$value."\"></script>\n";
				}
			}
		}
	}
	public function printJSInline(){
		if(!empty($this->jsiAssets)){
			foreach($this->jsiAssets as $key=>$value){
				if(!in_array($key,$this->jsDisplayed)){
				    $this->jsDisplayed[]=$key;
				    print "<script>\n".file_get_contents($value)."\n</script>\n";
				}
			}
		}
	}
	public function css($asset=NULL){
		if(is_string($asset)){
			$asset=array($asset);
		}
		foreach($asset as $item){
			if(stripos($item,'asset/')===0){
				$segments=explode('/',$item);
			    $module=$segments[1];
				$filePath=str_replace('asset/'.$module.'/','',$item);
				if(is_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets/'.$filePath),APPPATH.'modules/'.$module.'/assets')!==false){
					$key=md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath);
					if(!isset($this->cssAssets[$key])){
						$this->cssAssets[$key]='/'.$item;
					}
				}
			}elseif(is_file(FCPATH.$item)&&stripos(realpath(FCPATH.$item),FCPATH)!==false){
				$key=md5_file(FCPATH.$item);
				if(!isset($this->cssAssets[$key])){
					$this->cssAssets[$key]='/'.$item;
				}
			}elseif(isset($this->cssAliases[$item])){
				$items=$this->cssAliases[$item];
				if(!is_array($items)){
					$items=array($items);
				}
				$this->css($items);
			}elseif(strtolower(substr($item,0,4))=='http'){
				$this->cssAssets[md5($item)]=$item;
			}
		}
	}
	public function cssinline($asset=NULL){
		if(is_string($asset)){
			$asset=array($asset);
		}
		foreach($asset as $item){
			if(stripos($item,'asset/')===0){
				$segments=explode('/',$item);
				$module=$segments[1];
				$filePath=str_replace('asset/'.$module.'/','',$item);
				if(is_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets/'.$filePath),APPPATH.'modules/'.$module.'/assets')!==false){
					$key=md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath);
					if(!isset($this->cssiAssets[$key])){
						$this->cssiAssets[$key]=APPPATH.'modules/'.$module.'/assets/'.$filePath;
					}
				}
			}elseif(is_file(FCPATH.$item)&&stripos(realpath(FCPATH.$item),FCPATH)!==false){
				$key=md5_file(FCPATH.$item);
				if(!isset($this->cssiAssets[$key])){
					$this->cssiAssets[$key]=FCPATH.$item;
				}
			}elseif(isset($this->cssAliases[$item])){
				$items=$this->cssAliases[$item];
				if(!is_array($items)){
					$items=array($items);
				}
				$this->cssinline($items);
			}elseif(strtolower(substr($item,0,4))=='http'){
				$this->cssiAssets[md5($item)]=$item;
			}
		}
	}
	public function printCSS(){
		if(!empty($this->cssAssets)){
			foreach($this->cssAssets as $key=>$value){
				if(!in_array($key,$this->cssDisplayed)){
					$this->cssDisplayed[]=$key;
					print "\t<link rel=\"stylesheet\" href=\"".$value."\" type=\"text/css\" />\n";
				}
			}
		}
	}
	public function printCSSInline(){
		if(!empty($this->cssiAssets)){
			foreach($this->cssiAssets as $key=>$value){
				if(!in_array($key,$this->cssDisplayed)){
					$this->cssDisplayed[]=$key;
					print "<style>\n".file_get_contents($value)."\n</style>\n";
				}
			}
		}
	}
}
