<div class="row ">
    <?php $table = 'transaksi';?>
    <?php $primary = 'idtransaksi';?>
    <?php if ($Session['admin']->level == 'guru'): ?>
    <div class="col-12 col-lg-3 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Form Input</h6>
            <div class=" card-body ">
                <form action="Action.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <?php foreach ($data['transaksi.form'] as $isi): ?>
                        <?php if ($isi['name'] == 'idbarang'): ?>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Barang</label>
                            <select class="form-control " id="barang" onclick="$('#satuan').html($('#barang option:selected').data('satuan'))"  name="input[]">
                                <?php foreach ($data['barang'] as $k => $e): ?>
                                <option data-satuan="<?php echo $e->satuan; ?>" value="<?php echo $e->idbarang; ?>">
                                    <?php echo $e->nama_barang; ?> ||
                                    <?php echo $e->merk; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="idbarang">
                        </div>
                        <?php elseif ($isi['name'] == 'qty'): ?>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">
                                <?php echo $isi['label']; ?></label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" aria-describedby="satuan" name="input[]">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="satuan"></span>
                                </div>
                            </div>
                            <input type="hidden" name="tb[]" value="<?php echo $isi['name']; ?>">
                        </div>
                        <?php else: ?>
                        <?php include $komponen . '/Input.php';?>
                        <?php endif;?>
                        <?php endforeach;?>
                        <div class="modal-footer col-12  py-1">
                            <input type="hidden" name="input[]" value="Keluar">
                            <input type="hidden" name="tb[]" value="jenis">
                            <input type="hidden" name="input[]" value="<?php echo $Session['admin']->nip; ?>">
                            <input type="hidden" name="tb[]" value="nip">
                            <input type="hidden" name="cek" value="keluar">
                            <input type="hidden" name="table" value="<?php echo $table; ?>">
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
            <h6 class="text-dark ml-2 mt-1 pt-1">Data </h6>
            <table width="100%" class="text-wrap mb-0 tb table table-borderless table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">No</th>
                        <?php if ($Session['admin']->level != 'guru'): ?>
                        <th>Oleh</th>
                        <?php endif;?>
                        <?php foreach ($data[$table . '.form'] as $e): ?>
                        <?php if ($e['tb']): ?>
                        <th class="">
                            <?php echo $e['label']; ?>
                        </th>
                        <?php endif;?>
                        <?php endforeach;?>
                        <th>Status</th>
                        <th data-priority="1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data[$table] as $v => $e): ?>
                    <tr>
                        <td>
                            <?php echo $v + 1; ?>
                        </td>
                        <?php if ($Session['admin']->level != 'guru'): ?>
                        <td>
                            <?php echo $e->nama; ?>
                            <div>NIP:
                                <?php echo $e->nip; ?>
                            </div>
                        </td>
                        <?php endif;?>
                        <?php foreach ($data[$table . '.form'] as $e1): ?>
                        <?php if ($e1['tb']): ?>
                        <td class="text-wrap">
                            <?php $b = $e1['name'];?>
                            <?php echo $e->$b; ?>
                        </td>
                        <?php endif;?>
                        <?php endforeach;?>
                        <td>
                            <?php echo $e->status; ?>
                        </td>
                        <td class="text-right ">
                            <?php if ($Session['admin']->level == 'guru'): ?>
                            <?php if (!in_array($e->status, ['Dibatalkan', 'ACC', 'Ditolak'])): ?>
                            <a class="btn-sm btn-danger btn" href="Action.php?aksi=update&table=transaksi&primary=idtransaksi&key=<?php echo $e->idtransaksi; ?>&input[]=Dibatalkan&tb[]=status">Batalkan</a>
                            <?php endif;?>
                            <?php else: ?>
                            <a class="btn-sm btn-success btn" href="Action.php?aksi=update&table=transaksi&primary=idtransaksi&key=<?php echo $e->idtransaksi; ?>&input[]=ACC&tb[]=status">ACC</a>
                            <a class="btn-sm btn-warning btn" href="Action.php?aksi=update&table=transaksi&primary=idtransaksi&key=<?php echo $e->idtransaksi; ?>&input[]=Ditolak&tb[]=status">Tolak</a>
                            <?php endif;?>
                        </td>
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
                                <label class="form-control-label">Guru</label>
                                <select :value="kd.nip" class="form-control " name="input[]">
                                    <?php foreach ($data['guru'] as $k => $e): ?>
                                    <option value="<?php echo $e->nip; ?>">
                                        <?php echo $e->nip; ?> ||
                                        <?php echo $e->nama; ?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                                <input type="hidden" name="tb[]" value="nip">
                            </div>
                            <?php foreach ($data['transaksi.form'] as $isi): ?>
                            <?php if ($isi['name'] == 'idbarang'): ?>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Barang</label>
                                <select :value="kd.idbarang" class="form-control multi" name="akses[]">
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
                            </div>
                            <?php else: ?>
                            <?php include $komponen . '/Up.php';?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <div class="modal-footer col-12  py-1">
                                <input type="hidden" name="table" value="transaksi">
                                <input type="hidden" name="primary" value="idtransaksi">
                                <input type="hidden" name="key" :value="kd.idtransaksi">
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