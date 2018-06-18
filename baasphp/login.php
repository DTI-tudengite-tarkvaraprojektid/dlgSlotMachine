<?php
session_start();

require '../../dlgConfig.php';

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $user = clearInput($_POST["uname"]);
    $password = clearInput($_POST["psw"]);
    ##$password_hashed = hash("sha512", $password);
    login($user, $password);
}


function clearInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function login($user, $password){
    // Create connection
    $conn = new mysqli($GLOBALS["servername"], $GLOBALS["dbusername"], $GLOBALS["dbpassword"], $GLOBALS["dbname"]);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM userData WHERE username='$user' AND password='$password'";
    $result = $conn->query($sql);

    $count=mysqli_num_rows($result);

    if($count==1){
        $row = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $row['username'];
            return true;
            header("Refresh:0");
            exit();
    }
    else {
        echo "Wrong Username or Password";
        return false;
    }
    $conn->close();
}

if(isset($_SESSION["user"])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <button name="loginButton" type="submit">Login</button>
    </form>
</div>
</body>
</html>