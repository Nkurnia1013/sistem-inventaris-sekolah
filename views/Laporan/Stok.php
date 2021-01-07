<div class="row " style="zoom:85%">
    <div class="col-lg-4 col-12 mt-3">
        <form>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <select class="custom-select" name="tgl[]">
                        <?php foreach (Fungsi::$bulan as $b => $e): ?>
                        <option <?php if ($data['tgl'][0] == $b): ?> selected <?php endif;?> value="<?php echo $b; ?>">
                            <?php echo $e; ?>
                        </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <input autocomplete="off" type="number"  value="<?php echo $data['tgl'][1]; ?>" min="1970" required="" class="form-control form-control-line" name="tgl[]">
                <div class="input-group-append">
                    <input type="hidden" name="hal" value="<?php echo $_REQUEST['hal']; ?>">
                    <button type="submit" class="btn btn-primary float-right">Set</button>
                </div>
            </div>
            </form>
    </div>
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
                        <h4 class="text-center"><b><u style="text-transform: uppercase;">Laporan Stok Barang </u></b></h4>
                        <h5>
                            <table class="table table-bordered" style="width: 20%">
                                <tr>
                                    <td>Bulan</td>
                                    <td>:
                                        <?php echo Fungsi::$bulan[$data['tgl'][0]]; ?> <?php echo $data['tgl'][1]; ?>
                                    </td>
                                </tr>
                            </table>
                        </h5>
                        <center>
                            <table style="zoom:100%;width: 40%" class="table card-table table-bordered p-2 table-vcenter">
                                <thead class=" text-primary">
                                    <th>
                                        No
                                    </th>
                                    <?php foreach ($data['barang.form'] as $e): ?>
                                    <?php if ($e['tb']): ?>
                                    <th class="">
                                        <?php echo $e['label']; ?>
                                    </th>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <th>Stok</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['barang']->values() as $v => $e): ?>
                                    <tr>
                                        <td>
                                            <?php echo $v + 1; ?>
                                        </td>
                                        <?php foreach ($data['barang.form'] as $e1): ?>
                                        <?php if ($e1['tb']): ?>
                                        <td class="text-wrap">
                                            <?php $b = $e1['name'];?>
                                            <?php echo $e->$b; ?>
                                        </td>
                                        <?php endif;?>
                                        <?php endforeach;?>
                                        <td>
                                            <?php echo $e->stok; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                            </table>
                        </center>
                    </div>
                    <div class="col-1">
                    </div>
                </div>
                <?php include $komponen . '/Ttd.php';?>
            </div>
        </div>
    </div>
</div>