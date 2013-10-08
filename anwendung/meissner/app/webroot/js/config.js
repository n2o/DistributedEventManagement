/**
 * Just a collection to keep all information and settings in one place to configure
 * all JavaScript sensitive processes, like the WebSocket server and so on
 */

// Settings for WebSocket server from AppContronller.php
var port = jsVars.port;
var name = jsVars.username;
var host = jsVars.hostname;
var controller = jsVars.controller;

/* Publish / Subscribe */
// Subscribe: Adding all events to the user who created it to get status updates
var subEventsArray = [];
var allSubs = jsVars.subscriptions;
for (var sub in allSubs) {
	subEventsArray.push(allSubs[sub].event);
}

// Synchronize current socket with name and signed message
var synMessage = jsVars.synMessage;

/************************************************************************************/

// short version to make an app notification
function notification(text, type) {
	noty({text: text, type: type});
}
