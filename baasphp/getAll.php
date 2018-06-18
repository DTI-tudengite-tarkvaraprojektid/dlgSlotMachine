<?php
session_start();
require '../../dlgConfig.php';

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

function defChecked($val){
    if($val == 0){
        return "";
    }else{
        return "checked='true'";
    }
}

function styleChecked($val){
    if($val == 0){
        return "style='background-color: red; opacity: 0.5;'";
    }else{
        return "";
    }
}

// Create connection
$conn = new mysqli($GLOBALS["servername"], $GLOBALS["dbusername"], $GLOBALS["dbpassword"], $GLOBALS["dbname"]);
// Check connection
    if ($conn->connect_error) {
        die("Error Code: 0" . $conn->connect_error);
    } 
    // Select f-n
    $sql = "SELECT * FROM dataGame";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo $result->num_rows." entries loaded.";
        echo "<table>
        <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Title</th>
        <th>Description</th>
        <th>Sentence</th>
        <th>Actions</th>
        </tr>";
        // tabel
        while($row = $result->fetch_assoc()) {
            echo "<tr id=".$row["id"]." ".styleChecked($row['active']).">";
            echo "<td>". $row["id"]."</td>";
            echo "<td><textarea rows='1' cols='30' onclick='activateChButton()' onchange='activateChange(".$row["id"].")' type='text' id=". $row["id"]."slotType".">". $row["slotType"]."</textarea></td>";
            echo "<td><textarea rows='1' cols='30' onfocusout='resizeBox(".$row["id"].")' onfocus='resizeBox(".$row["id"].")' onclick='activateChButton()' onchange='activateChange(".$row["id"].")' id=". $row["id"]."slotContent".">". $row["slotContent"]."</textarea></td>";
            echo "<td><textarea rows='1' cols='30' onfocusout='resizeBox(".$row["id"].")' onfocus='resizeBox(".$row["id"].")' onclick='activateChButton()' onchange='activateChange(".$row["id"].")' id=". $row["id"]."slotDesc".">".$row["slotDesc"]."</textarea>";
            echo "<td><textarea rows='1' cols='30'  onfocusout='resizeBox(".$row["id"].")' onfocus='resizeBox(".$row["id"].")' onclick='activateChButton()' onchange='activateChange(".$row["id"].")' id=". $row["id"]."slotSentence".">". $row["slotSentence"]."</textarea></td>";
            echo "<td><input onclick='activateRemove(".$row["id"].")' type='checkbox' value=".$row["id"].">Delete?
            <input id=".$row["id"].'active'." onclick='activateChButton()' onchange='activateChange(".$row["id"].")' type='checkbox'".defChecked($row['active'])." value=".$row['active'].">Active?";
            echo "</tr>";
        }
        echo "</table>";
        } else {
            echo "Error Code: 1";
        }
    $conn->close();

?>