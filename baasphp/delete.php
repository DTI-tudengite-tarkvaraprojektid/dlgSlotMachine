<?php
session_start();
require '../../dlgConfig.php';

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

$did = intval($_GET['did']);

// Create connection
$conn = new mysqli($GLOBALS["servername"], $GLOBALS["dbusername"], $GLOBALS["dbpassword"], $GLOBALS["dbname"]);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to delete a record
$sql = "DELETE FROM dataGame WHERE id='$did'";

if ($conn->query($sql) === TRUE) {
    echo "Record(s) deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>