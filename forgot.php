<?php
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    {
        $_SESSION['message'] = "Es existiert kein Konto mit dieser E-Mail Adresse! Bitte registriere dich.";
        header("location: error.php");
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $email = $user['email'];
        $password = $user['password'];
        $first_name = $user['first_name'];

        // Session message to display on success.php
        $_SESSION['message'] = "<p>Bitte überprüfen dein Posteingang der E-Mail Adresse <span>$email</span>"
        . " Wir haben dir soeben ein Link, um dein Passwort zu ändern, zugesendet</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'Password ändern Link (konst-stobe.ch)';
        $message_body = '
        Hallo '.$first_name.',

        Du hast ein neues Passwort angefordert.

        Bitte klicke den untenstehenden Link an um ein neues Passwort zu definieren:

        http://localhost:8888/CMS/admin/reset.php?email='.$email.'&password='.$password;

        mail($to, $subject, $message_body);

        header("location: success.php");
  }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>KONST STOBE | Passwort vergessen</title>
    <meta name="description" content="">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link href="../css/reset.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/mobile.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300|Oswald" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0"/>
</head>

<body>
  <div class="form">

    <h3>Passwort ändern</h3>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        <p>E-Mail Adresse<span class="req">*</span></p>
      </label>
      <input class="input-area" type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>zurücksetzen</button>
    </form>
  </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>

</html>
