<?php 

add_action('init', 'initchile');

function initchile(){
	global $chile;
	
	if($_GET['region'] || $_GET['region'] === '0'){
  	echo json_encode($chile->comunas($_GET['region']));
  	exit;
	}
		
	//if($_GET['provincia'] != ''){
	//	echo json_encode($chile->provincia($_GET['provincia']));
	//	exit;
	//}
	//if($_GET['comuna'] != ''){
	//	$dd = explode('-',$_GET['comuna']);
	//	$region = $dd[0];
	//	$provincia = $dd[1];
	//	echo json_encode($chile->comuna($region,$provincia));
	//	exit;
	//}
	//if($_GET['comuna'] || $_GET['comuna'] === "0"){
	//	echo json_encode($chile->comunas( (int)$_GET['comuna'] ));
	//	exit;
	//}
}
 ?>