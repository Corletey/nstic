<?php
include('configlrcn/db_mconfig.php');
include('contrlrcn/slmain_mlquery.php');
include('contrlrcn/slmain_mlproposals.php');
include('contrlrcn/pending_evaluation.php');
include('contrlrcn/new_proposals.php');
include('contrlrcn/fowarded_proposals.php');
include('contrlrcn/featured_call.php');
include('contrlrcn/slmain_marchieve.php');
include('contrlrcn/snl_misc.php');
include('contrlrcn/language.php');
#  ----- htaccess links ---
	$activate_htaccess	=1;
	#  ----- htaccess links ---
	$vars		=explode(",","option,id,search,t");
	$ht_prefix	="data";
	$ht_suffix	="";

$Mlinks= new Mlinks();//misc

?>