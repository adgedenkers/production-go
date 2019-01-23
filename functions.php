<?php

function adge()
{
	return "adriaan";
}

// ~~~~~ Generate Random Characters ~~~~~
function generate_chars()
{
 $num_chars = 4; //max length of random chars
 $i = 0;
 $my_keys = "123456789abcdefghijklmnopqrstuvwxyz"; //keys to be chosen from
 $keys_length = strlen($my_keys);
 $url  = "";
 while($i<$num_chars)
 {
  $rand_num = mt_rand(1, $keys_length-1);
  $url .= $my_keys[$rand_num];
  $i++;
 }
 return $url;
}

// ~~~~~ Test Characters for Uniqueness ~~~~~
function isUnique($chars)
{
	global $database;
	//check the uniqueness of the chars
	//global $link;
	
	$chartest = "none-listed";
	
	$q = 'SELECT * FROM urls WHERE unique_chars ="'.$chars.'"';
	$r = $database->query($q);
	
	foreach($r as $row)
	{
		$chartest = $row['unique_chars'];
	}

	if($chartest == $chars): return false;
	else: return true;
	endif;
}

// ~~~~~ Test URL for Uniqueness ~~~~~
function isThere($url)
{
	global $db;
	$urltest = "none-listed";
	
	$q = 'SELECT * FROM urls WHERE url="'.$url.'"';
	$r = $db->query($q);
	
	foreach($r as $row)
	{
		$urltest = $r["url"];
	}
	
	
	if($urltest == $url): 
		return true;
	else: 
		return false;
	endif;
}

?>