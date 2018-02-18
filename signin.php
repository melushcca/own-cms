<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>KONST STOBE | Benutzer registrieren</title>
    <meta name="description" content="">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link href="../css/reset.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/mobile.css" rel="stylesheet">
    <link href="../css/cms/reset.css" rel="stylesheet">
    <link href="../css/cms/main.css" rel="stylesheet">
    <link href="../css/cms/mobile.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300|Oswald" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0"/>
</head>

<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=cms', 'admin', 'mycms');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registrierung</title>
</head>
<body>

<?php
$showFormular = true;

if(isset($_GET['register'])) {
 $error = false;
 $email = $_POST['email'];
 $passwort = $_POST['password'];
 $passwort2 = $_POST['password2'];
 $firstName = $_POST['firstname'];
 $lastName = $_POST['lastname'];

 if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
 $error = true;
 }
 if(strlen($passwort) == 0) {
 echo 'Bitte ein Passwort angeben<br>';
 $error = true;
 }
 if($passwort != $passwort2) {
 echo 'Die Passwörter müssen übereinstimmen<br>';
 $error = true;
 }

 //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
 if(!$error) {
 $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
 $result = $statement->execute(array('email' => $email));
 $user = $statement->fetch();

 if($user !== false) {
 echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
 $error = true;
 }
 }

 //Keine Fehler, wir können den Nutzer registrieren
 if(!$error) {
 $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

 $statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
 $result = $statement->execute(array('email' => $email, 'password' => $passwort_hash));

 if($result) {
 echo '<p class="info-meldung">Du wurdest erfolgreich registriert. <a href="index.php">Zum Login</a></p>';
 $showFormular = false;
 } else {
 echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
 }
 }
}

if($showFormular) {
?>


<section class="login-container">
  <h1>Registrieren</h1>
  <p>Lorem ipsum dolor sit amet, elitr, sed diam voluptua. At vero et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
  </p>
  <form class="my-account-container" action="?register=1" method="post">
    <h3>Registrieren</h3>
    <div class="my-account-input">
      <div class="my-firstname">
        <p>Vorname</p>
        <input class="input-area" type="text" size="40" maxlength="250" name="firstname"><br><br>
      </div>
      <div class="my-lastname">
        <p>Nachname</p>
        <input class="input-area" type="text" size="40" maxlength="250" name="lastname"><br><br>
      </div>
      <div class="my-account-email">
        <p>E-Mail-Adresse</p>
        <input class="input-area" type="email" size="40" maxlength="250" name="email"><br><br>
      </div>
      <div class="my-account-passwort">
        <p>Passwort</p>
        <input class="input-area" type="password" size="40"  maxlength="250" name="password"><br>
      </div>
      <div class="my-account-passwort last-input">
        <p>Passwort wiederholen</p>
        <input class="input-area" type="password" size="40" maxlength="250" name="password2"><br>
      </div>
    </div>
    <input class="login-button-box" type="submit" value="Abschicken">
  </form>
  <div id="error-infotext" class="error"><?php echo $errorMessage;?></div>
</section>

<?php
} //Ende von if($showFormular)
?>

</body>
</html>
