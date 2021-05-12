<?php
$bookingsList = $_POST['bookedVehicle'];
?>

<?php
$input_filename = "../json/bookings.json";

$json_input = file_get_contents($input_filename);
$json_file = json_decode($json_input, true);

//unset($json_file["bookings"]["booking"][$bookingsList]);

//foreach ($json_file["bookings"]["booking"] as $booking) {
//    $number = $booking["number"];
//    $name = $booking["name"];
//    $bookingStr = $name . ' - Vehicle ' . $number;
//    if ($bookingStr == $bookingsList) {
//        unset($booking);
//    }
//}

for ($i = 0; $i < count($json_file["bookings"]["booking"]); $i++) {
    if ($_POST['bookedVehicle'] == $json_file["bookings"]["booking"][$i]) {
        unset($json_file["bookings"]["booking"][$i]);
        $json_file["bookings"]["booking"] = array_values($json_file["bookings"]["booking"]);
    }
}

file_put_contents("json/bookings.json", json_encode($json_file, JSON_PRETTY_PRINT));

?>
