<div class="row " style="zoom:85%">
    <?php include $komponen . '/Filter.php';?>
    <?php if (isset($data['Request']->tgl)): ?>
    <div class="col-lg-12 col-12 mt-3">
        <div class="card" style="zoom:85%">
            <div class="card-header card-header-primary">
                <div class="d-flex  justify-content-between">
                    <h4 class="card-title ">Preview Laporan</h4>
                    <button type="button" class="btn btn-outline-dark btn-sm  " onclick="$('#print22').print();">Catak</button>
                </div>
            </div>
            <div class="" style="zoom:100%" id="print22">
                <?php include $komponen . '/Kop.php';?>
                <div class="row ">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <br>
                        <h4 class="text-center"><b><u>Laporan Barang Masuk</u></b></h4>
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
                                    <th class="w-1">#</th>
                                    <th class="w-1">Tanggal</th>
                                    <?php foreach ($data[$table . '.form'] as $e): ?>
                                    <?php if ($e['tb']): ?>
                                    <th class="">
                                        <?php echo $e['label']; ?>
                                    </th>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($data[$table] as $v => $e): ?>
                                <tr>
                                    <td>
                                        <?php echo $v + 1; ?>
                                    </td>
                                    <td>
                                        <?php echo date_format(date_create($e->tgl), 'd/m/Y'); ?>
                                    </td>
                                    <?php foreach ($data[$table . '.form'] as $e1): ?>
                                    <?php if ($e1['tb']): ?>
                                    <td class="text-wrap">
                                        <?php $b = $e1['name'];?>
                                        <?php echo $e->$b; ?>
                                    </td>
                                    <?php endif;?>
                                    <?php endforeach;?>
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