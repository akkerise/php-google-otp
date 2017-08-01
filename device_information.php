<?php
session_start();
include 'config.php';
include 'ConnectDB/Database.php';

if (empty($_SESSION['id'])) {
    header('location: ' . '/phplog');
}

require_once 'GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php';
$ga = new PHPGangsta_GoogleAuthenticator();
$qrCodeUrl = $ga->getQRCodeGoogleUrl($_SESSION['username'], $_SESSION['google_auth_code']);
$oneCode = $ga->getCode($_SESSION['google_auth_code']);
?>

<div id="img">
    <img src='<?php echo $qrCodeUrl; ?>'/>
</div>

<form method="post" action="processQR.php">
    <label>Enter Google Authenticator Code</label>
    <input type="text" name="code" value="<?php echo $oneCode ?>"/>
    <input type="submit" class="button"/>
</form>
