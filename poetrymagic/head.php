<?
include_once 'basicMagic.php';

class Head extends BasicWebElement
{
	public function __construct($stuff_to_add){
		$this->prepend("<!doctype html><html><head>");
		$this->append($stuff_to_add);
		$this->addTitle();
	}
	protected function addTitle(){
		global $the_websiteTitle, $the_websiteTitleSeparator, $the_pageName;
		$this->append("<title>$the_websiteTitle $the_websiteTitleSeparator $the_pageName</title>");
	}
	public function addStyleSheet($name){
		$this->append("<link rel='stylesheet' type='text/css' href='{$name}'/>");
	}
	public function addLess($name){
		global $the_basePath, $the_pathToCSS, $the_pathToJS;
		$this->append("<link rel='stylesheet/less' type='text/css' href='{$the_basePath}{$the_pathToCSS}{$name}' />");
		$this->append("
			<script type='text/javascript'>
				less = {
					env: 'development', // or 'production'
					async: false,       // load imports async
					fileAsync: false,   // load imports async when in a page under a file protocol
					poll: 1000,         // when in watch mode, time in ms between polls
					functions: {},      // user functions, keyed by name
					dumpLineNumbers: 'comments', // or 'mediaQuery' or 'all'
				};</script>
			<script src='{$the_pathToJS}less.js' type='text/javascript'></script>");
	}
	public function addHighSlide(){
		$this->append("
		<script type='text/javascript' src='../js/highslide/highslide/highslide.js'></script>
		<link rel='stylesheet' type='text/css' href='../css/highslide.css'/>
		<script type='text/javascript'> <!-- Highslide.js CONTROLS-->
			hs.graphicsDir = '/liv/';
			hs.outlineType = null;
		</script>");
	}
	protected function beforeDisplay(){
		$this->append("</head>");
	}
}

?>
