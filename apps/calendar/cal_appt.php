<?php
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=calendar.ics");
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=calendar.ics");
echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//Foobar Corporation//NONSGML Foobar//EN\n";
echo "METHOD:REQUEST\n"; // requied by Outlook
echo "BEGIN:VEVENT\n";
echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-example.com\n"; // required by Outlok
echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n"; // required by Outlook
echo "DTSTART:".$_GET['start']."\n";
echo "SUMMARY:".$_GET['summary']."\n";
echo "DESCRIPTION:".$_GET['description']."\n";
echo "END:VEVENT\n";
echo "END:VCALENDAR\n";
/*
//calendar/cal_appt.php?start=20100324T140000&end=20100324T143000&summary=My%20Event%20Title&description=hello%20world

var dateStart 	= $_GET['start'];
var dateEnd			= $_GET['end'];
var allDay			= $_GET['allday'];
var summary			= $_GET['summary']; 			// Event Title Field
var description = $_GET['description']; 	// Event Body Field
var dateStart 	= "20100324T140000";
var dateEnd			= "20100324T143000";
var allDay			= "false";
var summary			= "My Event"; 			// Event Title Field
var description = "hello everyone"; 	// Event Body Field
var error				= "";
/*
if (strlen(allDay) == 0) {
	allDay = false;
}

if (strlen(dateEnd) == 0) {
	allDay = true;
}

if (strlen(dateStart) == 0) {
	error = error . "No Start Date Provided\n";
}

//if (error != "") {
	echo "BEGIN:VCALENDAR\n";
	echo "VERSION:2.0\n";
	echo "PRODID:-//US Dept Veterans Affairs//NONSGML VA//EN\n";
	echo "METHOD:REQUEST\n"; // requied by Outlook

	// Timezone Information
	echo "BEGIN:VTIMEZONE\n";
	echo "TZID:GMT -0500 (Standard) / GMT -0400 (Daylight)\n";
	echo "X-ENTOURAGE-CFTIMEZONE:\n";
	echo "BEGIN:STANDARD\n";
	echo "TZNAME:Standard Time\n";
	echo "RRULE:FREQ=YEARLY;WKST=MO;INTERVAL=1;BYMONTH=11;BYDAY=1SU\n";
	echo "TZOFFSETFROM:-0400\n";
	echo "TZOFFSETTO:-0500\n";
	echo "DTSTART:16010101T020000\n";
	echo "END:STANDARD\n";
	echo "BEGIN:DAYLIGHT\n";
	echo "RRULE:FREQ=YEARLY;WKST=MO;INTERVAL=1;BYMONTH=3;BYDAY=2SU\n";
	echo "TZOFFSETFROM:-0500\n";
	echo "TZOFFSETTO:-0400\n";
	echo "DTSTART:16010101T020000\n";
	echo "END:DAYLIGHT\n";
	echo "END:VTIMEZONE\n";

	// Event Information
	echo "BEGIN:VEVENT\n";
	echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-go.va.gov\n"; // required by Outlok
	echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n"; // required by Outlook
	
	// all day event	: 20080413T000000
	// timed event		:	20100324T130000
	
	if (allDay) {
		echo "DTSTART;TZID=\"GMT -0500 (Standard) / GMT -0400 (Daylight)\":" . dateStart . "\n"; 
	} else {
		echo "DTSTART;TZID=\"GMT -0500 (Standard) / GMT -0400 (Daylight)\":" . dateStart . "\n";
		echo "DTEND;TZID=\"GMT -0500 (Standard) / GMT -0400 (Daylight)\":" . dateEnd . "\n";
	}
	echo "SUMMARY:" . summary . "\n";
	echo "DESCRIPTION:" . description . "\n";
	echo "END:VEVENT\n";

	echo "END:VCALENDAR\n";

//} else {
	
//	echo error;

//}
*/
?>