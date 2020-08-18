<div class="row ">
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
    <?php if (isset($Request->idruangan)): ?>
    <?php $data['table'] = 'alokasi';?>
    <?php $data['primary'] = 'idalokasi';?>
    <div class="col-12 col-lg-3 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Form Input</h6>
            <div class=" card-body ">
                <form action="Action.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <?php foreach ($data['alokasi.form'] as $isi): ?>
                        <?php if ($isi['name'] == 'idbarang'): ?>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Barang</label>
                            <select class="form-control " required name="input[]">
                                <?php foreach ($data['barang'] as $k => $e): ?>
                                    <option value="<?php echo $e->idbarang; ?>">
                                        <?php echo $e->nama_barang; ?> ||
                                        <?php echo $e->merk; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="idbarang">
                        </div>
                        <?php elseif ($isi['name'] == 'kondisi'): ?>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Kondisi Barang</label>
                            <select class="form-control " required name="input[]">
                                <option value="Baik">Baik</option>
                                <option value="Kurang Baik">Kurang Baik</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                            <input type="hidden" name="tb[]" value="kondisi">
                        </div>
                        <?php else: ?>
                        <?php include $komponen . '/Input.php';?>
                        <?php endif;?>
                        <?php endforeach;?>
                        <div class="modal-footer col-12  py-1">
                            <input type="hidden" name="input[]" value="<?php echo $Request->idruangan; ?>">
                            <input type="hidden" name="tb[]" value="idruangan">
                            <input type="hidden" name="table" value="<?php echo $data['table']; ?>">
                            <button type="submit" name="aksi" value="insert" class="btn btn-sm btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $primary = 'idalokasi';?>
    <div class="col-12 col-lg-9 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Data <small><strong><small>
                            <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->ruangan; ?></small></strong></small></h6>
            <table width="100%" class="text-wrap mb-0 tb table table-borderless table-striped table-hover ">
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
                        <th data-priority="1"></th>
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
                        <td class="text-right ">
                            <span style="display: none" id="data-<?php echo $e->$primary; ?>">
                                <?php echo json_encode($e); ?></span>
                            <a class="mr-1 text-info" onclick="app.kd=JSON.parse($('#data-<?php echo $e->$primary; ?>').html())" data-toggle="modal" data-target="#modal-edit" href="javascript:void(0)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class=" text-danger" onclick="return confirm('Apakah anda yakin ingin hapus data ini?');" href="Action.php?aksi=delete&table=<?php echo $data['table']; ?>&primary=<?php echo $primary; ?>&key=<?php echo $e->$primary; ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif;?>
</div>
<?php if (isset($Request->idruangan)): ?>
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
                            <?php foreach ($data['alokasi.form'] as $isi): ?>
                        <?php if ($isi['name'] == 'idbarang'): ?>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Barang</label>
                            <select :value="kd.idbarang" class="form-control " required name="input[]">
                                <?php foreach ($data['barang'] as $k => $v): ?>
                                <optgroup label="<?php echo $k; ?>">
                                    <?php foreach ($v as $e): ?>
                                    <option value="<?php echo $e->idbarang; ?>">
                                        <?php echo $e->nama_barang; ?> ||
                                        <?php echo $e->merk; ?>
                                    </option>
                                    <?php endforeach;?>
                                </optgroup>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="idbarang">
                        </div>
                        <?php elseif ($isi['name'] == 'kondisi'): ?>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Kondisi Barang</label>
                            <select :value="kd.kondisi" class="form-control " required name="input[]">
                                <option value="Baik">Baik</option>
                                <option value="Kurang Baik">Kurang Baik</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                            <input type="hidden" name="tb[]" value="kondisi">
                        </div>
                        <?php else: ?>
                        <?php include $komponen . '/Up.php';?>
                        <?php endif;?>
                        <?php endforeach;?>
                            <div class="modal-footer col-12  py-1">
                                <input type="hidden" name="table" value="alokasi">
                                <input type="hidden" name="primary" value="idalokasi">
                                <input type="hidden" name="key" :value="kd.idalokasi">
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
<?php endif;?>