<?php
session_start();
include ('config.php');
include ('ConnectDB/Database.php');
if(!isset($_SESSION['id'])){
    header('Location: ' . '/phplog');
}

$db = new Database();
$dataUSer = $db->checkExistsUser(DB_TABLENAME, $_SESSION['id']);

if ($_POST['code']) {
    $code = $_POST['code'];
    $secret = $dataUSer['google_auth_code'];
    include_once ('GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php');
    $ga = new PHPGangsta_GoogleAuthenticator();
    $resultVerifyCode = $ga->verifyCode($secret, $code, 2);

    // check $resultVerifyCode
    if ($resultVerifyCode) {
        $_SESSION['google_auth_code'] = $code;
        echo "<pre>";var_dump('Bạn Đã Xác Thực Thành Công Bằng QRCode của Google . Bạn chờ vài khoảng 8s để tự động về trang chủ ...');echo "</pre>";
        header( "refresh:8;url=index.php" );
    } else {
        echo "<pre>";var_dump('FAILED');echo "</pre>";die();
    }
}

//session_destroy();