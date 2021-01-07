<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Sistem Inventaris <small class="text-muted"><small>SMP fii sabillilah</small></small></a>
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if ($data['link'] != 'Login'): ?>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo ($data['link'] == 'Home') ? 'active' : ''; ?>">
                <a class="nav-link" href="?hal=Home"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if ($Session['admin']->level == 'TU'): ?>
            <li class="nav-item <?php if (isset($data['induk'])): ?><?php echo ($data['induk'] == 'Master') ? 'active' : ''; ?> <?php endif;?>  dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <i class="fa fa-box"></i> Master
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item <?php echo ($data['link'] == 'User') ? 'active' : ''; ?> " href="?hal=User"><i class="fa fa-user"></i> Users</a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo ($data['link'] == 'Guru') ? 'active' : ''; ?> " href="?hal=Guru"><i class="fa fa-users"></i> Guru</a>
                    </li>


                    <li>
                        <a class="dropdown-item <?php if (isset($data['induk'])): ?> <?php echo ($data['induk'] == 'Barang') ? 'active' : ''; ?> <?php endif;?>  dropdown-toggle" href="#"><i class="fa fa-boxes"></i> Barang</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?php echo ($data['link'] == 'BarangHabis') ? 'active' : ''; ?>" href="?hal=BarangHabis"><i class="fa fa-pencil-ruler"></i> Habis Pakai</a></li>
                            <li><a class="dropdown-item <?php echo ($data['link'] == 'BarangTak') ? 'active' : ''; ?>" href="?hal=BarangTak"><i class="fa fa-dolly-flatbed"></i> Tidak Habis Pakai</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo ($data['link'] == 'Ruangan') ? 'active' : ''; ?> " href="?hal=Ruangan"><i class="fa fa-school"></i> Ruangan</a>
                    </li>
                </ul>
            </li>
            <?php endif;?>
            <?php if ($Session['admin']->level == 'TU' || $Session['admin']->level == 'guru'): ?>
            <li class="nav-item dropdown <?php if (isset($data['induk'])): ?><?php echo ($data['induk'] == 'Transaksi') ? 'active' : ''; ?> <?php endif;?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if ($Session['admin']->level == 'TU'): ?><?php if ($data['minta']->isNotEmpty()): ?> <span class="badge badge-danger"><?php echo $data['minta']->count(); ?></span> <?php endif;?><?php endif;?>
                   <i class="fa fa-calendar-alt"></i> Transaksi
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?php echo ($data['link'] == 'Permintaan') ? 'active' : ''; ?>  " href="?hal=Permintaan"><?php if ($Session['admin']->level == 'TU'): ?><?php if ($data['minta']->isNotEmpty()): ?> <span class="badge badge-danger"><?php echo $data['minta']->count(); ?></span> <?php endif;?><?php endif;?> <i class="fa fa-calendar-alt"></i>Permintaan Barang Habis Pakai</a>

                    <?php if ($Session['admin']->level == 'TU'): ?>
                    <a class="dropdown-item <?php echo ($data['link'] == 'Masuk') ? 'active' : ''; ?>  " href="?hal=Masuk"><i class="fa fa-truck"></i> Barang Masuk</a>
                    <a class="dropdown-item <?php echo ($data['link'] == 'Alokasi') ? 'active' : ''; ?> " href="?hal=Alokasi"><i class="fa fa-inbox"></i>Inventaris </a>
                    <a class="dropdown-item <?php echo ($data['link'] == 'Rusak') ? 'active' : ''; ?> " href="?hal=Rusak"><i class="fa fa-exclamation-circle"></i>Barang Rusak </a>
                    <?php endif;?>
                </div>
            </li>
            <?php endif;?>
            <?php if ($Session['admin']->level == 'TU' || $Session['admin']->level == 'Kepala Sekolah'): ?>
            <li class="nav-item dropdown <?php if (isset($data['induk'])): ?><?php echo ($data['induk'] == 'Laporan') ? 'active' : ''; ?> <?php endif;?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <i class="fa fa-print"></i> Laporan
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?php if (isset($data['induk'])): ?> <?php echo ($data['induk'] == 'Laporan Barang Habis Pakai') ? 'active' : ''; ?> <?php endif;?>  dropdown-toggle" href="#">Barang Habis Pakai</a>
                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item <?php echo ($data['link'] == 'LapMasuk') ? 'active' : ''; ?>  " href="?hal=LapMasuk">Laporan Barang Masuk</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo ($data['link'] == 'LapKeluar') ? 'active' : ''; ?>  " href="?hal=LapKeluar">Laporan Pengambilan Barang</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo ($data['link'] == 'Stok') ? 'active' : ''; ?>  " href="?hal=Stok">Laporan Stok Barang</a>
                        </li>
                    </ul>
                    <a class="dropdown-item <?php if (isset($data['induk'])): ?> <?php echo ($data['induk'] == 'Laporan Barang Tidak Habis Pakai') ? 'active' : ''; ?> <?php endif;?>  dropdown-toggle" href="#">Barang Tidak Habis Pakai</a>
                    <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item <?php echo ($data['link'] == 'Inventaris2') ? 'active' : ''; ?>  " href="?hal=Inventaris2">Laporan Inventaris</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo ($data['link'] == 'LapAlokasi') ? 'active' : ''; ?>  " href="?hal=LapAlokasi">Kartu Inventaris Ruangan</a>
                        </li>
                         <li>
                            <a class="dropdown-item <?php echo ($data['link'] == 'LapRusak') ? 'active' : ''; ?>  " href="?hal=LapRusak">Laporan Barang Rusak</a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif;?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <div class="mr-3">
                   <span> Selamat datang, <strong><?php echo $Session['admin']->nama; ?></strong></span>
                   <div class="text-right"><strong ><?php echo ucfirst($Session['admin']->level); ?></strong></div>
                </div>

            </li>
            <li class="nav-item border-left border-info ">
                <a class="nav-link" href="?hal=Logout">Logout </a>
            </li>
        </ul>
        <?php else: ?>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
                <a class="nav-link" href="?hal=Login"><i class="fa fa-key"></i> Login </a>
            </li>
        </ul>
        <?php endif;?>
    </div>
</nav>