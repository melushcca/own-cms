<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
session_start();

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);

    // Make sure user email with matching hash exist
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash'");

    if ( $result->num_rows == 0 )
    {
        $_SESSION['message'] = "Ungültige URL eingegeben um Passwort zu ändern.";
        header("location: error.php");
    }
}
else {
    $_SESSION['message'] = "Sorry, versuche es nochmal!";
    header("location: error.php");
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Passwort ändern</title>
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <link href="css/reset.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
  <link href="css/mobile.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300|Oswald" rel="stylesheet" type="text/css">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0"/>
</head>

<body>
    <div class="form">

          <h3>Neues Passwort festlegen</h3>

          <form action="reset_password.php" method="post">

          <div class="field-wrap">
            <label>
              <p>Neues Passwort<span class="req">*</span></p>
            </label>
            <input type="password"required name="newpassword" autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              <p>Neues Passwort erneut eingeben<span class="req">*</span></p>
            </label>
            <input type="password"required name="confirmpassword" autocomplete="off"/>
          </div>

          <!-- This input field is needed, to get the email of the user -->
          <input type="hidden" name="email" value="<?= $email ?>">
          <input type="hidden" name="hash" value="<?= $hash ?>">

          <button class="button button-block"/>Ändern</button>

          </form>

    </div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
</html>
