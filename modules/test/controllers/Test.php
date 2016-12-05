<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends MX_Controller{

	public $data;

	function __construct(){
		parent::__construct();
	}

	function index(){
		// Insert CSS <link> tags with the following hrefs
		$this->assets->css([
			'asset/test/css/default.css'
		]);
		// Insert the following CSS files inline within <style> tags
		$this->assets->cssinline([
			'asset/test/css/inline.css',
			'fontawesome' // using alias defined in config/template_css.php
		]);
		// Insert javascript <script> tags with the following sources
		$this->assets->js([
			'asset/test/js/default.js',
			'asset/test/js/duplicate.js', // won't show up because file matches default.js
			'jquery' // using an alias defined in config/template_js.php
		]);
		// Insert the following javascript files inline within <script> tags
		$this->assets->jsinline([
			'asset/test/js/inline.js'
		]);
		// set the page title
		$this->data['page']['title']="Test";
		// set the page view to be contained within template
		$this->data['view']='test/default';
		// Call the template module
		print Modules::run('template',$this->data);
	}
}
