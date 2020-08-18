<?php
session_start();
$Session = $_SESSION;
require_once "vendor/autoload.php";
date_default_timezone_set('Asia/Jakarta');
if (!isset($_GET['hal'])) {
    echo "<script>
location.href = '?hal=Home';
</script>";
}

$out = ['Login', 'Logout'];
if (!in_array($_GET['hal'], $out)) {
    if (!isset($Session['admin'])) {
        echo "<script>alert('Anda belum login, silahkan login');</script>";
        echo "<script>location.href = '?hal=Login';</script>";
    }
}

require 'app/class.php';
$Controller = new Controller($_REQUEST);

$komponen = 'views/Komponen';
$data = $Controller->Data;
$Request = json_decode(json_encode($_REQUEST));

include 'views/html.php';
/* Start to develop here. Best regards https://php-download.com/ */
