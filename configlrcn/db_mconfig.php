<?php
error_reporting(1);

// Load environment variables from .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        // Remove quotes if present
        if (preg_match('/^"(.*)"$/', $value, $matches)) {
            $value = $matches[1];
        } elseif (preg_match("/^'(.*)'$/", $value, $matches)) {
            $value = $matches[1];
        }
        
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load the .env file
loadEnv(__DIR__ . '../.env');

// Database configuration using environment variables
$hostm = getenv('DB_HOST');
$dbm = getenv('DB_NAME');
$usrm = getenv('DB_USER');
$pwdm = getenv('DB_PASSWORD');

// Object oriented style
$mysqli = new mysqli($hostm, $usrm, $pwdm, $dbm);

// Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

///////////////////////site details
$sitename = getenv('SITE_NAME') ?: "Grants Management";
$prefix = getenv('DB_PREFIX') ?: "ppr_";
$siteshortname = getenv('SITE_SHORT_NAME') ?: "Grants Management";

///////////////////key words//////////////////
$keywords = getenv('SITE_KEYWORDS') ?: "Grants Management";
$metatags = getenv('SITE_METATAGS') ?: "Grants Management";

//////////////////////////////Time Zone////////////////////
date_default_timezone_set('Africa/Accra');
$today = date("Y-m-d");
$year = date("Y");
$time = date("H:i:s");
$usersipaddress = $_SERVER['REMOTE_ADDR'];
$sesdate = date("Y/m/d/");
$localtime = date("G:i:s");
$dateSubmitted = date("Y-m-d G:i:s");
$Hour = date("G:i");
$todayfull = date("l jS \of F Y h:i:s A");

////////////////////Get Base URL Link/////////////////////
$base_url_localhost = getenv('BASE_URL_LOCALHOST') ?: 'http://localhost/nstic-grants/';
$base_url_production = getenv('BASE_URL_PRODUCTION') ?: 'https://careersug.com/grants/';

if ($_SERVER['HTTP_HOST'] == "localhost") {
    $base_url = $base_url_localhost;
} 
if ($_SERVER['HTTP_HOST'] == "careersug.com") {
    $base_url = $base_url_production;
} 
if ($_SERVER['HTTP_HOST'] == "www.careersug.com") {
   $base_url = $base_url_production;
}

function Titles()
{
    global $prefix, $id, $sitename, $category, $mysqli;
    
    if($category == 'grantcall'){
        $query_T = "SELECT * FROM ".$prefix."grantcalls where grantID='$id'";
        $rsT = $mysqli->query($query_T);
        $rowsWT = $rsT->fetch_array();
        
        echo $mysqli->real_escape_string($rowsWT['title']);	
    }
}

///Check from configuration Table
$query_T = "SELECT * FROM ".$prefix."configuration order by id desc limit 0,1";
$rsT = $mysqli->query($query_T);
$rowsWT = $rsT->fetch_array();
$name_granting_council = $rowsWT['name_granting_council'];
$physical_address = $rowsWT['physical_address'];
$postal_address = $rowsWT['postal_address'];
$post_email = $rowsWT['email'];
$post_telephone = $rowsWT['telephone'];
$fulladdress = "$name_granting_council<br>
$physical_address<br>
$postal_address<br>
$post_email<br>
$post_telephone<br>
";

// SMTP configuration using environment variables
$usmtpportNo = getenv('SMTP_PORT');
$usmtpHost = getenv('SMTP_HOST');
$emailUsername = getenv('SMTP_USERNAME');
$emailPassword = getenv('SMTP_PASSWORD');
$emailSSL = getenv('SMTP_SSL');
$emailBcc = getenv('SMTP_BCC');

?>