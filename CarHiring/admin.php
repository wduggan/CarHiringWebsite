<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>

<!DOCTYPE html>
<html lang="en">
<!--Nick Meek 2015-->
<head>
    <meta charset="utf-8">
    <title>title</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="leaflet.css">
    <link rel="stylesheet" href="./js/jquery/jquery-ui.min.css">
    <script src="./js/jquery/jquery3.3.js"></script>
    <script src="./js/Admin.js"></script>
    <style>
        th, td {
            padding: 3px 10px;
        }
    </style>
</head>

<body>

<h1>Muttley & Co. Car Hire</h1>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="map.php">Map</a></li>
        <li><a>Admin</a></li>
    </ul>
</nav>
<main>

    <div id="currentBookings"></div>
    <h2>Administrative Tools</h2>

    <div class="boxes">
        <form id="addVehicle" action="htaccess/addVehicle.php" method="POST" novalidate>
            <fieldset>
                <legend>Add Vehicles:</legend>
                <p>
                    <label for="registration">Registration Number:</label>
                    <input type="text" name="registration" id="registration" placeholder='Registration Number' required>
                </p>
                <p>
                    <label for="vehicleType">Vehicle Type:</label>
                    <select id="vehicleType" name="vehicleType" required>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="Luxury">Luxury</option>
                    </select>
                </p>
                <p>
                    <label for="description">Description: </label>
                    <input type="text" name="description" id="description" placeholder='Vehicle Description' required>
                </p>
                <p>
                    <label for="pricePerDay">Price per Day: </label>
                    <input type="text" name="pricePerDay" id="pricePerDay" placeholder='0.00' required>
                </p>
                <p id="errors"></p>
                <p>
                    <input type="submit" name="addVehicle" id="addVehicle" value="Add Vehicle">
                </p>
            </fieldset>
        </form>
    </div>

    <div class="boxes">
        <form id="deleteVehicle" action="" method="post">
            <fieldset>
                <legend>Delete a Vehicle</legend>
                <label for="vehicle">Registration Number: </label>
                <?php
                echo "<select id='vehicle' name='vehicle'>";

                echo "</select>";
                ?>
                </p>
                <p>
                    <input type="submit" name="deleteVehicle" id="deleteVehicle" value="Delete Vehicle">
                </p>
            </fieldset>
        </form>
    </div>


    <div class="boxes">
        <form id="cancelBookingForm" action="htaccess/cancelBooking.php" method="post">
            <fieldset>
                <legend><span>Cancel Booking</span></legend>
                <p>
                    <label for="bookings">Bookings: </label>
                    <?php
                    echo "<select id='bookedVehicle' name='bookedVehicle'>";
                    $input_filename = "./json/bookings.json";

                    $json_input = file_get_contents($input_filename);
                    $json_file = json_decode($json_input, true);

                    // $message = ($json_file["bookings"]["booking"][0]["number"]);
                    // echo "<script type='text/javascript'>alert('$message');</script>";

                    foreach ($json_file["bookings"]["booking"] as $booking) {
                        $name = $booking["name"];
                        $number = $booking["number"];
                        echo "<option>$name - Vehicle $number</option>";
                    }
                    echo "</select>";
                    ?>
                </p>
                <p><input type="submit" name="cancelBooking" id="cancelBooking" value="Cancel Booking"></p>
            </fieldset>
        </form>
    </div>

    <div class="boxes">
        <form id="editVehicleForm" action="" method="post">
            <fieldset>
                <legend>Edit Vehicles:</legend>
                <p>
                    <label for="registration">Registration Number:</label>
                    <input type="text" name="registration" id="registration" placeholder='Registration Number' required>
                </p>
                <p>
                    <label for="vehicleType">Vehicle Type:</label>
                    <select id="vehicleType" name="vehicleType" required>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="Luxury">Luxury</option>
                    </select>
                </p>
                <p>
                    <label for="description">Description: </label>
                    <input type="text" name="description" id="description" placeholder='Vehicle Description' required>
                </p>
                <p>
                    <label for="pricePerDay">Price per Day: </label>
                    <input type="text" name="pricePerDay" id="pricePerDay" placeholder='0.00' required>
                </p>
                <p id="errors"></p>
                <p>
                    <input type="submit" name="editVehicle" id="editVehicle" value="Edit Vehicle">
                </p>
            </fieldset>
        </form>
    </div>

</main>
</body>
</html>
