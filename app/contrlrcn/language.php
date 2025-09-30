<?php
// Set the absolute or relative path to you language files
$path_lang = "/app/contrlrcn/";

// Your base language that does not require translation
$base_lang = "en";
// Set a language as default using cookies
if(isset($_GET["lang"])){
  
  setcookie("lang", strip_tags($_GET["lang"]), strtotime('+30 days'),'/', NULL, 0); //+40 minutes +30 days
  
  $base_lang = strip_tags($_GET["lang"]);
  
    $base_url=basename($_SERVER['REQUEST_URI']);
  if($base_lang=='fr' and $base_url=='index.php?lang=fr'){
  echo("<script>location.href = './';</script>"); 
  }
  
  if($base_lang=='en' and $base_url=='index.php?lang=en'){
  echo("<script>location.href = './';</script>"); 
  }
  
  if($base_lang=='pt' and $base_url=='index.php?lang=pt'){
  echo("<script>location.href = './';</script>"); 
  }

///////////////////////////////////////////////////////////////
  if($base_lang=='en' and $base_url=='main.php?lang=en'){
  echo("<script>location.href = './main.php?option=dashboard';</script>"); 
  }
  if($base_lang=='fr' and $base_url=='main.php?lang=fr'){
  echo("<script>location.href = './main.php?option=dashboard';</script>"); 
  }
  if($base_lang=='pt' and $base_url=='main.php?lang=pt'){
  echo("<script>location.href = './main.php?option=dashboard';</script>"); 
  }
  if($base_lang=='sp' and $base_url=='main.php?lang=sp'){
  echo("<script>location.href = './main.php?option=dashboard';</script>"); 
  }
  
}

// Get language from cookie if exists
if(isset($_COOKIE["lang"])){
 $base_lang = $_COOKIE["lang"]; 
}

// Include the language file if it exists

if(isset($base_lang) and $base_lang=='en') {
  require_once("translation_en.php");
}
if(isset($base_lang) and $base_lang=='fr') {
  require_once("translation_fr.php");
}
if(isset($base_lang) and $base_lang=='pt') {
  require_once("translation_pt.php");
}


?>