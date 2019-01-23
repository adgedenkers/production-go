<?php
require_once('lib/nusoap.php');




try 
{
  //create or open the database
  $database = new SQLiteDatabase('data/go-va.sqlite', 0666, $error);
}
catch(Exception $e) 
{
  die($error);
}
$result_output = "";


// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //


$short = $_GET['u']; // shortened url characters

//echo "u=".$short."<br/>";

$h = "none";

/* Check Short String */
$oedaction_pos = strpos($short, "oedaction_");

// *******************************************************************
// ***	OED Action 
// *******************************************************************
if ($oedaction_pos !== false){ 
	
	list($noval, $action_number) = explode("_", $short);
	//echo "Action Number: ".$action_number."<br/>";
	
	/*	Location of the Lists.asmx file */
	$wsdl = "http://vaww.oed.portal.va.gov/administration/actions/_vti_bin/Lists.asmx?WSDL";

	/*	GUID of the list */
	$guid = "{62D57B72-3C96-4588-8200-0695854A9F49}";

	$username = 'vhamaster\vhaisawebsvc';
	$password = '$Websvc_$';

	$usecurl = true;

	$auth = $username.":".$password;

	//echo $guid."<br>";

	/*	Setup NuSOAP */
	$client = new nusoap_client($wsdl, 'wsdl');
	$client->setCredentials($username,$password,"ntlm");
	$client->setCurlOption(CURLOPT_USERPWD, $auth);

	$err = $client->getError();
	if ($err) {
	    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	    echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
	    exit();
	}

	$client->setUseCurl($usecurl);
	$client->useHTTPPersistentConnection();


	$xml =
	'
	<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
		<listName>{62D57B72-3C96-4588-8200-0695854A9F49}</listName>
		<listView>{C087D505-412D-4174-8AFE-7E93967AEBB1}</listView>
		<query><Query>
			<Where>
				<Eq>
					<FieldRef Name="WebCIMS_x0020_No_x002e_" />
					<Value Type="Text">'.$action_number.'</Value>
				</Eq>
			</Where>
			<OrderBy>
				<FieldRef Name="ID" />
			</OrderBy>
		</Query></query>
		<ViewFields>
			<FieldRef Name="ID" />
			<FieldRef Name="Title" />
			<FieldRef Name="Attachments" />
		</ViewFields>
		<QueryOptions>
			<IncludeMandatoryColumns>FALSE</IncludeMandatoryColumns>
			<IncludeAttachmentUrls>TRUE</IncludeAttachmentUrls>
			<DateInUtc>FALSE</DateInUtc>
		</QueryOptions>
	</GetListItems>
	';

	$xml = trim($xml);

	/*	Invoke the Web Service */
	$result = $client->call('GetListItems', $xml);

	/*	Check for errors */

	if(isset($fault)){
		echo("<h2>Error: </h2>".$fault);
	}
	
	$action_title  = $result['GetListItemsResult']['listitems']['data']['row']['!ows_Title']; // Action Title
	$action_sp_id  = $result['GetListItemsResult']['listitems']['data']['row']['!ows_ID']; // Internal SharePoint ID for the Action

	//echo '<a href="http://vaww.oed.portal.va.gov/administration/actions/Lists/Tasks/DispForm.aspx?ID='.$action_sp_id.'">('.$action_number.') '.$action_title.'</a><br />http://vaww.oed.portal.va.gov/administration/actions/Lists/Tasks/DispForm.aspx?ID='.$action_sp_id;

	$h = 'http://vaww.oed.portal.va.gov/administration/actions/Lists/Tasks/DispForm.aspx?ID='.$action_sp_id;

	unset($client);
	
	
// *******************************************************************
// ***	Standard Redirect
// *******************************************************************	
} else { // All Other Scenarios - Simple Redirect

	$h = "none";

	$query = "SELECT * FROM urls WHERE chars = '{$short}'";
	if ($result = $database->query($query, SQLITE_BOTH, $error))
	{
		while($row = $result->fetch())
		{
			$h = $row['url'];
		
			$i = $row['open_count'] + 1;
			$update_query = "UPDATE urls SET open_count = '{$i}' WHERE chars = '{$short}'";
			$database->query($update_query, SQLITE_BOTH, $error);
		}
	}

} 

//echo "h={$h}<br/>";

if ($h != "none"):
	// redirect
	//header("Location:".$h);
	echo "<br>redirecting to... {$h}<br><br>";
endif;






















?>
