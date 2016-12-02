<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Assets{
	public $jsAssets,$cssAssets,$jsAliases,$cssAliases,$jsDisplayed,$cssDisplayed;
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
		}

		if(file_exists(APPPATH.'config/template_css.php')){
			include (APPPATH.'config/template_css.php');
			if(!empty($_cssAliases)){
				$this->cssAliases=array_merge($this->cssAliases,$_cssAliases);
			}
			if(!empty($_cssDefaults)){
				$this->css($_cssDefaults);
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
			    if($segments[1]=='i'){
					$module=$segments[2];
					$filePath=str_replace('asset/i/'.$module.'/','',$item);
				}elseif($segments[1]=='ie'){
					$module=$segments[2];
					$filePath=str_replace('asset/ie/'.$module.'/','',$item);
				}elseif($segments[1]=='e'){
					$module=$segments[2];
					$filePath=str_replace('asset/e/'.$module.'/','',$item);
				}else{
					$module=$segments[1];
					$filePath=str_replace('asset/'.$module.'/','',$item);
				}
				$filePath=explode('?',$filePath)[0];
				if(is_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets/'.$filePath),APPPATH.'modules/'.$module.'/assets')!==false){
					if(!isset($this->jsAssets[md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)])){
						$this->jsAssets[md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)]='/'.$item;
					}
				}
			}elseif(is_file(FCPATH.'js/'.$item)&&stripos(realpath(FCPATH.'js/'.$item),FCPATH)!==false){
				if(!isset($this->jsAssets[md5_file(FCPATH.'js/'.$item)])){
					$this->jsAssets[md5_file(FCPATH.'js/'.$item)]='/'.'js/'.$item;
				}
			}elseif(is_file(FCPATH.$item)&&stripos(realpath(FCPATH.$item),FCPATH)!==false){
				if(!isset($this->jsAssets[md5_file(FCPATH.$item)])){
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
	public function printJS(){
		if(!empty($this->jsAssets)){
			foreach($this->jsAssets as $key=>$value){
				if(!in_array($key,$this->jsDisplayed)){
				    $this->cssDisplayed[]=$key;
				    $segments=explode('/',$value);
				    if($segments[2]=='i'||$segments[2]=='ie'){
				        print "\t<script>\n".Modules::run('asset/contents',$value)."</script>\n";
				    }else{
					   	print "\t<script type=\"text/javascript\" src=\"".$value."\"></script>\n";
				    }
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
			    if($segments[1]=='i'){
					$module=$segments[2];
					$filePath=str_replace('asset/i/'.$module.'/','',$item);
				}elseif($segments[1]=='ie'){
					$module=$segments[2];
					$filePath=str_replace('asset/ie/'.$module.'/','',$item);
				}elseif($segments[1]=='e'){
					$module=$segments[2];
					$filePath=str_replace('asset/e/'.$module.'/','',$item);
				}else{
					$module=$segments[1];
					$filePath=str_replace('asset/'.$module.'/','',$item);
				}
				if(is_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)&&stripos(realpath(APPPATH.'modules/'.$module.'/assets/'.$filePath),APPPATH.'modules/'.$module.'/assets')!==false){
					if(!isset($this->cssAssets[md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)])){
					    if(preg_match('/\.less$/i',$item)){
					        /* $less=new Lessc();
					        $less->setImportDir(APPPATH.'modules/template/assets/css/');
					        $lesscss=$less->compileFile(APPPATH.'modules/'.$module.'/assets/'.$filePath);
					        write_file(preg_replace('/\.less$/i','.css',APPPATH.'modules/'.$module.'/assets/'.$filePath),$lesscss,'w+');*/
					        
					        $item=preg_replace('/\.less$/i','.css',$item); 
					       //echo 'lessc '.APPPATH.'modules/'.$module.'/assets/'.$filePath.' '.APPPATH.'modules/'.$module.'/assets/'.preg_replace('/\.less$/i','.css',$filePath);
					       if(stripos(APPPATH,'/www/ikeio')===0){
					           echo exec('lessc '.APPPATH.'modules/'.$module.'/assets/'.$filePath.' '.APPPATH.'modules/'.$module.'/assets/'.preg_replace('/\.less$/i','.css',$filePath).' 2>&1');
					       }
					    }
						$this->cssAssets[md5_file(APPPATH.'modules/'.$module.'/assets/'.$filePath)]='/'.$item;
					}
				}
			}elseif(is_file(FCPATH.'css/'.$item)&&stripos(realpath(FCPATH.'css/'.$item),FCPATH)!==false){
				if(!isset($this->cssAssets[md5_file(FCPATH.'css/'.$item)])){
					$this->cssAssets[md5_file(FCPATH.'css/'.$item)]='/'.'css/'.$item;
				}
			}elseif(is_file(FCPATH.$item)&&stripos(realpath(FCPATH.$item),FCPATH)!==false){
				if(!isset($this->cssAssets[md5_file(FCPATH.$item)])){
					$this->cssAssets[md5_file(FCPATH.$item)]='/'.$item;
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
	public function printCSS(){
		if(!empty($this->cssAssets)){
			foreach($this->cssAssets as $key=>$value){
				if(!in_array($key,$this->cssDisplayed)){
					$this->cssDisplayed[]=$key;
					$segments=explode('/',$value);
					if($segments[2]=='i'||$segments[2]=='ie'){
					    print "<style>".Modules::run('asset/contents',$value)."</style>";
					}else{
    					print "\t<link rel=\"stylesheet\" href=\"".$value."\" type=\"text/css\" />\n";
					}
				}
			}
		}
	}
}