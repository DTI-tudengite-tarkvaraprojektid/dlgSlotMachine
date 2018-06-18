<?php 
session_start();
require '../../dlgConfig.php';

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

$type = $_GET['type'];
$content = $_GET['content'];
$desc = $_GET['desc'];
$sent = $_GET['sent'];
$active = boolval($_GET['active']);

// Create connection
$conn = new mysqli($GLOBALS["servername"], $GLOBALS["dbusername"], $GLOBALS["dbpassword"], $GLOBALS["dbname"]);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO dataGame (slotType,slotContent,slotDesc,slotSentence,active) VALUES('$type', '$content', '$desc', '$sent', '$active')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>