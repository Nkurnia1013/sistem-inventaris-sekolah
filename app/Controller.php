<?php

/**
 *
 */
use ClanCats\Hydrahon\Query\Expression as Ex;

class Controller
{
    public $Request;
    public $Data;
    public $Crud;
    public function __construct($Request)
    {
        $this->Crud = Crud::idupin();

        $this->Request = json_decode(json_encode($Request));
        $hal = $this->Request->hal;
        $this->$hal();

    }
    public function fields($tb)
    {

        return dd($this->Crud->getFields($tb)->toJson());
    }
    public function Login()
    {
        $data = [
            'judul' => 'Login',
            'path' => 'Login',
            'link' => 'Login',

        ];
        $Request = $this->Request;
        $this->Data = $data;
        if (isset($Request->login)) {
            $data['admin'] = collect($this->Crud->mysqli2->table('user')->select()->where('user', $Request->user)->where('pass', $Request->pass)->get());
            if ($data['admin']->isEmpty()) {

                $data['admin'] = collect($this->Crud->mysqli2->table('guru')->select()->where('nip', $Request->user)->where('pass', $Request->pass)->get());
                if ($data['admin']->isEmpty()) {
                    echo "<script>alert('Maaf, Username atau Password yang anda inputkan salah');</script>";
                    echo "<script>location.href = '?hal=Login';</script>";
                    die();

                } else {
                    $_SESSION['admin'] = $data['admin']->first();
                    $_SESSION['admin']->level = 'guru';
                    echo "<script>alert('Berhasil');</script>";
                    echo "<script>location.href = '?hal=Home';</script>";
                    die();
                }

            } else {
                $_SESSION['admin'] = $data['admin']->first();

                echo "<script>alert('Berhasil');</script>";
                echo "<script>location.href = '?hal=Home';</script>";
                die();
            }

        }
    }
    public function Logout()
    {
        session_destroy();
        echo "<script>alert('Berhasil');</script>";
        echo "<script>location.href = '?hal=Login';</script>";
        die();
    }

    public function Home()
    {
        $data = [
            'judul' => 'Home',
            'path' => 'Home',
            'link' => 'Home',

        ];
        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->map(function ($item, $key) use ($data) {
            $ts = $data['transaksi']->where('idbarang', $item->idbarang);
            $item->masuk = $ts->where('jenis', 'Masuk')->sum('qty');
            $item->keluar = $ts->where('jenis', 'Keluar')->sum('qty');

            $item->stok = $ts->where('jenis', 'Masuk')->sum('qty') - $ts->where('jenis', 'Keluar')->sum('qty');
            return $item;
        });

        $this->Data = $data;
    }
    public function User()
    {
        $data = [
            'judul' => 'Data User',
            'path' => 'Master/User',
            'induk' => 'Master',
            'link' => 'User',

        ];
        $fields1 = '[
                {"name":"user","label":"Username","type":"text","max":"10","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"pass","label":"Password","type":"password","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false},
                {"name":"nama","label":"Nama Lengkap","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"level","label":"Level Akses","type":"select","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true}
                ]';
        $data['user'] = collect($this->Crud->mysqli2->table('user')->select()->get());

