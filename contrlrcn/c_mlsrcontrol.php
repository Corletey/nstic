<?php
include('configlrcn/db_mconfig.php');
include('./app/contrlrcn/language.php');
include('contrlrcn/slmain_mlquery.php');
include('contrlrcn/snl_misc.php');

#  ----- htaccess links ---
	$activate_htaccess	=1;
	#  ----- htaccess links ---
	$vars		=explode(",","option,id,search,t");
	$ht_prefix	="data";
	$ht_suffix	="";

$Mlinks= new Mlinks();//misc

?>