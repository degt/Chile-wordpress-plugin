<?php 
 /*
Plugin Name: Chile regiones
Plugin URI: http://www.degt.cl
Description: Regiones, Provincias y comunas de Chile
Version: 0.1.1
Author: Daniel Gutierrez
Author URI: http://degt.cl
*/

//var $chile as global
$chile = new Chile;

require("xml2array.php");
require("chile.ajax.php");

class Chile{
	public $opt;
	
	function Chile(){
		$this->opt = array(
			'url' => get_bloginfo('url').'/wp-content/plugins/chile/chile.xml'
		);
		
	}
	
	function todos(){
		//$contents = @file_get_contents($this->opt['url']);
		//$result = xml2array($contents,1, 'attribute');
		
		$curl_handler = curl_init();
		curl_setopt($curl_handler, CURLOPT_URL, $this->opt['url']);
		curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handler, CURLOPT_BINARYTRANSFER, 1); 
		$f = curl_exec($curl_handler);
		
		$result = xml2array($f,1, 'attribute');
		
		return $result;
	}
	
	function regiones($region = ''){
		//Region:num
		$arr = $this->todos();
		foreach((array)$arr['chile']['region'] as $var){
			$regiones[] = htmlentities($var['attr']['nombre'],ENT_QUOTES,'UTF-8');
		}
		if($region == ''){
			return $regiones;
		}else{
			return $regiones[$region];
		}
	}
	
	function provincia($region, $provincia = ''){
		$arr = $this->todos();
		$i = 0;
		foreach((array)$arr['chile']['region'][$region]['provincia'] as $var){
			$provincias[$region.'-'.$i] = htmlentities($var['attr']['nombre'],ENT_QUOTES,'UTF-8');
			$i++;
		}
		if($provincia == ''){
			return $provincias;
		}else{
			return $provincias[$provincia];
		}
	}
	
	function comuna($region,$provincia,$comuna = ''){
		$arr = $this->todos();
		
		$i = 0;
		foreach((array)$arr['chile']['region'][$region]['provincia'][$provincia]['comuna'] as $var){
			$comunas[$provincia.'-'.$i] = htmlentities($var['attr']['nombre'],ENT_QUOTES,'UTF-8');
			$i++;
		}
		
		if($comuna == ''){
			return $comunas;
		}else{
			return $comunas[$comuna];
		}
	}
	
	/**
	* Comunas de una region específica
	*
	* @param 
	* @return 
	*/ 
	function comunas($region){
		$arr = $this->todos();
		
		foreach( (array)$arr['chile']['region'][$region]['provincia'] as $var){
			foreach($var['comuna'] as $v){
			 if(!$v['attr']['nombre']) continue;
				$comunas[] = $v['attr']['nombre'];
			}
		}
		if(!$comunas) return false;
		
		sort($comunas);
		return $comunas;
	}
}



 ?>