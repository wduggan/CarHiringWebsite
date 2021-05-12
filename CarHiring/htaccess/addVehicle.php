<?php
session_start();
$registration = $_POST['registration'];
$errors = 0;
?>

<div>
    <h1><a href='../admin.php'>Back to Admin Page</a></h1>
    <?php if ($errors === 0) {
        $json_filename = "../json/vehicles.json";
        $json_input = file_get_contents($json_filename);
        $json_file = json_decode($json_input, true);

        foreach ($json_file["fleet"]["vehicle"] as $vehicle) {
            $carRegistration = $vehicle["registration"];
            if ($carRegistration == $_POST['registration']) {
                echo "<p>The vehicle under the registration number " . $_POST['registration'] . " already exists as a vehicle.</p>";
                $errors++;
                session_destroy();
            }
        }
        if ($errors === 0) {
            $newArray = array();

            $newArray["registration"] = $_POST["registration"];
            $newArray["vehicleType"] = $_POST["vehicleType"];
            $newArray["description"] = $_POST["description"];
            $newArray["pricePerDay"] = $_POST["pricePerDay"];

            array_push($json_file["fleet"]["vehicle"], $newArray);

            $json_NEW = json_encode($json_file, JSON_PRETTY_PRINT) . "\n";
            file_put_contents($json_filename, $json_NEW);


            echo "<h2>Successfully added the following vehicle:-</h2>";
            echo "<p><strong>Registration Number:</strong> " . $_POST['registration'] . ",
        <br><strong>Vehicle Type:</strong> " . $_POST['vehicleType'] . ",
        <br><strong>Description:</strong> " . $_POST['description'] . ",
        <br><strong>Price Per Day:</strong> " . $_POST['pricePerDay'] . ",</p>";
        }
    }
    ?>
</div>
