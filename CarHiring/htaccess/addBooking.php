<?php
$new = json_decode(file_get_contents("php://input"), true);

$json_filename = "../json/bookings.json";
$json_input = file_get_contents($json_filename);
$json_file = json_decode($json_input, true);

$newArray = array();

$newArray["number"] = $new["number"];
$newArray["name"] = $new["name"];

$dayPickup = strval($new["pickup"]["day"]);
$monthPickup = strval($new["pickup"]["month"]);
$yearPickup = strval($new["pickup"]["year"]);
$dayDropoff = strval($new["dropoff"]["day"]);
$monthDropoff = strval($new["dropoff"]["month"]);
$yearDropoff = strval($new["dropoff"]["year"]);

//list($dayPickup, $monthPickup, $yearPickup) = explode('-', $new["pickup"]);
$newArray["pickup"]["day"] = $dayPickup;
$newArray["pickup"]["month"] = $monthPickup;
$newArray["pickup"]["year"] = $yearPickup;

//list($dayDropoff, $monthDropoff, $yearDropoff) = explode('-', $new["dropoff"]);
$newArray["dropoff"]["day"] = $dayDropoff;
$newArray["dropoff"]["month"] = $monthDropoff;
$newArray["dropoff"]["year"] = $yearDropoff;

array_push($json_file["bookings"]["booking"], $newArray);

$json_NEW = json_encode($json_file, JSON_PRETTY_PRINT) . "\n";
file_put_contents($json_filename, $json_NEW);
?>