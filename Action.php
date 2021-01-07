<?php

require_once "vendor/autoload.php";
require 'app/class.php';

$Crud = Crud::idupin()->mysqli2;
$Request = json_decode(json_encode($_REQUEST));
$aksi = $Request->aksi;
$link = $_SERVER['HTTP_REFERER'];
if (isset($Request->link)) {
    $link = $Request->link;
}

$aksi($Request, $Crud, $link);
function insert($Request, $Crud, $link)
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
            echo "<script>alert('NIP Sudah di gunakan')</script>";
            echo "<script>location.href='$link'</script>";
            die();
        }

    }
    if (isset($_FILES['input'])) {
        if ($_FILES['input']['size'][0] > 0) {
            $upload = Fungsi::upload($_FILES['input']);
            if ($upload->status) {
                array_push($input, $upload->nama);
                $file = [
                    'barang' => 'foto',
                    'alokasi' => 'bukti',
                    'rusak' => 'bukti_rusak',
                ];
                array_push($tb, $file[$table]);
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

    $Crud->table($table)->insert($ar)->execute();
}
function update($Request, $Crud, $link)
{
    $tb = $Request->tb;
    $input = $Request->input;
    $table = $Request->table;
    if (isset($_FILES['input'])) {
        if ($_FILES['input']['size'][0] > 0) {
            $upload = Fungsi::upload($_FILES['input']);
            if ($upload->status) {
                array_push($input, $upload->nama);
                $file = [
                    'barang' => 'foto',
                    'alokasi' => 'bukti',
                    'rusak' => 'bukti_rusak',

                ];
                array_push($tb, $file[$table]);
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
    if (isset($ar['status'])) {
        if ($ar['status'] == 'ACC') {
            $tran = $Crud->table($table)->select()->join('detail_permintaan', 'detail_permintaan.idtransaksi', '=', "$table.idtransaksi")->where("$table.$Request->primary", $Request->key)->get();

            $data['transaksi_masuk'] = collect($Crud->table('transaksi_masuk')->select()->get());
            $data['transaksi_keluar'] = collect($Crud->table('detail_permintaan')->select()->join('transaksi_keluar', 'transaksi_keluar.idtransaksi', '=', 'detail_permintaan.idtransaksi')->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('nama', '!=', '')->where('status', 'ACC')->get());

            $data['barang'] = collect($Crud->table('barang')->select()->where('habisPakai', 'Ya')->get())->map(function ($item, $key) use ($data) {
                $item->masuk = $data['transaksi_masuk']->where('idbarang', $item->idbarang)->sum('qty');
                $item->keluar = $data['transaksi_keluar']->where('idbarang', $item->idbarang)->sum('qty');

                $item->stok = $item->masuk - $item->keluar;
                return $item;
            });
            foreach ($tran as $k) {
                $cek = $data['barang']->where('idbarang', $k->idbarang);
                if ($cek->isEmpty()) {
                    echo "<script>alert('Gagal: Barang tidak di temukan')</script>";
                    echo "<script>location.href='$link'</script>";
                    die();
                }
                $cek = $cek->first();
                $cek = $cek->stok - $k->qty;
                if ($cek < 0) {
                    echo "<script>alert('Gagal: Stok barang tidak mencukupi')</script>";
                    echo "<script>location.href='$link'</script>";
                    die();
                }

            }
        }
    }
    $Crud->table($table)->update($ar)->where($Request->primary, $Request->key)->execute();
}
function delete($Request, $Crud, $link)
{
    $table = $Request->table;
    $Crud->table($table)->delete()->where($Request->primary, $Request->key)->execute();
}
echo "<script>alert('Berhasil')</script>";

echo "<script>location.href='$link'</script>";
