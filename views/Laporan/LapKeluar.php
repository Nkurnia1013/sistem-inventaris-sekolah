<div class="row " style="zoom:85%">
    <?php include $komponen . '/Filter.php';?>
    <?php if (isset($data['Request']->tgl)): ?>
    <div class="col-lg-12 col-12 mt-3">
        <div class="card" style="zoom:85%">
            <div class="card-header card-header-primary">
                <div class="d-flex  justify-content-between">
                    <h4 class="card-title ">Preview Laporan</h4>
                    <button type="button" class="btn btn-outline-dark btn-sm  " onclick="$('#print22').print();">Cetak</button>
                </div>
            </div>
            <div class="" style="zoom:100%" id="print22">
                <?php include $komponen . '/Kop.php';?>
                <div class="row ">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <br>
                        <h4 class="text-center"><b><u style="text-transform: uppercase;">Laporan Pengambilan Barang</u></b></h4>
                        <p class="p-0 m-0"><strong>Pada
                                <?php if ($data['Request']->jenis == 'bulanan'): ?>
                                <?php echo Fungsi::$bulan[$data['Request']->tgl[0]]; ?>
                                <?php endif;?>
                                <?php echo $data['Request']->tgl[1]; ?></strong></strong></p>
                        <?php $table = 'transaksi';?>
                        <?php $primary = 'idtransaksi';?>
                        <table width="100%" class="text-wrap mb-0  table table-bordered table-striped table-hover ">
                            <thead class="">
                                <tr>
                                    <th class="w-1">No</th>
                                    <th class="w-1">Tanggal</th>
                                    <th class="w-1">Oleh</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data[$table]->values() as $v => $e): ?>
                                <tr>
                                    <td>
                                        <?php echo $v + 1; ?>
                                    </td>
                                    <td>
                                        <?php echo date_format(date_create($e->tgl), 'd/m/Y'); ?>
                                    </td>
                                    <td>
                                        <?php echo $e->nama; ?>
                                        <div>NIP:
                                            <?php echo $e->nip; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php foreach ($e->detail as $k2): ?>
                                        <ul>
                                            <li>
                                                <span>
                                                    <div>
                                                        <?php echo $k2->nama_barang; ?><strong> [<?php echo $k2->qty; ?> <?php echo $k2->satuan; ?>]</strong>
                                                    </div>

                                                </span>

                                            </li>
                                        </ul>
                                        <?php endforeach;?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-1">
                    </div>
                </div>
                <?php include $komponen . '/Ttd.php';?>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>