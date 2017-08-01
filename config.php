<?php
// ThanhNA (0968381829) - nguyenthanh.rise.88@gmail.com
// define('DB_DBMS', 'postgres');          // Hệ quản trị cơ sở dữ liệu bạn dùng (Postgresql or MySQL)
// define('DB_HOST', 'localhost');         // Host
// define('DB_PORT', 5432);                // Cổng kết nối tới CSDL
// define('DB_USER', 'postgres');          // Tên đăng nhập
// define('DB_PASS', '8888');              // Pass đăng nhập
// define('DB_DBNAME', 'tododb');          // Tên của Database bạn quản lý
// define('DB_TABLENAME', 'testusers123'); // Tên của bảng dữ liệu , lưu ý thêm đầy đủ các trường dữ liệu
define('DB_DBMS', 'mysql');             // Hệ quản trị cơ sở dữ liệu bạn dùng (Postgresql or MySQL)
define('DB_HOST', 'localhost');         // Host
define('DB_PORT', 80);                  // Cổng kết nối tới CSDL
define('DB_USER', 'root');              // Tên đăng nhập
define('DB_PASS', '8888');              // Pass đăng nhập
define('DB_DBNAME', 'databasetest');    // Tên của Database bạn quản lý
define('DB_TABLENAME', 'abcabc');       // Tên của bảng dữ liệu , lưu ý thêm đầy đủ các trường dữ liệu

//Thông tin cấu hình
define('URL_DEMO', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/alepay-sendcardlinkrequest/');
define('URL_CALLBACK', URL_DEMO . '/result.php'); // URL đón nhận kết quả
define('URL_TOKEN', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/alepay-tokenization/');
//Alepay cung cấp
$config = array(
    "apiKey" => "0COVspcyOZRNrsMsbHTdt8zesP9m0y", //Là key dùng để xác định tài khoản nào đang được sử dụng.
    "encryptKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCIh+tv4h3y4piNwwX2WaDa7lo0uL7bo7vzp6xxNFc92HIOAo6WPZ8fT+EXURJzORhbUDhedp8B9wDsjgJDs9yrwoOYNsr+c3x8kH4re+AcBx/30RUwWve8h/VenXORxVUHEkhC61Onv2Y9a2WbzdT9pAp8c/WACDPkaEhiLWCbbwIDAQAB", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
    "checksumKey" => "hjuEmsbcohOwgJLCmJlf7N2pPFU1Le", //Là key dùng để tạo checksum data.
    "callbackUrl" => URL_CALLBACK
);