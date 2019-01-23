<script type="text/javascript" src="http://go.va.gov/js/jquery-1.3.2.min.js"></script>


<style>
	
	#encodedFileContent {
		display: none;
		border: 2px solid navy;
	}
	
	#fileProperties {
		display: none;
		border: 2px solid red;
	}
	
</style>

<script type="text/javascript">
	
	//console.log("loading javascript");
	
	$(document).ready(function() {
				
				//console.log("document ready");
				
				var listName = $("#listName").text();
				var listItem = $("#itemId").text();
				var fileName = $("#fileName").text();
				var attachmt = $("#encodedFileContent").text();
				
				//console.log("list name: " + listName);
				//console.log("item id: " + listItem);
				//console.log("file name: " + fileName);
				////console.log("encoded: " + attachmt);
				
				var listServiceUrl = "http://vaww.oed.portal.va.gov/administration/_vti_bin/lists.asmx";
        
				////console.log("calling addAttachment2List");
    		//addAttachment2List(attachmt, fileName, listName, listItem, listServiceUrl);
    });
		
		function addAttachment2List(attachmentData, fileName, listName, listItem, sharepointSite) {
			
			var soapEnv =
					"<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'> \
						<soapenv:Body> \
							<AddAttachment xmlns='http://schemas.microsoft.com/sharepoint/soap/'> \
								<listName>"+ listName +"</listName> \
					      <listItemID>"+ listItem +"</listItemID> \
					      <fileName>"+ fileName +"</fileName> \
					      <attachment>"+ attachmentData +"</attachment> \
							</AddAttachment> \
						</soapenv:Body> \
					</soapenv:Envelope>";
					
			//console.log("soap envelope: " + soapEnv);

      $.ajax({
          url: sharepointSite,
					beforeSend: function(xhr) {
						////console.log("before sending function...");
	          xhr.setRequestHeader("SOAPAction", "http://schemas.microsoft.com/sharepoint/soap/AddAttachment");
						// display loading graphic
						//$("actionDetails").empty();
						//$("actionDetails").empty().html('<img src="http://vaww.oed.portal.va.gov/SiteCollectionImages/ajax-loader.gif" />');
	       		////console.log("finished before sending...");
	 				},
          type: "POST",
          dataType: "xml",
          data: soapEnv,
          complete: processResult,
          contentType: "text/xml; charset=\"utf-8\"",
					success: function () {
						//console.log("ajax function complete");
					},
					error:function(xhr,err){
					    //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
					    //alert("responseText: "+xhr.responseText);
					}
      });
			
			//console.log("addAttachment2List function complete")
			
		}

    function processResult(xData, status) {
			////console.log("processing result");
	    //$(xData.responseXML).find("List").each(function() {
	    //    $("#data").append("<li>" + $(this).attr("Title") + "</li>");
	    //});
			//$("#data").append(xData.responseXML);
			alert(status);
			alert(xData.responseXML);
    }

</script>

<?php

	require_once('../../../lib/nusoap.php');

	$fileName = $_FILES['file']['name'];
	$tmpName  = $_FILES["file"]["tmp_name"];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];

	$fp       = fopen($tmpName, 'r');
	$content  = fread($fp, filesize($tmpName));
	//$content  = addslashes($content);
	fclose($fp);
	$encodedFile = base64_encode($content);
	
	$listName = $_POST['listName'];
	$listItem = $_POST['inputId'];
		
	?>
	<div id="fileProperties">
		<div id="fileName"><?php echo($fileName); ?></div>
		<div id="itemId"><?php echo($listItem); ?></div>
		<div id="fileSize"><?php echo($fileSize); ?></div>
		<div id="listName"><?php echo($listName); ?></div>
	</div>
	<div id="encodedFileContent"><?php echo($encodedFile); ?></div>
	<?php
	
	//echo($tmpName . "<br>");
	
	$wsdl = "http://vaww.oed.portal.va.gov/administration/_vti_bin/Lists.asmx?WSDL";
	
	$username = 'vhamaster\vhaisawebsvc';
  $password = '$Websvc_$';
  $usecurl = true;
  $auth = $username.":".$password;

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

	$xml = '<AddAttachment xmlns="http://schemas.microsoft.com/sharepoint/soap/"><listName>'.$listName.'</listName><listItemID>'.$listItem.'</listItemID><fileName>'.$fileName.'</fileName><attachment>'.$encodedFile.'</attachment></AddAttachment>';
	
	$xml = trim($xml);
	

	$result = $client->call('AddAttachment', $xml);

	if(isset($fault)) {
	  echo("<h2>Error</h2>". $fault);
	}

	unset($client);

	echo ("<h5>Successfully Uploaded<h5><br /><a href='http://go.va.gov/apps/oed-portal/mail-call/attach-form.html?ID='" . $listItem . "'>Add another file</a> ")

?>