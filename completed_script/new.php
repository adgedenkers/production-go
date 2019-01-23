<?php

$domain_name = "http://vhaorl3od3.v08.med.va.gov/go";

try 
{
  //create or open the database
  $database = new SQLiteDatabase('data/go-va.sqlite', 0666, $error);
}
catch(Exception $e) 
{
  die($error);
}


include("functions.php");

// DEBUG
//echo "create function started <br>";
//$testTrue = true;
//$testFalse = false;
//echo "testTrue=" . $testTrue . "<br>";
//echo "testFalse=" . $testFalse . "<br>";

$chars = generate_chars(); //generate random characters

/* We check the uniqueness of the characters. The following loop
continues until it generates unique characters */

// DEBUG 
//echo "chars=" . $chars . "<br>";
//echo isUnique($chars) . " (isUnique)<br>";

while(!isUnique($chars))
{
	$chars = generate_chars();
}

// DEBUG 
//echo "chars=" . $chars . "<br>";

$url = $_GET["u"];

// DEBUG 
//echo "url=" . $url . "<br>";

$url = trim($url);//trim it to remove whitespace


// DEBUG 
//echo "url=" . $url . "<br>";

/////////////////
$urltest = "none-listed";
$existch = "----------";

$q = "SELECT * FROM urls WHERE url='".$url."'";





if($result = $database->query($q, SQLITE_BOTH, $error))
{
  while($row = $result->fetch())
  {
    $urltest = $row["url"];
	$existch = $row["chars"];

	//echo $urltest . "<br>";
	//echo $existch . "<br>";
  }
}
else
{
  die($error);
}








//echo "url='{$urltest}'<br>char='{$existch}'<br>";

$urlInDB = "unknown";

if($urltest == $url): 
	$urlInDB = "yes";
else: 
	$urlInDB = "no";
endif;

/////////////////

// DEBUG
//echo $urlInDB . " (urlInDB)<br>";

if($urlInDB == "no"):
	//echo "URL is not in the database...<br>";
	
	$query = 
		'INSERT INTO urls (url, chars, open_count) ' .
		'VALUES ("'.$url.'", "'.$chars.'", 0); ';
	
	if(!$database->queryExec($query, $error))
	{
	  die($error);
	}
	
	print 	"<h2>Your URL has been shortened!</h2>" .
			"<p>Your new URL: <a href='{$domain_name}/{$chars}'>{$domain_name}/{$chars}</a>" . 
			"<br />Will redirect here: <a href='{$url}'>{$url}</a></p>";
			
	
else:

	print	"<h2>The URL is already shortened!</h2>" .
			"<p>The shortened URL is: <a href='{$domain_name}/{$existch}'>{$domain_name}/{$existch}</a>" .
			"<br />Will redirect here: <a href='{$urltest}'>{$urltest}</a></p>";

endif;









