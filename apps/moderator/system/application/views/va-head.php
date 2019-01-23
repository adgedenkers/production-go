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
	
	<script src="http://go.va.gov/js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="http://go.va.gov/js/date.js" type="text/javascript"></script>
	<script src="http://go.va.gov/js/ui/minified/jquery-ui.min.js" type="text/javascript"></script>
	
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
				<li><a href="http://go.va.gov/apps/moderator/" title="VA Moderator Home">Home</a></li>
				<li><a href="" title=""></a></li>
				<!-- END: SITE SPECIFIC NAVIGATION HYPERLINKS -->
			</ul>
			</div>
		</td>
		<!-- END: LEFT NAVIGATION -->
		<!-- /noindex -->

		<td id="content-va">
			<a name="content-area"></a>

			<!-- START: SITE NAME BAR -->
			<p class="title-bar"><!-- START: SITE NAME -->VA Moderator<!-- END: SITE NAME --></p>
			<!-- END: SITE NAME BAR -->

			<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="table is used for layout purposes">
			<tbody>
			<tr>
				<td id="content-main">
					<table width="100%" summary="This table is used for layout purposes">
					<tr>
						<td>
							<!-- START: PAGE TITLE AREA -->
							<p id="this-page-title" class="page-title">Moderate Your Work</p>
							<!-- END: PAGE TITLE AREA -->
							
							<!-- START: PAGE CONTENT -->
