<?php
session_start();
require '../../dlgConfig.php';

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);
$type = $_GET['type'];
$content = $_GET['content'];
echo $content;
$desc = $_GET['desc'];
$sent = $_GET['sent'];
$active = boolval($_GET['active']);

// Create connection
$conn = new mysqli($GLOBALS["servername"], $GLOBALS["dbusername"], $GLOBALS["dbpassword"], $GLOBALS["dbname"]);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE dataGame SET slotType='$type', slotContent='$content', slotDesc='$desc', slotSentence='$sent', active='$active'  WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record(s) updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>