        $data['user.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Permintaan()
    {
        $data = [
            'judul' => 'Permintaan Barang',
            'path' => 'Transaksi/Permintaan',
            'induk' => 'Transaksi',
            'link' => 'Permintaan',

        ];
        $Session = $_SESSION;
        // $this->fields('permintaan');
        $fields1 = '[
               {"name":"tgl","label":"Tanggal","type":"date","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},

               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"textarea","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);

        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get());
        if ($Session['admin']->level == 'guru') {
            $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->join('guru', 'guru.nip', '=', 'transaksi.nip')->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Keluar')->where('guru.nip', $Session['admin']->nip)->get());

        } else {
            $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->join('guru', 'guru.nip', '=', 'transaksi.nip')->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Keluar')->get());

        }

        $this->Data = $data;
    }
    public function Ruangan()
    {
        $data = [
            'judul' => 'Data Ruangan',
            'path' => 'Master/Ruangan',
            'induk' => 'Master',
            'link' => 'Ruangan',

        ];
        $fields1 = '[
                {"name":"ruangan","label":"Ruangan","type":"text","max":"16","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true}
                ]';
        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get());

        $data['ruangan.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function LapAlokasi()
    {
        $data = [
            'judul' => 'Kartu Inventaris Ruangan',
            'path' => 'Laporan/LapAlokasi',
            'induk' => 'Laporan Barang Tidak Habis Pakai',
            'link' => 'LapAlokasi',
            'Request' => $this->Request,

        ];
        //$this->fields('alokasi');
        $tgl = date('Y-m-d');
        $fields1 = '[
                {"name":"nama_barang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"merk","label":"Merk","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"jumlah","label":"jumlah","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"noPabrik","label":"No Pabrik","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kondisi","label":"Kondisi Barang","type":"text","max":"20","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"}

                ]';
        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get())->groupBy('kategori');
        if (isset($this->Request->idruangan)) {
            $data['idruangan'] = $this->Request->idruangan;
            $data['alokasi'] = collect($this->Crud->mysqli2->table('alokasi')->select()->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->where('idruangan', $data['idruangan'])->get());

        }

        $data['alokasi.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Alokasi()
    {
        $data = [
            'judul' => 'Alokasi Barang ke Ruangan',
            'path' => 'Transaksi/Alokasi',
            'induk' => 'Transaksi',
            'link' => 'Alokasi',

        ];
        //$this->fields('alokasi');
        $tgl = date('Y-m-d');
        $fields1 = '[
                {"name":"noPabrik","label":"No Pabrik","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kondisi","label":"Kondisi Barang","type":"text","max":"20","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"merk","label":"Merk","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"jumlah","label":"jumlah","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get());
        if (isset($this->Request->idruangan)) {
            $data['idruangan'] = $this->Request->idruangan;
            $data['alokasi'] = collect($this->Crud->mysqli2->table('alokasi')->select()->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->where('idruangan', $data['idruangan'])->get());

        }

        $data['alokasi.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Guru()
    {
        $data = [
            'judul' => 'Data Guru',
            'path' => 'Master/Guru',
            'induk' => 'Master',
            'link' => 'Guru',

        ];
        $fields1 = '[
                {"name":"nip","label":"NIP / UNPTK / NIK","type":"text","max":"16","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"pass","label":"Password","type":"password","max":"16","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false},
                {"name":"nama","label":"Nama Lengkap","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"alamat","label":"Alamat","type":"textarea","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"nohp","label":"No HP","type":"number","max":"12","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true}
                ]';
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->get());

        $data['guru.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function BarangHabis()
    {
        $data = [
            'judul' => 'Data Barang Habis Pakai',
            'path' => 'Master/BarangHabis',
            'induk' => 'Barang',
            'link' => 'BarangHabis',
        ];
        //$this->fields('barang');
        $fields1 = '[
                {"name":"idbarang","label":"ID Barang","type":"text","max":"7","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},


                {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"satuan","label":"Satuan","type":"text","max":"15","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},

                {"name":"deskripsi","label":"Deskripsi","type":"textarea","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"jatah","label":"Jatah Bulanan","type":"number","max":null,"pnj":12,"val":0,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}


                ]';
        $data['barang.form'] = json_decode($fields1, true);

        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get())->map(function ($item, $key) use ($data) {
            $ts = $data['transaksi']->where('idbarang', $item->idbarang);
            $item->stok = $ts->where('jenis', 'Masuk')->sum('qty') - $ts->where('jenis', 'Keluar')->where('status', 'ACC')->sum('qty');
            return $item;
        });

        $this->Data = $data;
    }
    public function BarangTak()
    {
        $data = [
            'judul' => 'Data Barang Tidak Habis Pakai',
            'path' => 'Master/BarangTak',
            'induk' => 'Barang',
            'link' => 'BarangTak',
        ];
        //$this->fields('barang');
        $fields1 = '[
                {"name":"idbarang","label":"ID Barang","type":"text","max":"7","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},


                {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"deskripsi","label":"Deskripsi","type":"textarea","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}


                ]';
        $data['barang.form'] = json_decode($fields1, true);

        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get());

        $this->Data = $data;
    }
    public function Masuk()
    {
        $data = [
            'judul' => 'Data Barang Masuk',
            'path' => 'Transaksi/Masuk',
            'induk' => 'Transaksi',
            'link' => 'Masuk',
        ];
        $data['primary'] = 'idtransaksi';
        $data['table'] = 'transaksi';
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data[$data['table'] . '.form'] = json_decode($fields1, true);
        $data['tgl'] = date('Y-m-d');

        if (isset($this->Request->tgl)) {
            $data['tgl'] = $this->Request->tgl;

        }
        $data[$data['table']] = collect($this->Crud->mysqli2->table($data['table'])->select()->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Masuk')->where('tgl', $data['tgl'])->get());
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get());

        $this->Data = $data;
    }
    public function Keluar()
    {
        $data = [
            'judul' => 'Pengambilan Barang',
            'path' => 'Transaksi/Keluar',
            'induk' => 'Transaksi',
            'link' => 'Keluar',
        ];
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);
        $data['tgl'] = date('Y-m-d');

        if (isset($this->Request->tgl)) {
            $data['tgl'] = $this->Request->tgl;

        }
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->get());

        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->join('guru', 'guru.nip', '=', 'transaksi.nip')->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Keluar')->where('tgl', $data['tgl'])->get());
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->groupBy('kategori');

        $this->Data = $data;
    }
    public function Inventaris()
    {
        $data = [
            'judul' => 'Laporan Inventaris',
            'path' => 'Laporan/Inventaris',
            'induk' => 'Laporan Barang Habis Pakai',
            'link' => 'Inventaris',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},


               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"deskripsi","label":"Deskripsi","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['barang.form'] = json_decode($fields1, true);
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get());
        if (isset($data['Request']->tgl)) {
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi'] = $data['transaksi']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
            }
            $data['transaksi'] = collect($data['transaksi']->get());
        }

        $this->Data = $data;
    }
    public function LapMasuk()
    {
        $data = [
            'judul' => 'Laporan Barang Masuk',
            'path' => 'Laporan/LapMasuk',
            'induk' => 'Laporan Barang Habis Pakai',
            'link' => 'LapMasuk',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
                {"name":"idbarang","label":"ID Barang","type":"number","max":"7","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},


               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);
        if (isset($data['Request']->tgl)) {
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Masuk')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi'] = $data['transaksi']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
            }
            $data['transaksi'] = collect($data['transaksi']->get())->sortBy('tgl');
        }

        $this->Data = $data;
    }
    public function LapKeluar()
    {
        $data = [
            'judul' => 'Laporan Pengambilan Barang',
            'path' => 'Laporan/LapKeluar',
            'induk' => 'Laporan Barang Habis Pakai',
            'link' => 'LapKeluar',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
                {"name":"idbarang","label":"ID Barang","type":"number","max":"7","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},


               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"status","label":"Status","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);
        if (isset($data['Request']->tgl)) {
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->join('guru', 'guru.nip', '=', 'transaksi.nip')->where('jenis', 'Keluar')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi'] = $data['transaksi']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
            }
            $data['transaksi'] = collect($data['transaksi']->get())->sortBy('tgl');
        }

        $this->Data = $data;
    }
    public function Stok()
    {
        $data = [
            'judul' => 'Laporan Stok',
            'path' => 'Laporan/Stok',
            'induk' => 'Laporan Barang Habis Pakai',
            'link' => 'Stok',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
                {"name":"idbarang","label":"ID Barang","type":"number","max":"7","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},

               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"deskripsi","label":"Deskripsi","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['barang.form'] = json_decode($fields1, true);
        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get())->map(function ($item, $key) use ($data) {
            $ts = $data['transaksi']->where('idbarang', $item->idbarang);
            $item->stok = $ts->where('jenis', 'Masuk')->sum('qty') - $ts->where('jenis', 'Keluar')->where('status', 'ACC')->sum('qty');
            return $item;
        });

        $this->Data = $data;
    }

}
