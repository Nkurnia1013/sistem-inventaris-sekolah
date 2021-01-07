<div class="row " style="zoom:85%">
  <?php include $komponen . '/Filter.php';?>
    <?php if (isset($data['Request']->tgl)): ?>
    <?php $data['table'] = 'alokasi';?>
    <?php $data['primary'] = 'idalokasi';?>
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
                        <h4 class="text-center"><b><u style="text-transform: uppercase;"><?php echo $data['judul']; ?></u></b></h4>
                        <br>
                        <br>
                        <br>

                        <?php $table = 'transaksi';?>
                        <?php $primary = 'idtransaksi';?>
 <p class="p-0 m-0"><strong>Pada <?php if ($data['Request']->jenis == 'bulanan'): ?> <?php echo Fungsi::$bulan[$data['Request']->tgl[0]]; ?> <?php endif;?> <?php echo $data['Request']->tgl[1]; ?></strong></strong></p>

                       <table width="100%" class="text-wrap mb-0  table table-bordered table-striped table-hover ">
                            <thead class="">
                                <tr>
                                    <th rowspan="2" class="w-1">No</th>
                                    <th rowspan="2">Ruangan</th>
                                    <?php foreach ($data[$data['table'] . '.form'] as $e): ?>
                                    <?php if ($e['tb']): ?>
                                    <th rowspan="2" class="">
                                        <?php echo $e['label']; ?>
                                    </th>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <th class="text-center" colspan="3">Kondisi Barang</th>
                                    <th rowspan="2" class="w-1">Keterangan</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Baik</th>
                                    <th class="text-center">Kurang Baik</th>
                                    <th class="text-center">Rusak Berat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data[$data['table']]->values() as $v => $e): ?>
                                <tr>
                                    <td>
                                        <?php echo $v + 1; ?>
                                    </td>
                                       <td>
                            <?php echo $e->ruangan; ?>
                            <div>Penanggung Jawab: <strong><?php echo $e->namapj; ?></strong></div>
                        </td>
                                    <?php foreach ($data[$data['table'] . '.form'] as $e1): ?>
                                    <?php if ($e1['tb']): ?>
                                    <td class="text-wrap">
                                        <?php $b = $e1['name'];?>
                                        <?php echo $e->$b; ?>
                                    </td>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <td class="text-center">
                                        <?php if ($e->kondisi == 'Baik'): ?>
                                        <span class="fa fa-check"></span>
                                        <?php endif;?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($e->kondisi == 'Kurang Baik'): ?>
                                        <span class="fa fa-check"></span>
                                        <?php endif;?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($e->kondisi == 'Rusak Berat'): ?>
                                        <span class="fa fa-check"></span>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <?php echo $e->keterangan; ?>
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