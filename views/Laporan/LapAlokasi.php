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
                    <div class="col-12">
                        <br>
                        <h4 class="text-center"><b><u style="text-transform: uppercase;">kartu inventaris ruangan</u></b></h4>
                        <br>
                        <br>
                        <br>
                        <table class="table table-bordered" style="width: 20%">
                            <tr>
                                <th>Ruangan </th>
                                <th>
                                    <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->ruangan; ?>
                                </th>
                            </tr>
                            <tr>
                                <th>Penanggung Jawab </th>
                                <th>
                                    <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->nama; ?>
                                </th>
                            </tr>
                        </table>
                        <?php $table = 'transaksi';?>
                        <?php $primary = 'idtransaksi';?>
                        <table width="100%" class="text-nowrap mb-0  table table-bordered table-striped table-hover ">
                            <thead class="">
                                <tr>
                                    <th rowspan="2" class="w-1"> No Urut </th>
                                    <th rowspan="2" class="w-1"> Nama Barang / Jenis Barang </th>
                                    <th rowspan="2" class="w-1"> Merk/Model </th>
                                    <th rowspan="2" class="w-1"> No. Seri Pabrik </th>
                                    <th rowspan="2" class="w-1"> Ukuran </th>
                                    <th rowspan="2" class="w-1"> Bahan </th>
                                    <th rowspan="2" class="w-1"> Kode Barang </th>
                                    <th rowspan="2" class="w-1"> Jumlah Barang </th>

                                    <th class="text-center" colspan="3">Kondisi Barang</th>
                                    <th rowspan="2" class="w-1">Sumber Dana</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Baik</th>
                                    <th class="text-center">Kurang Baik</th>
                                    <th class="text-center">Rusak Berat</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($data[$data['table']]->where('jumlah', '>', 0)->values() as $v => $e): ?>
                                <tr>
                                    <td class="text-center">
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
                                        <?php echo $e->sumber_dana; ?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="row mt-5 mb-3">
                    <div class="col-6">
                        <table align="center">
                            <tr>
                                <td class="text-left">
                                    <p class="m-0 p-0">Mengetahui,</p>
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <p class="m-0 p-0">Kepala Sekolah</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                    <br>

                                    Seska Widiyanti, S,E
                                    <hr class="my-0 py-0 border-dark border">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table align="center">
                            <tr>
                                <td class="text-left"> <b> Dumai,
                                        <?php echo Fungsi::hariini(); ?></b></td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <p class="m-0 p-0">Penanggung Jawab:</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <br>
                                    <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->nama; ?>

                                    <hr class="my-0 py-0 border-dark border">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>