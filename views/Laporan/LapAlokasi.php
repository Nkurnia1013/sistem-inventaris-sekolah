<div class="row " style="zoom:85%">
    <div class="form-grup col-12 mb-2 input-group-sm">
        <form>
            <label class="form-control-label">Pilih Ruangan</label>
            <div class="input-group mb-3">
                <select class="form-control" name="idruangan">
                    <?php foreach ($data['ruangan'] as $e): ?>
                    <option value="<?php echo $e->idruangan; ?>">
                        <?php echo $e->ruangan; ?>
                    </option>
                    <?php endforeach;?>
                </select>
                <input type="hidden" name="hal" value="<?php echo $_REQUEST['hal']; ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Set Ruangan</button>
                </div>
            </div>
        </form>
    </div>
    <?php if (isset($data['Request']->idruangan)): ?>
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
                        <h4 class="text-center"><b><u style="text-transform: uppercase;">kartu inventaris ruangan</u></b></h4>
                        <br>
                        <br>
                        <br>
                        <p class="p-0 m-0">
                            <strong>
                            <div class="d-flex">
                                <span>Ruangan:</span>
                                <span> <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->ruangan; ?></span>
                            </div>
                            </strong>
                        </p>
                        <?php $table = 'transaksi';?>
                        <?php $primary = 'idtransaksi';?>
                        <table width="100%" class="text-wrap mb-0  table table-bordered table-striped table-hover ">
                            <thead class="">
                                <tr>
                                    <th class="w-1">No</th>
                                    <?php foreach ($data[$data['table'] . '.form'] as $e): ?>
                                    <?php if ($e['tb']): ?>
                                    <th class="">
                                        <?php echo $e['label']; ?>
                                    </th>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data[$data['table']] as $v => $e): ?>
                                <tr>
                                    <td>
                                        <?php echo $v + 1; ?>
                                    </td>
                                    <?php foreach ($data[$data['table'] . '.form'] as $e1): ?>
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