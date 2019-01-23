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
	header("Location:".$h);
	//echo "<br>redirecting to... {$h}";
endif;


// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //



//read data from database
$query = "SELECT * FROM urls ORDER BY open_count DESC LIMIT 10";
if($result = $database->query($query, SQLITE_BOTH, $error))
{
  while($row = $result->fetch())
  {
	$result_output = $result_output . "<li style='word-wrap: break-word;margin-bottom:10px;margin-left:0px;'><a href='{$row['url']}'>{$row['url']}</a> | <b><i>http://go.va.gov/{$row['chars']}</i></b> | Count: {$row['open_count']}</li>";
  }
}
else
{
  die($error);
}



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<!--
  File............: va_intranet.htm
  Description.....: VA Intranet template
  Version.........: 2.0
  Release Date....: January 29, 2008
-->

<html lang="en">
<head>

	<!-- START: META DATA -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="language" content="en">
	<meta name="author" content=" ">
	<meta name="subject" content=" ">
	<meta name="keywords" content=" ">
	<meta name="datecreated" content=" ">
	<meta name="datereviewed" content=" ">
	<!-- END: META DATA -->
	
	<title>go.va.gov - VA's URL Shortener</title>
	
	<style type="text/css" media="screen,print">
		/* START: MAIN VA STYLE SHEET */
		@import url(http://vaww.va.gov/va_files/styles/va-styles.css);
		/* END: MAIN VA STYLE SHEET */
		@import url(http://vaww.va.gov/va_files/styles/va-user-styles.css);
		@import url(http://vaww.va.gov/va_files/styles/top-nav-styles.css);
		@import url(http://vaww.va.gov/va_files/styles/vaSearch.css);
		/* START: STYLE SHEET FOR SITE SPECIFIC NAVIGATION HYPERLINKS */
		@import url(http://vaww.va.gov/va_files/styles/user-side-menu-styles.css);
		/* END: STYLE SHEET FOR SITE SPECIFIC NAVIGATION HYPERLINKS */
	</style>
	<style type="text/css" media="screen">
		#prBanner { display:none; }
	</style>
	<style type="text/css" media="print">
		#pgBanner { display:none; }
		#nav-main { display: none; }
		#nav-sidebar { display: none; }
		#main-content-table { width: 100%; }
		.no-print {
			display: none;
		}
	</style>
</head>

<body>

	<!-- SKIP NAV -->
	<div id="skiplink">
		<a href="#content-area">skip to page content</a>
	</div>
	
	<!-- TOP OF PAGE -->
	<a name="top"></a>

	<!-- noindex -->
	<!-- START: VA BANNER -->
	<img src="http://vaww.va.gov/va_files/images/frame/intra-header-banner-print.jpg" alt="United States Department of Veterans Affairs" id="prBanner" width="767" height="94" style="border:0px">
	<table id="pgBanner" border="0" cellpadding="0" cellspacing="0" width="767" summary="Table is used for layout purposes" style="z-index:1">
	<tbody>
	<tr>
		<td width="590"><img src="http://vaww.va.gov/va_files/images/frame/intra-header-banner-top.jpg" alt="United States Department of Veterans Affairs Intranet" width="590" height="67" style="border:0px"></td>
		<td width="177" id="search" style="background-image:url(/va_files/images/frame/intra-header-banner-top-right.jpg); vertical-align:top;">
			<form name="searchForm" id="searchForm" method="GET" action="http://vaww.index.va.gov/search/va/va_search.jsp">
				<script language="javascript" src="http://vaww.va.gov/va_files/scripts/vaSearch.js" type="text/javascript"></script>
				<noscript><!-- Click Advanced Search link to enhanced search functionality --></noscript>
				<input name="TT" type="hidden" id="TThidden" value="1">
				<!-- do not insert line breaks in the div tag below -->
				<div id="mainSearchForm"><label for="searchtxt" style="display:none">Enter your search text</label><input name="QT" type="text" id="searchtxt" size="5" title="Enter your search text" value=""><label for="searchbtn" style="display:none">Button to start search</label><input name="searchbtn" type="submit" id="searchbtn" title="Button to start search" value="Search"></div>
				<!-- do not insert line breaks in the div tag above -->
				<span id="moreLink">&raquo;&nbsp;<a href="http://vaww.index.va.gov/search/va/va_adv_search.jsp" style="color:#ffffff" title="Go to Advanced Search Page">Open Advanced Search</a></span>
			</form>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0" width="767" summary="table is used for layout purposes">
			<tbody>
			<tr>
				<td width="149" id="nav-main-seal"><img src="http://vaww.va.gov/va_files/images/frame/intra-header-banner-bottom.jpg" alt="bottom of the Veterans Affairs seal" width="149" height="27" style="border:0px"></td>
				<td width="618" id="nav-main">
					<ul id="nav-top">
						<!-- START: TOP-NAVIGATION HYPERLINKS -->
						<li class="widetop"><a href="http://vaww.va.gov/" title="Veterans Affairs Intranet Home Page" class="widetop">VA Intranet Home</a></li>
						<li class="narrowtop"><a href="http://www.va.gov/about_va/" title="Information about the Department of Veterans Affairs" class="narrowtop">About VA</a></li>
						<li class="averagetop"><a href="http://vaww.va.gov/landing_organizations.htm" title="Department of Veterans Affairs Organizations" class="averagetop">Organizations</a></li>
						<li class="averagetop"><a href="http://vaww.va.gov/directory/" title="Find a Veterans Affairs facility" class="averagetop">Locations</a></li>
						<li class="widertop"><a href="http://vaww.va.gov/landing_employee.htm" title="Resources for VA employees" class="widertop">Employee Resources</a></li>
						<!-- END: TOP-NAVIGATION HYPERLINKS -->
					</ul>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
	<!-- END: VA BANNER -->
	<!-- /noindex -->

	<table border="0" cellpadding="0" cellspacing="0" width="767" summary="table is used for layout purposes" id="main-content-table">
	<tbody>
	<tr>
		<!-- noindex -->
		<!-- START: LEFT NAVIGATION -->
		<td id="nav-sidebar">
			<div>
			<ul id="nav2">
				<!-- START: SITE SPECIFIC NAVIGATION HYPERLINKS -->
				<li><a href="/" title="go.va.gov Home Page">Home</a></li>
				<li><a href="http://vaww.oed.portal.va.gov/" title="The Office of Enterprise Development">Office of Enterprise Development</a></li>
				<li><a href="http://vaww.va.gov/oit/" title="The VA Office of Information and Technology">Office of Information and Technology</a></li>
				<!-- END: SITE SPECIFIC NAVIGATION HYPERLINKS -->
			</ul>
			</div>
		</td>
		<!-- END: LEFT NAVIGATION -->
		<!-- /noindex -->

		<td id="content-va">
			<a name="content-area"></a>

			<!-- START: SITE NAME BAR -->
			<p class="title-bar"><!-- START: SITE NAME -->GO.VA.GOV<!-- END: SITE NAME --></p>
			<!-- END: SITE NAME BAR -->

			<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="table is used for layout purposes">
			<tbody>
			<tr>
				<td id="content-main">
					<table width="100%" summary="This table is used for layout purposes">
					<tr>
						<td>
							<!-- START: PAGE TITLE AREA -->
							<p class="page-title"><!-- START: PAGE TITLE -->VA's URL Shortener<!-- END: PAGE TITLE --></p>
							<!-- END: PAGE TITLE AREA -->
							
							<!-- START: PAGE CONTENT -->


<center>
	<form action="new.php" method="post">
		<input type="text" name="u" size="75" />
		<input type="submit" value="Shorten this URL" />
	</form>
</center>

<hr />
<br /><br />
<h4>Popular URLs in our Database...</h4>
<br />
<div style="width:550px">
<ul style="list-style:none; margin-left:0;">
<?php
	print $result_output;
?>
</ul>
</div>



<!-- END: PAGE CONTENT -->

<!-- noindex -->
<!-- START: SITE SPECIFIC FOOTER -->

<!-- END: SITE SPECIFIC FOOTER -->
<!-- /noindex -->
</td>
</tr>
</table>
</td>
</tr>
</tbody>
</table>

<!-- noindex -->
<!-- START: PAGE FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="table is used for layout purposes">
<tbody>
<tr>
<td id="nav-footer">
<!-- START: REQUIRED VA INTRANET FOOTER HYPERLINKS -->
<a href="http://vaww.va.gov/accessible/" title="Section 508 Accessibility">Section 508 Accessibility</a> | <a href="http://vaww.va.gov/privacy/" title="Privacy policy for the VA Intranet">Intranet Privacy Policy</a> | <a href="http://vaww.va.gov/ohrm/EmployeeRelations/grievance.htm" title="No Fear Act information">No Fear Act</a>
<br>
<a href="http://vaww.va.gov/med/" title="Intranet site for Veterans Health Administration">VHA Intranet Home</a> | <a href="http://vbaw.vba.va.gov/" title="Intranet site for Veterans Benefits Administration">VBA Intranet Home</a> | <a href="http://vaww.nca.va.gov/" title="Intranet site for National Cemetery Administration">NCA Intranet Home</a>
<!-- END: REQUIRED VA INTRANET FOOTER HYPERLINKS -->
</td>
</tr>
<tr>
<td id="nav-review">Reviewed/Updated Date: <!-- START: LAST MOD DATE -->November 05, 2009<!-- END: LAST MOD DATE --></td>
</tr>
</tbody>
</table>
<!-- END: PAGE FOOTER -->
<!-- /noindex -->

</td>
</tr>
</tbody>
</table>

</body>
</html>
