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
    public static $jenis = [
        ['name' => 'Meja', 'id' => 'MJ01'],
        ['name' => 'Kursi', 'id' => 'KS02'],
        ['name' => 'Papan Tulis', 'id' => 'PT03'],
        ['name' => 'Kipas Angin', 'id' => 'KA04'],
        ['name' => 'Lambang Negara', 'id' => 'LN05'],
        ['name' => 'Foto Presiden & Wakil', 'id' => 'FP06'],
        ['name' => 'Printer', 'id' => 'PN07'],
        ['name' => 'Gorden', 'id' => 'GN08'],
        ['name' => 'Jam Dinding', 'id' => 'JD09'],
        ['name' => 'Laptop', 'id' => 'LP010'],
        ['name' => 'Keyboard', 'id' => 'KY011'],
        ['name' => 'Komputer', 'id' => 'KP012'],
        ['name' => 'Stabilizer', 'id' => 'SZ013'],
        ['name' => 'Bendera', 'id' => 'BD014'],
        ['name' => 'Mouse', 'id' => 'MS015'],
        ['name' => 'Lemari', 'id' => 'MS015'],
    ];
    public function fields($tb)
    {

        return dd($this->Crud->getFields($tb)->toJson());
    }
    public function auto($tb)
    {

        return $this->Crud->auto($tb);
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

                $data['admin'] = collect($this->Crud->mysqli2->table('guru')->select()->where('nama', $Request->user)->where('pass', $Request->pass)->get());
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
            'icon' => 'fa-home',

        ];
        $data['transaksi_masuk'] = collect($this->Crud->mysqli2->table('transaksi_masuk')->select()->get());
        $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('detail_permintaan')->select()->join('transaksi_keluar', 'transaksi_keluar.idtransaksi', '=', 'detail_permintaan.idtransaksi')->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->map(function ($item, $key) use ($data) {
            $item->masuk = $data['transaksi_masuk']->where('idbarang', $item->idbarang)->sum('qty');
            $item->keluar = $data['transaksi_keluar']->where('idbarang', $item->idbarang)->sum('qty');

            $item->stok = $item->masuk - $item->keluar;
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
            'icon' => 'fa-user',

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
            'judul' => 'Permintaan Barang Habis Pakai',
            'path' => 'Transaksi/Permintaan',
            'induk' => 'Transaksi',
            'link' => 'Permintaan',
            'icon' => 'fa-calendar-alt',

        ];
        $Session = $_SESSION;
        // $this->fields('permintaan');

        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->get());

        $data['transaksi_masuk'] = collect($this->Crud->mysqli2->table('transaksi_masuk')->select()->get());
        $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('detail_permintaan')->select()->join('transaksi_keluar', 'transaksi_keluar.idtransaksi', '=', 'detail_permintaan.idtransaksi')->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('status', 'ACC')->where('nama', '!=', '')->get());
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get())->map(function ($item, $key) use ($data) {
            $item->masuk = $data['transaksi_masuk']->where('idbarang', $item->idbarang)->sum('qty');
            $item->keluar = $data['transaksi_keluar']->where('idbarang', $item->idbarang)->sum('qty');

            $item->stok = $item->masuk - $item->keluar;
            return $item;
        });
        $data['detail_permintaan'] = collect($this->Crud->mysqli2->table('detail_permintaan')->select()->join('barang', 'barang.idbarang', '=', 'detail_permintaan.idbarang')->get());

        if ($Session['admin']->level == 'guru') {
            $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('transaksi_keluar')->select()->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('guru.nip', $Session['admin']->nip)->where('status', '!=', 'Proses')->get())->map(function ($item) use ($data) {
                $item->detail = $data['detail_permintaan']->where('idtransaksi', $item->idtransaksi);
                return $item;
            });

        } else {
            $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('transaksi_keluar')->select()->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('status', '!=', 'Proses')->where('status', '!=', 'Dibatalkan')->where('nama', '!=', '')->get())->map(function ($item) use ($data) {
                $item->detail = $data['detail_permintaan']->where('idtransaksi', $item->idtransaksi);
                return $item;
            });

        }
        $data['barang2'] = $data['barang']->groupBy('idbarang')->toArray();

        $this->Data = $data;
    }
    public function Permintaan2()
    {
        $data = [
            'judul' => 'Permintaan Inventaris',
            'path' => 'Transaksi/Permintaan2',
            'induk' => 'Transaksi',
            'link' => 'Permintaan2',
            'icon' => 'fa-calendar-alt',

        ];
        $Session = $_SESSION;
        // $this->fields('permintaan');
        $Request = $this->Request;
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->where('status_guru', 'Wali Kelas')->get());

        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get())->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->namapj = $x->first()->nama;
            } else {
                $item->namapj = "-";

            }
            return $item;
        });
        if ($Session['admin']->level == 'guru') {
            $data['ruangan'] = $data['ruangan']->where('penanggung_jawab', $Session['admin']->nip);
        }
        $data['satuan'] = collect($this->Crud->mysqli2->table('satuan')->select()->get());
        $data['merk'] = collect($this->Crud->mysqli2->table('merk')->select()->get());
        $data['bahan'] = collect($this->Crud->mysqli2->table('bahan')->select()->get());
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get());
        if (isset($Request->idruangan)) {
            $data['permintaan_btp'] = collect($this->Crud->mysqli2->table('permintaan_btp')->select()->join('barang', 'barang.idbarang', '=', 'permintaan_btp.idbarang')->join('ruangan', 'ruangan.idruangan', '=', 'permintaan_btp.idruangan')->join('merk', 'merk.idmerk', '=', 'permintaan_btp.idmerk')->join('bahan', 'bahan.idbahan', '=', 'permintaan_btp.idbahan')->where('ruangan.idruangan', $Request->idruangan)->get());
        }

        $this->Data = $data;
    }
    public function AddPermintaan()
    {
        $data = [
            'judul' => 'Permintaan Barang',
            'path' => 'Transaksi/DetailPermintaan',
            'induk' => 'Transaksi',
            'link' => 'AddPermintaan',

        ];
        $Session = $_SESSION;
        // $this->fields('permintaan');

        $data['transaksi_masuk'] = collect($this->Crud->mysqli2->table('transaksi_masuk')->select()->get());
        $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('detail_permintaan')->select()->join('transaksi_keluar', 'transaksi_keluar.idtransaksi', '=', 'detail_permintaan.idtransaksi')->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('nama', '!=', '')->where('status', 'ACC')->get());
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get())->map(function ($item, $key) use ($data) {
            $item->masuk = $data['transaksi_masuk']->where('idbarang', $item->idbarang)->sum('qty');
            $item->keluar = $data['transaksi_keluar']->where('idbarang', $item->idbarang)->sum('qty');
            $item->stok = $item->masuk - $item->keluar;
            return $item;
        });
        $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('transaksi_keluar')->select()->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('guru.nip', $Session['admin']->nip)->where('status', 'Proses')->get());
        if ($data['transaksi_keluar']->isEmpty()) {
            $this->Crud->mysqli2->table('transaksi_keluar')->insert(['nip' => $Session['admin']->nip])->execute();
        }
        $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('transaksi_keluar')->select()->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('guru.nip', $Session['admin']->nip)->where('status', 'Proses')->get())->first();
        $data['transaksi_keluar']->detail_permintaan = collect($this->Crud->mysqli2->table('detail_permintaan')->select()->join('barang', 'barang.idbarang', '=', 'detail_permintaan.idbarang')->where('idtransaksi', $data['transaksi_keluar']->idtransaksi)->get());

        $this->Data = $data;
    }
    public function Ruangan()
    {
        $data = [
            'judul' => 'Data Ruangan',
            'path' => 'Master/Ruangan',
            'induk' => 'Master',
            'link' => 'Ruangan',
            'icon' => 'fa-school',

        ];
        $fields1 = '[
                {"name":"idruangan","label":"ID Ruangan","type":"text","max":"5","pnj":12,"val":null,"red":"readonly","input":true,"up":true,"tb":true},

                {"name":"ruangan","label":"Ruangan","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"penanggung_jawab","label":"Penanggung Jawab","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true}
                ]';
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->get());

        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get())->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->nama = $x->first()->nama;
            } else {
                $item->nama = "-";

            }
            return $item;
        });
        $last = $data['ruangan']->last();
        if (is_null($last)) {
            $num = sprintf("%'03d", 1);
        } else {

            $num = sprintf("%'03d", intval(substr($last->idruangan, -3)) + 1);

        }

        $data['ruangan.form'] = json_decode($fields1, true);
        $data['ruangan.form'][0]['val'] = "R" . $num;

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
                {"name":"nopabrik","label":"No Pabrik","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},

                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},

                {"name":"jumlah","label":"jumlah","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"}

                ]';
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->where('status_guru', 'Wali Kelas')->get());
        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get())->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->nama = $x->first()->nama;
            } else {
                $item->nama = "-";

            }
            return $item;
        });
        $data['rusak'] = collect($this->Crud->mysqli2->table('rusak')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get())->groupBy('kategori');
        if (isset($this->Request->idruangan)) {
            $data['idruangan'] = $this->Request->idruangan;
            $data['alokasi'] = collect($this->Crud->mysqli2->table('alokasi')->select()->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->join('ruangan', 'ruangan.idruangan', '=', 'alokasi.idruangan')->where('kondisi', '!=', 'Rusak Berat')->where('alokasi.idruangan', $data['idruangan'])->get())->where('nama_barang', '!=', '')->map(function ($item) use ($data) {
                $item->jumlah = $item->jumlah - $data['rusak']->where('idalokasi', $item->idalokasi)->sum('jum');
                return $item;
            });

        }

        $data['alokasi.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Inventaris2()
    {
        $data = [
            'judul' => 'Laporan Inventaris',
            'path' => 'Laporan/Inventaris',
            'induk' => 'Laporan Barang Tidak Habis Pakai',
            'link' => 'Inventaris2',
            'Request' => $this->Request,

        ];
        $Request = $this->Request;
        //$this->fields('alokasi');
        $tgl = date('Y-m-d');
        $fields1 = '[
                {"name":"nama_barang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"merk","label":"Merk","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"jumlah","label":"jumlah","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nopabrik","label":"No Pabrik","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"}

                ]';
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->where('status_guru', 'Wali Kelas')->get());
        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get())->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->nama = $x->first()->nama;
            } else {
                $item->nama = "-";

            }
            return $item;
        });

        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->where('status_guru', 'Wali Kelas')->get());
        $data['rusak'] = collect($this->Crud->mysqli2->table('rusak')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get())->groupBy('kategori');
        $data['alokasi'] = collect($this->Crud->mysqli2->table('alokasi')->select([new Ex('*'), new Ex('month(tgl_input) as bln'), new Ex('year(tgl_input) as thn')])->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->join('ruangan', 'ruangan.idruangan', '=', 'alokasi.idruangan')->get())->where('nama_barang', '!=', '')->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->namapj = $x->first()->nama;
            } else {
                $item->namapj = "-";

            }
            $item->jumlah = $item->jumlah - $data['rusak']->where('idalokasi', $item->idalokasi)->sum('jum');

            return $item;
        });
        if (isset($Request->tgl)) {
            $tgl = $Request->tgl;
            $data['alokasi'] = $data['alokasi']->where('thn', $tgl[1]);
            if ($Request->jenis == 'bulanan') {
                $data['alokasi'] = $data['alokasi']->where('bln', $tgl[0]);
            }
        }

        $data['alokasi.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function LapRusak()
    {
        $data = [
            'judul' => 'Laporan Barang Rusak',
            'path' => 'Laporan/LapRusak',
            'induk' => 'Laporan Barang Tidak Habis Pakai',
            'link' => 'LapRusak',
            'Request' => $this->Request,

        ];
        //$this->fields('alokasi');
        $Request = $this->Request;
        $tgl = date('Y-m-d');
        $fields1 = '[
                {"name":"nama_barang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"merk","label":"Merk","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"jum","label":"jumlah","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nopabrik","label":"No Pabrik","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"}

                ]';
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->where('status_guru', 'Wali Kelas')->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get())->groupBy('kategori');
        $data['alokasi'] = collect($this->Crud->mysqli2->table('alokasi')->select([new Ex('*'), new Ex('month(tgl_rusak) as bln'), new Ex('year(tgl_rusak) as thn')])->join('rusak', 'rusak.idalokasi', '=', 'alokasi.idalokasi')->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->join('ruangan', 'ruangan.idruangan', '=', 'alokasi.idruangan')->get())->where('nama_barang', '!=', '')->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->namapj = $x->first()->nama;
            } else {
                $item->namapj = "-";

            }
            return $item;
        })->where('idrusak', '!=', '');
        if (isset($Request->tgl)) {
            $tgl = $Request->tgl;
            $data['alokasi'] = $data['alokasi']->where('thn', $tgl[1]);
            if ($Request->jenis == 'bulanan') {
                $data['alokasi'] = $data['alokasi']->where('bln', $tgl[0]);
            }
        }

        $data['alokasi.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Alokasi()
    {
        $data = [
            'judul' => 'Data Inventaris',
            'path' => 'Transaksi/Alokasi',
            'induk' => 'Transaksi',
            'link' => 'Alokasi',
            'icon' => 'fa-inbox',

        ];
        //$this->fields('alokasi');
        $tgl = date('Y-m-d');
        $fields1 = '[
                {"name":"nama_barang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"merk","label":"Merk","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},

                {"name":"nopabrik","label":"No Pabrik","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kondisi","label":"Kondisi Barang","type":"text","max":"20","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
                {"name":"jumlah","label":"jumlah","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get());
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->where('status_guru', 'Wali Kelas')->get());
        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get())->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->nama = $x->first()->nama;
            } else {
                $item->nama = "-";

            }
            return $item;
        });

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get());
        $data['rusak'] = collect($this->Crud->mysqli2->table('rusak')->select()->get());
        if (isset($this->Request->idruangan)) {
            $data['idruangan'] = $this->Request->idruangan;
            $data['alokasi'] = collect($this->Crud->mysqli2->table('alokasi')->select()->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->join('ruangan', 'ruangan.idruangan', '=', 'alokasi.idruangan')->where('ruangan.idruangan', $data['idruangan'])->get())->where('nama_barang', '!=', '')->map(function ($item) use ($data) {
                $item->rusak = $data['rusak']->where('idalokasi', $item->idalokasi);
                $item->jumrusak = $item->rusak->sum('jum');
                return $item;

            });

        }

        $data['alokasi.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Rusak()
    {
        $data = [
            'judul' => 'Data Barang Rusak',
            'path' => 'Transaksi/Rusak',
            'induk' => 'Transaksi',
            'link' => 'Rusak',
            'icon' => 'fa-exclamation-circle',

        ];
        //$this->fields('alokasi');
        $tgl = date('Y-m-d');
        $fields1 = '[
                {"name":"nopabrik","label":"No Pabrik","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"idbarang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"merk","label":"Merk","type":"number","max":null,"pnj":12,"val":null,"red":"required","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"ukuran","label":"Ukuran","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"jum","label":"Jumlah","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kondisi","label":"Kondisi","type":"number","max":null,"pnj":12,"val":null,"red":"required min=1","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['guru'] = collect($this->Crud->mysqli2->table('guru')->select()->where('status_guru', 'Wali Kelas')->get());
        $data['ruangan'] = collect($this->Crud->mysqli2->table('ruangan')->select()->get())->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->nama = $x->first()->nama;
            } else {
                $item->nama = "-";

            }
            return $item;
        });

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get());
        $data['alokasi'] = collect($this->Crud->mysqli2->table('alokasi')->select()->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->join('ruangan', 'ruangan.idruangan', '=', 'alokasi.idruangan')->get())->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->namapj = $x->first()->nama;
            } else {
                $item->namapj = "-";

            }
            return $item;
        });
        if (isset($this->Request->idalokasi)) {
            $data['alokasi.id'] = $data['alokasi']->where('idalokasi', $this->Request->idalokasi)->first();
        }
        $data['rusak'] = collect($this->Crud->mysqli2->table('alokasi')->select()->join('rusak', 'rusak.idalokasi', '=', 'alokasi.idalokasi')->join('barang', 'barang.idbarang', '=', 'alokasi.idbarang')->join('ruangan', 'ruangan.idruangan', '=', 'alokasi.idruangan')->get())->where('nama_barang', '!=', '')->map(function ($item) use ($data) {
            $x = $data['guru']->where('nip', $item->penanggung_jawab);
            if ($x->isNotEmpty()) {
                $item->namapj = $x->first()->nama;
            } else {
                $item->namapj = "-";

            }
            return $item;
        })->where('idrusak', '!=', '');
        $data['rusak'] = $data['rusak']->map(function ($item) use ($data) {
            $item->sisa = $item->jumlah - $data['rusak']->where('idalokasi', $item->idalokasi)->sum('jum');
            return $item;

        });
        $data['rusak.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Guru()
    {
        $data = [
            'judul' => 'Data Guru',
            'path' => 'Master/Guru',
            'induk' => 'Master',
            'link' => 'Guru',
            'icon' => 'fa-users',

        ];
        $fields1 = '[
                {"name":"nip","label":"NIP / UNPTK","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"pass","label":"Password","type":"password","max":"16","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false},
                {"name":"nama","label":"Nama Lengkap","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"tgl_lahir","label":"Tanggal Lahir","type":"date","max":"12","pnj":12,"val":null,"red":" required","input":true,"up":true,"tb":true},
                {"name":"alamat","label":"Alamat","type":"textarea","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"nohp","label":"No HP","type":"text","max":"12","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"status_guru","label":"Status","type":"number","max":"12","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"status_kawin","label":"Status Kawin","type":"text","max":"6","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true}
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
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},

                {"name":"merk","label":"Merk","type":"text","max":"30","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"satuan","label":"Satuan","type":"text","max":"8","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['barang.form'] = json_decode($fields1, true);

        $data['transaksi_masuk'] = collect($this->Crud->mysqli2->table('transaksi_masuk')->select()->get());
        $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('detail_permintaan')->select()->join('transaksi_keluar', 'transaksi_keluar.idtransaksi', '=', 'detail_permintaan.idtransaksi')->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('nama', '!=', '')->where('status', 'ACC')->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get())->map(function ($item, $key) use ($data) {
            $item->masuk = $data['transaksi_masuk']->where('idbarang', $item->idbarang)->sum('qty');
            $item->keluar = $data['transaksi_keluar']->where('idbarang', $item->idbarang)->sum('qty');

            $item->stok = $item->masuk - $item->keluar;
            return $item;
        });
        $data['barang.form'][0]['val'] = "BR" . sprintf("%'03d", $data['barang']->count() + 1);
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
                {"name":"jenis","label":"Jenis Barang","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},

                {"name":"idbarang","label":"ID Barang","type":"text","max":"7","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"merk","label":"Merk","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"bahan","label":"Bahan","type":"text","max":"30","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nopabrik","label":"No. Pabrik","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"foto","label":"Foto","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}


                ]';
        $data['barang.form'] = json_decode($fields1, true);
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Tidak')->get())->sortBy('idbarang');
        $data['huruf'] = range('A', 'Z');
        $data['jenis'] = collect(json_decode(json_encode($this::$jenis)))->map(function ($item, $key) use ($data) {
            $br = $data['barang']->where('jenis', $item->name);
            if ($br->isNotEmpty()) {
                $br = $br->sortBy('idbarang')->last();

                $no = intval(substr($br->idbarang, -3)) + 1;
            } else {
                $no = 1;

            }
            $urut = $data['huruf'][$key] . sprintf("%'03d", $no);
            $item->id = "$item->id-$urut";
            return $item;
        })->sortBy('name');

        $this->Data = $data;
    }
    public function Masuk()
    {
        $data = [
            'judul' => 'Data Barang Masuk',
            'path' => 'Transaksi/Masuk',
            'induk' => 'Transaksi',
            'link' => 'Masuk',
            'icon' => 'fa-truck',
        ];
        $data['primary'] = 'idtransaksi';
        $data['table'] = 'transaksi_masuk';
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"text","max":9,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data[$data['table'] . '.form'] = json_decode($fields1, true);
        $data['tgl'] = date('Y-m-d');

        if (isset($this->Request->tgl)) {
            $data['tgl'] = $this->Request->tgl;

        }

        $data[$data['table']] = collect($this->Crud->mysqli2->table($data['table'])->select()->join('barang', 'barang.idbarang', '=', 'transaksi_masuk.idbarang')->where('tgl', $data['tgl'])->get());
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
            $data['transaksi_masuk'] = $this->Crud->mysqli2->table('transaksi_masuk')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi_masuk.idbarang')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            $data['transaksi_keluar'] = $this->Crud->mysqli2->table('transaksi_keluar')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('detail_permintaan', 'detail_permintaan.idtransaksi', '=', 'transaksi_keluar.idtransaksi')->join('barang', 'barang.idbarang', '=', 'detail_permintaan.idbarang')->where('status', 'Acc')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi_masuk'] = $data['transaksi_masuk']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
                $data['transaksi_keluar'] = $data['transaksi_keluar']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
            }
            $data['transaksi_keluar'] = collect($data['transaksi_keluar']->get());
            $data['transaksi_masuk'] = collect($data['transaksi_masuk']->get());
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


                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);
        if (isset($data['Request']->tgl)) {
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi_masuk')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi_masuk.idbarang')->where('nama_barang', '!=', '')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
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

        if (isset($data['Request']->tgl)) {
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi_keluar')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('status', 'ACC')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi'] = $data['transaksi']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
            }
            $data['detail_permintaan'] = collect($this->Crud->mysqli2->table('detail_permintaan')->select()->join('barang', 'barang.idbarang', '=', 'detail_permintaan.idbarang')->get());

            $data['transaksi'] = collect($data['transaksi']->get())->where('nama', '!=', '')->map(function ($item) use ($data) {
                $item->detail = $data['detail_permintaan']->where('idtransaksi', $item->idtransaksi);
                return $item;
            });
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
        $Request = $this->Request;
        $fields1 = '[

                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['barang.form'] = json_decode($fields1, true);
        $data['transaksi_masuk'] = collect($this->Crud->mysqli2->table('transaksi_masuk')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->get());
        $data['transaksi_keluar'] = collect($this->Crud->mysqli2->table('detail_permintaan')->select([new Ex('*'), new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('transaksi_keluar', 'transaksi_keluar.idtransaksi', '=', 'detail_permintaan.idtransaksi')->join('guru', 'guru.nip', '=', 'transaksi_keluar.nip')->where('nama', '!=', '')->where('status', 'ACC')->get());
        $tgl[0] = date('n');
        $tgl[1] = date('Y');
        if (isset($Request->tgl)) {
            $tgl = $Request->tgl;
            $data['transaksi_masuk'] = $data['transaksi_masuk']->where('bln', '<=', $tgl[0])->where('thn', '<=', $tgl[1]);
            $data['transaksi_keluar'] = $data['transaksi_keluar']->where('bln', '<=', $tgl[0])->where('thn', '<=', $tgl[1]);
        }
        $data['tgl'] = $tgl;
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->where('habisPakai', 'Ya')->get())->map(function ($item, $key) use ($data) {
            $item->masuk = $data['transaksi_masuk']->where('idbarang', $item->idbarang)->sum('qty');
            $item->keluar = $data['transaksi_keluar']->where('idbarang', $item->idbarang)->sum('qty');

            $item->stok = $item->masuk - $item->keluar;
            return $item;
        });

        $this->Data = $data;
    }

}
