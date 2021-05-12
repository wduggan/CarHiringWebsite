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
    <title>Muttley & Co. Car Hire</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./js/jquery/jquery-ui.min.css">
    <script src="js/jquery/jquery3.3.js"></script>
    <script src="js/jquery/jquery-ui.js"></script>
    <script src="js/Vehicles.js"></script>
    <script src="js/Booking.js"></script>

</head>

<body>

<h1>Muttley & Co. Car Hire</h1>
<nav>
    <ul>
        <li><a>Home</a></li>
        <li><a href="map.php">Map</a></li>
        <li><a href="admin.php">Admin</a></li>
    </ul>
</nav>

<div id="bookingData">
    <section id="siteList">
        <fieldset>
            <legend>Our Vehicle Options</legend>
            <ul id="accommTypeLst"></ul>
        </fieldset>
    </section>

    <form id="bookingForm">
        <section id="selectDates">

            <p><label for="arriveDatepicker">Pick up date:</label>
                <input type="text" id="arriveDatepicker" name="arriveDatepicker">
                <label for="departDatepicker">Drop off date:</label>
                <input type="text" id="departDatepicker" name="departDatepicker"></p>
            <p>
                <button type="button" id="checkAvail">Check What's Available</button>
            </p>

            <div id="dateErrors"></div>

            <fieldset>
                <legend>Your Details</legend>
                <ul>
                    <li><label>Name: <input type="text" id="guestName" name="guestName"
                                            placeholder="Please enter your name:"></label></li>
                </ul>
            </fieldset>
            <input type="submit" id="makeBooking" value="Book Selected Vehicle">

        </section>
    </form>

    <section id="sitePreview"></section>
</div>


</section>
</body>
</html>