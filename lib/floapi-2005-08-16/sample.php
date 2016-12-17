<pre><?
/***************************************************************************
 *  Original floAPI copyright (C) 2005 by Joshua Hatfield.                 *
 *                                                                         *
 *  In order to use any part of this floAPI Class, you must comply with    *
 *  the license in 'license.doc'.  In particular, you may not remove this  *
 *  copyright notice.                                                      *
 *                                                                         *
 *  Much time and thought has gone into this software and you are          *
 *  benefitting.  We hope that you share your changes too.  What goes      *
 *  around, comes around.                                                  *
 ***************************************************************************/

// Include the file.
include("floAPI.php");

// Create the object.
$sampleapi = new floAPI("username", "password", "127.0.0.1");

// Start collecting events.
$sampleapi->events_toggle("ON");

// Run a test command (sip show peers).
echo($sampleapi->request("COMMAND", array("COMMAND" => "sip show peers")));

// Wait up to twenty seconds for an event to happen, checking
// once each second.  
$t = 0;
while(!($events_found = $sampleapi->events_check()) && $t < 20){
	$t++;
	sleep(1);
}

// How many did we find in one check?
echo("-- Events found: $events_found\r\n\r\n");

// Display collected events. 
while($event = $sampleapi->events_shift()) {
	echo("<b>$event</b>");
}

// Close the connection.
$sampleapi->close();

echo("LOGGED OUT!\r\n\r\n");

echo("-- Additional events: ".$sampleapi->events_check());

// Display any events since the first check till logout.
while($event = $sampleapi->events_shift()) {
	echo("<b>$event</b>");
}
?></pre>