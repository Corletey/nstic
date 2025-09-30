<?php

class Mlinks
{
	
	function extract_url($query_text,$tag)
	{
		$split	=explode("&",$query_text);
		$urls	=array();
		foreach($split as $var_mix)
		{
			$chip	=explode("=",$var_mix);
			$id		=$chip[0];
			$b64_var=(count($chip)>2)?str_replace($chip[0]."=","",$var_mix):"";
			$var	=($b64_var)?$b64_var:$chip[1];
			$urls[$id]	=$var;		
		}
		return $urls[$tag];
	}
	
	function ht_link($url_link, $force="",$other="")
	{
	global $activate_htaccess, $vars, $path_adverts, $cms_dir;
	$structure	="data";//folder to display
	
	if($activate_htaccess||$force)
	{
		$chip	=explode(".php?",$url_link);
		$url	=$chip[1];
		
		$others	=($other?"$other,":"");
		$array	=explode(",",$others);
		
		$uvar	=array_merge($vars,$array);
		if(is_array($uvar))
		{
			foreach($uvar as $id)
			{
				$var	=Mlinks::extract_url($url,$id);
				$new	.=($id=="option"&&$var)?$var:"";//
				$new	.=($id=="id"&&$var)?"/".$var:"";//id link
				$new	.=($id=="search"&&$var)?"/".$var:"";//another valuable
				$txt	=(in_array($id,$array)&&$var)?"/".$var:"";
				$new	.=$txt;
			}
		}
		
		$plain		=str_replace("main.php",$structure,$url_link);
		$plain		=str_replace("?","/",$plain);

		$url_link	=($new)?$structure."/".$new:$plain;
	}
	return $url_link;
	}
}# end class



?>