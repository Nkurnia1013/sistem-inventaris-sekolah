<div class="row ">
    <?php if ($data['transaksi_keluar']->status == 'Proses'): ?>
    <div class="col-12 col-lg-3 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Form Input</h6>
            <div class=" card-body ">
                <form action="Action.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Barang</label>
                            <select class="form-control " id="barang" onclick="app.barang=$('#barang option:selected').data('barang')" name="input[]">
                                <?php foreach ($data['barang']->sortBy('nama_barang') as $k => $e): ?>
                                <option data-barang='<?php echo json_encode($e); ?>' value="<?php echo $e->idbarang; ?>">
                                    <?php echo $e->nama_barang; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="idbarang">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                            <label class="form-control-label">ID Barang</label>
                            <input type="text" readonly="" :value="barang.idbarang" class="form-control">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                            <label class="form-control-label">Merk</label>
                            <input type="text" readonly="" :value="barang.merk" class="form-control">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                            <label class="form-control-label">Satuan</label>
                            <input type="text" readonly="" :value="barang.satuan" class="form-control">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Qty</label>
                            <div class="input-group ">
                                <input maxlength="9" type="text" autocomplete=off id="qty" class="form-control" aria-describedby="satuan" name="input[]">
                            </div>
                            <input type="hidden" name="tb[]" value="qty">
                        </div>
                        <div class="modal-footer col-12  py-1">
                            <input type="hidden" name="input[]" value="<?php echo $data['transaksi_keluar']->idtransaksi; ?>">
                            <input type="hidden" name="tb[]" value="idtransaksi">
                            <input type="hidden" name="cek" value="keluar">
                            <input type="hidden" name="idguru" value="<?php echo $data['transaksi_keluar']->idguru; ?>">
                            <input type="hidden" name="table" value="detail_permintaan">
                            <button type="submit" name="aksi" value="insert" class="btn btn-sm btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="col mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <div class="d-flex justify-content-between">
                <h6 class="text-dark ml-2 mt-1 pt-1">Data </h6>
                <span class="m-3">
                    <?php if ($data['transaksi_keluar']->status == 'Proses'): ?>
                    <a href="Action.php?table=transaksi_keluar&aksi=update&input[]=Menunggu&tb[]=status&input[]=<?php echo date('Y-m-d'); ?>&tb[]=tgl&primary=idtransaksi&key=<?php echo $data['transaksi_keluar']->idtransaksi; ?>&link=index.php?hal=Permintaan" class="btn btn-sm btn-primary <?php if ($data['transaksi_keluar']->detail_permintaan->isEmpty()): ?> disabled <?php endif;?>">Kirim Permintaan Ke TU</a>
                    <?php endif;?>
                </span>
            </div>
            <table width="100%" class="text-wrap mb-0 tb table table-bordered table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">No</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <?php if ($data['transaksi_keluar']->status == 'Proses'): ?>
                        <th data-priority="1">Aksi</th>
                        <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;foreach ($data['transaksi_keluar']->detail_permintaan as $k): ?>
                    <tr>
                        <td>
                            <?php echo $no++; ?>
                        </td>
                        <td>
                            <div>
                                <?php echo $k->nama_barang; ?>
                                <strong>[
                                    <?php echo $e->idbarang; ?>]</strong>
                                <div><small>Merk :<span class="text-muted">
                                            <?php echo $e->merk; ?></span></small></div>
                            </div>
                        </td>
                        <td>
                            <?php echo $k->qty; ?>
                            <?php echo $k->satuan; ?>
                        </td>
                        <?php if ($data['transaksi_keluar']->status == 'Proses'): ?>
                        <td>
                            <span style="display: none" id="data-<?php echo $k->iddetail; ?>">
                                <?php echo json_encode($k); ?></span>
                            <div class="d-flex">
                                <a class="mr-1 text-info" onclick="app.kd=JSON.parse($('#data-<?php echo $k->iddetail; ?>').html())" data-toggle="modal" data-target="#modal-edit" href="javascript:void(0)">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class=" text-danger" onclick="return confirm('Apakah anda yakin ingin hapus data ini?');" href="Action.php?aksi=delete&table=detail_permintaan&primary=iddetail&key=<?php echo $k->iddetail; ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                        <?php endif;?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade " id="modal-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog mb-5 modal-md ">
        <form action="Action.php" v-if="kd!=null" method="post" enctype="multipart/form-data">
            <div class="modal-content ">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Data</h6>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span class="text-danger">x</span>
                    </button>
                </div>
                <div class="modal-body  " style="background: rgb(240, 241, 245)">
                    <div style="zoom:85%" class="card card-body ">
                        <div class="row">
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Barang</label>
                                <input type="text" readonly="" :value="kd.nama_barang" class="form-control">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">ID Barang</label>
                                <input type="text" readonly="" :value="kd.idbarang" class="form-control">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Merk</label>
                                <input type="text" readonly="" :value="kd.merk" class="form-control">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Satuan</label>
                                <input type="text" readonly="" :value="kd.satuan" class="form-control">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Qty</label>
                                <div class="input-group mb-3">
                                    <input maxlength="9" type="text" autocomplete=off class="form-control" id="qty2" :value="kd.qty" aria-describedby="satuan1" name="input[]">
                                    <div class="input-group-append">
                                    </div>
                                </div>
                                <input type="hidden" name="tb[]" value="qty">
                            </div>
                            <div class="modal-footer col-12  py-1">
                                <input type="hidden" name="table" value="detail_permintaan">
                                <input type="hidden" name="primary" value="iddetail">
                                <input type="hidden" name="key" :value="kd.iddetail">
                                <button type="button" class="btn shadow-sm btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="aksi" value="update" class="btn shadow-sm btn-sm btn-info">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>