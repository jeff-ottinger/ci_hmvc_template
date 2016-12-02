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
				$this->metaDefaults=array_merge($this->metaDefaults,$_metaDefaults);
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
	    $this->assets->css(array(
	        'datepicker',
			'summernote',
	        'asset/template/css/default.css',
	        'asset/template/css/fonts.css'
	    ));
	    $this->assets->js(array(
	        'bootbox',
	        'datepicker',
			'summernote',
	        'asset/e/template/js/default.js',
			'asset/template/js/expert.js'
	    ));
	    if ($this->ion_auth->logged_in()){
	        $user=$this->ion_auth->user()->row();
	        foreach($this->ion_auth->get_users_groups($user->id)->result_array() as $group){
	            $groups[]=$group['name'];
	        }
	        $this->user=array(
	            'id'=>$user->id,
	            'username'=>$user->username,
	            'email'=>$user->email,
	            'firstname'=>$user->first_name,
	            'lastname'=>$user->last_name,
	            'name'=>$user->first_name.' '.$user->last_name,
	            'groups'=>$groups
	        );
	    }
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
