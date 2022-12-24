<?php
require_once "connect.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //$_SERVER is a PHP super global variable which holds information about headers, paths, and script locations.
    // cHECK IF USER NAME IS EMPTY
    if (empty(trim($_POST['username']))) { //The trim() function removes whitespace and other predefined characters from both sides of a string.
        $username_err = "Username must not be empty";
    } else {
        $sql = "SELECT id FROM user WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql); //mysqli_prepare() function is used to "PREPARE" sql statement for execution
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username); //it binds the variable($param_username) to the prepared statement($stmt)
            // Set the value of param username
            $param_username = trim($_POST['username']);
            // Try to exicut the statement:
            if (mysqli_stmt_execute($stmt)) { //STARTS THE EXECUTION
                mysqli_stmt_store_result($stmt); // IT STORES THE RESULT
                if (mysqli_stmt_num_rows($stmt) == 1) { // IT CHECKS THE DUBLICATE RESULTS IN THE ROWS
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Somting went wrong.";
            }
        }
    }

    mysqli_stmt_close($stmt); // stop execution of the sql statement


    //  Checkfor password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password must be at least 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

    //  Check for Confirm password
    if (trim($_POST['password']) != (trim($_POST['confirm_password']))) {
        $password_err = "Password should match";
    }

    // If no errror, insert it into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO user (username, password) VALUES (?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set this parameter:
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //password_hash() creates a new password hash using a strong one-way hashing algorithm.
                                                                          // PASSWORD_DEFAULT IS A CONSTANT WHICH FOLLOWS AN ALGORITHM TO STORE THE HASHCODE IN DB.  
            // Try to exicute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                echo "Somting went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="row my-bootstrap-row">
    <div class="wpaper">
        <h1 >Log in</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Enter your name">
           <input type="email" placeholder="Enter you Email id">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="confirm_password" placeholder=" confirm Password">
            <input type="submit" value="LOGIN">
        </form>
    <div class="bottom-text">
       
     
        <a href="login.php">Alredy have an account? click here</a>
    </div>
   
</div>
    <div id="overlay-area"></div>
</body>
</html>