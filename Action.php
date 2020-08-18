<?php

require_once "vendor/autoload.php";
require 'app/class.php';
use ClanCats\Hydrahon\Query\Expression as Ex;

$Crud = Crud::idupin()->mysqli2;
$Request = json_decode(json_encode($_REQUEST));
$aksi = $Request->aksi;
$link = $_SERVER['HTTP_REFERER'];

$aksi($Request, $Crud);
function insert($Request, $Crud)
{
    $tb = $Request->tb;
    $input = $Request->input;
    $table = $Request->table;
    if ($table == 'barang') {
        $cek2 = collect($Crud->table('barang')->select()->where('idbarang', $input[0])->get());
        if ($cek2->isNotEmpty()) {
            echo "<script>alert('Primary Key sudah digunakan')</script>";
            echo "<script>location.href='$link'</script>";
            die();
        }

    }
    if ($table == 'user') {
        $cek2 = collect($Crud->table($table)->select()->where($tb[0], $input[0])->get());
        if ($cek2->isNotEmpty()) {
            echo "<script>alert('Primary Key sudah digunakan')</script>";
            echo "<script>location.href='$link'</script>";
            die();
        }

    }
    if ($table == 'guru') {
        $cek2 = collect($Crud->table($table)->select()->where($tb[0], $input[0])->get());
        if ($cek2->isNotEmpty()) {
            echo "<script>alert('Primary Key sudah digunakan')</script>";
            echo "<script>location.href='$link'</script>";
            die();
        }

    }
    if (isset($_FILES['input'])) {
        if ($_FILES['input']['size'][0] > 0) {
            $upload = Fungsi::upload($_FILES['input']);
            if ($upload->status) {
                array_push($input, $upload->nama);
                array_push($tb, "lampiran");
            } else {
                $pesan = $upload->error;
                echo "<script>alert('$pesan')</script>";
                echo "<script>location.href='$link'</script>";
                die();
            }

        }
    }
    $tes = collect($tb);
    $ar = $tes->combine($input)->toArray();
    if (isset($Request->cek)) {
        if ($Request->cek == 'keluar') {
            $nip = $input[5];
            $brg = $input[1];
            $qty = $input[2];

            $bln = date_format(date_create($input[0]), 'n');
            $year = date_format(date_create($input[0]), 'Y');
            $cek = collect($Crud->table($table)->select()->where(new Ex('month(tgl) '), $bln)->where(new Ex('year(tgl)'), $year)->where('nip', $nip)->where('idbarang', $brg)->get())->sum('qty');
            $cek3 = $qty + $cek;

            $cek2 = collect($Crud->table('barang')->select()->where('idbarang', $brg)->get())->first()->jatah;
            $cek4 = $cek2 - $cek;
            if ($cek3 > $cek2) {
                $link = $_SERVER['HTTP_REFERER'];

                echo "<script>alert('Maaf telah melebih batas jatah bulanan,sisa jatah bulan ini adalah $cek4')</script>";

                echo "<script>location.href='$link'</script>";
                die();

            }
        }
    }
    $Crud->table($table)->insert($ar)->execute();
}
function update($Request, $Crud)
{
    $tb = $Request->tb;
    $input = $Request->input;
    $table = $Request->table;
    $tes = collect($tb);
    $ar = $tes->combine($input)->toArray();
    $Crud->table($table)->update($ar)->where($Request->primary, $Request->key)->execute();
}
function delete($Request, $Crud)
{
    $table = $Request->table;
    $Crud->table($table)->delete()->where($Request->primary, $Request->key)->execute();
}
echo "<script>alert('Berhasil')</script>";

echo "<script>location.href='$link'</script>";
