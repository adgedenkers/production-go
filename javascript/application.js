// -- go.va.gov
// -- author: adriaan denkers (adriaan.denkers@va.gov)
// -- version: 2.0
// -- release date: 4-1-2012
// -- file: js/application.js

// When the document is loaded, execute ...
$(document).ready(function(){

	/*
		Submit Login Credentials
	*/
	var request;
	
	$("a#login_submit").click(function() {

		$.ajax({
			url: "api/login.php",
			type: "POST",
			data: {"user" : $("#user").val(), "pass" : $("#pass").val()},
			dataType: "html",
			complete: function(html){
			    alert(html.val());
			  }
		});

	});

	
	
 
});
