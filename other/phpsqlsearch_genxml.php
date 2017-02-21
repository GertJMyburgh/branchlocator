<?php

// google maps key=AIzaSyALKLHmQpaY_wNrRsbZEPMHiDmGN5IlNnQ

require("phpsqlsearch_dbinfo.php");

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// OLD PHP - Opens a connection to a mySQL server
// OLD PHP - $connection = mysql_connect("localhost", $username, $password);
// OLD PHP - if (!$connection) {
// OLD PHP -     die("Not connected : " . mysql_error());
// OLD PHP - }

$mysqli = new mysqli("localhost", $username, $password, $database);
if (mysqli_connect_error()) {
    echo mysqli_connect_error(); exit;
}

// The (?,?,?,?) below are parameter markers used for variable binding
$query = "SELECT address, name, lat, lng, ( 3959 * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < ? ORDER BY distance LIMIT 0 , 20";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssss", $center_lat, $center_lng, $center_lat, $radius); // bind variables

$stmt->execute(); // execute the prepared statement
 
// Set the active mySQL database
// OLD PHP - $db_selected = mysql_select_db($database, $connection);
// OLD PHP - if (!$db_selected) {
// OLD PHP -     die("Can\'t use db : " . mysql_error());
// OLD PHP - }

// Search the rows in the markers table
// OLD PHP - $query = sprintf("SELECT address, name, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20", 
// OLD PHP -         mysql_real_escape_string($center_lat), 
// OLD PHP -         mysql_real_escape_string($center_lng), 
// OLD PHP -         mysql_real_escape_string($center_lat), 
// OLD PHP -         mysql_real_escape_string($radius));

// OLD PHP - $result = mysql_query($query);

// OLD PHP - if (!$result) {
// OLD PHP -     die("Invalid query: " . mysql_error());
// OLD PHP - }

$res = $stmt->get_result();

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = $res->fetch_assoc()) {
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", $row['name']);
    $newnode->setAttribute("address", $row['address']);
    $newnode->setAttribute("lat", $row['lat']);
    $newnode->setAttribute("lng", $row['lng']);
    $newnode->setAttribute("distance", $row['distance']);
}

echo $dom->saveXML();

$stmt->close(); // close the prepared statement
$mysqli->close(); // close the database connection
?>
