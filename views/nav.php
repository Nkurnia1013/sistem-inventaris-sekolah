<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Sistem Inventaris <small class="text-muted"><small>SMP fii sabillilah</small></small></a>
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <?php if ($data['link'] != 'Login'): ?>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo ($data['link'] == 'Home') ? 'active' : ''; ?>">
                <a class="nav-link" href="?hal=Home">Home <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item <?php if (isset($data['induk'])): ?><?php echo ($data['induk'] == 'Master') ? 'active' : ''; ?> <?php endif;?>  dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Master
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?php echo ($data['link'] == 'User') ? 'active' : ''; ?> " href="?hal=User">Users</a>
                    <a class="dropdown-item <?php echo ($data['link'] == 'Barang') ? 'active' : ''; ?> " href="?hal=Barang">Barang</a>
                </div>
            </li>
             <li class="nav-item dropdown <?php if (isset($data['induk'])): ?><?php echo ($data['induk'] == 'Transaksi') ? 'active' : ''; ?> <?php endif;?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Transaksi
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?php echo ($data['link'] == 'Masuk') ? 'active' : ''; ?>  " href="?hal=Masuk">Barang Masuk</a>
                    <a class="dropdown-item <?php echo ($data['link'] == 'Keluar') ? 'active' : ''; ?> " href="?hal=Keluar">Barang Keluar</a>
                </div>
            </li>
            <li class="nav-item dropdown <?php if (isset($data['induk'])): ?><?php echo ($data['induk'] == 'Laporan') ? 'active' : ''; ?> <?php endif;?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Laporan
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?php echo ($data['link'] == 'Inventaris') ? 'active' : ''; ?>  " href="?hal=Inventaris">Laporan Inventaris</a>
                    <a class="dropdown-item <?php echo ($data['link'] == 'LapMasuk') ? 'active' : ''; ?>  " href="?hal=LapMasuk">Laporan Barang Masuk</a>
                    <a class="dropdown-item <?php echo ($data['link'] == 'LapKeluar') ? 'active' : ''; ?>  " href="?hal=LapKeluar">Laporan Barang Keluar</a>
                    <a class="dropdown-item <?php echo ($data['link'] == 'Stok') ? 'active' : ''; ?>  " href="?hal=Stok">Laporan Stok Barang</a>
                </div>
            </li>



        </ul>
         <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
                <a class="nav-link" href="?hal=Logout">Logout </a>
            </li>
        </ul>
          <?php else: ?>
             <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
                <a class="nav-link" href="?hal=Logout">Login </a>
            </li>
        </ul>
                                <?php endif;?>

    </div>
</nav>
