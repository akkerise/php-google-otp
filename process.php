<?php
session_start();
require('ConnectDB/Database.php');
require('config.php');
require_once('GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php');
//require_once ('GoogleAuthenticator.php/lib/GoogleAuthenticator.php');


if ($_REQUEST) {
    foreach ($_POST as $k => $v) {
        $data[$k] = trim($v);
    }
    $db = new Database();
    if ($_REQUEST['action'] === 'login') {
        $result = $db->login(DB_TABLENAME, $data);
        if (!isset($result) || empty($result)) {
            echo "<pre>";var_dump($result);echo "</pre>";die();
        } else {
            $_SESSION['id'] = $result['id'];
            $_SESSION['google_auth_code'] = $result['google_auth_code'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['username'] = $result['username'];

            header('location: ' . '/phplog/device_information.php');
        }
    } elseif ($_REQUEST['action'] === 'register') {
        $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $ga = new PHPGangsta_GoogleAuthenticator();
        $secret = $ga->createSecret();
        $data['google_auth_code'] = $secret;
        $result = $db->register(DB_TABLENAME, $data);
        if ($result === true) {
            header('location: ' . '/phplog');
        }
    } else {
        echo "<pre>";var_dump('Mày Muốn Làm Gì Thì Làm Đi Chứ Tao Đâu Hỗ Trợ Mày Vào Đây ???');echo "</pre>";die();
    }

    if ($result === true) {
        echo "<pre>";var_dump('Register Success');echo "</pre>";die();
    } else {
        echo "<pre>";var_dump($result);echo "</pre>";die();
    }
}


