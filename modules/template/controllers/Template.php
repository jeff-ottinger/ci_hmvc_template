<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template extends MX_Controller{

	public $metaDefaults;

	public function __construct(){
		parent::__construct();
		$this->metaDefaults=array();
		if(file_exists(APPPATH.'config/template_meta.php')){
			include(APPPATH.'config/template_meta.php');
			if(isset($_metaDefaults)){
				$this->metaDefaults=$_metaDefaults;
			}
		}
	}

	private function _metaFix(&$data){
		if(isset($data['page']['meta'])){
			$data['page']['meta']=array_merge($this->metaDefaults,$data['page']['meta']);
		}else{
			$data['page']['meta']=$this->metaDefaults;
		}
	}

	public function index($data,$template='default'){
		$template=preg_replace('/[^A-Za-z0-9\-\_]/i','',$template);
		$this->_metaFix($data);
		$this->load->view('htmlheader',$data);
		$this->load->view($template,$data);
		$this->load->view('htmlfooter',$data);
	}

	public function module($data){
		$this->load->view('module',$data);
	}

}
