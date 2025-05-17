<?php
session_start();
$input = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';
$code = isset($_SESSION['captcha_code']) ? $_SESSION['captcha_code'] : '';
if (strcasecmp($input, $code) === 0 && $code !== '') {
    echo 'OK';
} else {
    echo 'FAIL';
} 