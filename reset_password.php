<?php
/* Password reset process, updates database with new user password */
require 'db.php';
session_start();

// Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Make sure the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) {

        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);

        // We get $_POST['email'] and $_POST['password'] from the hidden input field of reset.php form
        $email = $mysqli->escape_string($_POST['email']);
        $password = $mysqli->escape_string($_POST['password']);

        $sql = "UPDATE users SET password='$new_password', password='$password' WHERE email='$email'";

        if ( $mysqli->query($sql) ) {

        $_SESSION['message'] = "Passwort erfolgreich geändert!";
        header("location: success.php");

        }

    }
    else {
        $_SESSION['message'] = "Passwörter stimmen nicht überein!";
        header("location: error.php");
    }

}
?>
