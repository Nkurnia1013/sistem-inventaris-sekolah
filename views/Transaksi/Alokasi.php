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
                        <div class="col-12">
                            <div class="row">
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Barang</label>
                                    <select class="form-control" onclick="app.barang=$('#barang option:selected').data('barang')" id="barang" required name="input[]">
                                        <?php foreach ($data['barang']->groupBy('jenis') as $k => $e2): ?>
                                        <optgroup label="<?php echo $k; ?>">
                                            <?php foreach ($e2 as $e): ?>
                                            <option data-barang='<?php echo json_encode($e); ?>' value="<?php echo $e->idbarang; ?>">
                                                <?php echo $e->nama_barang; ?>
                                                <?php endforeach;?>
                                            </option>
                                        </optgroup>
                                        <?php endforeach;?>
                                    </select>
                                    <input type="hidden" name="tb[]" value="idbarang">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                    <label class="form-control-label">ID Barang</label>
                                    <input maxlength="30" readonly="" id="idbarang" :value="barang.idbarang" class="form-control" type="text" autocomplete=off>
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                    <label class="form-control-label">Merk</label>
                                    <input maxlength="30" readonly id="merk" :value="barang.merk" class="form-control" type="text" autocomplete=off>
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                    <label class="form-control-label">Bahan</label>
                                    <input maxlength="30" readonly id="bahan" :value="barang.bahan" class="form-control" type="text" autocomplete=off>
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                    <label class="form-control-label">No. Pabrik</label>
                                    <input maxlength="30" readonly id="nopabrik" :value="barang.nopabrik" class="form-control" type="text" autocomplete=off>
                                </div>
                                  <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                    <label class="form-control-label">Ukuran</label>
                                    <input maxlength="30" readonly  :value="barang.ukuran" class="form-control" type="text" autocomplete=off>
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Kondisi Barang</label>
                                    <select class="form-control " required name="input[]">
                                        <option value="Baik">Baik</option>
                                        <option value="Kurang Baik">Kurang Baik</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                    <input type="hidden" name="tb[]" value="kondisi">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Jumlah</label>
                                    <input name="input[]" required="" onkeypress="return onlyNumberKey(event)" class="form-control" maxlength="9" type="text" autocomplete=off>
                                    <input type="hidden" name="tb[]" value="jumlah">
                                </div>

                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Sumber Dana</label>
                                    <input type="text" name="input[]" class="form-control">
                                    <input type="hidden" name="tb[]" value="sumber_dana">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Foto</label>
                                    <div v-if="barang!=null">
                                        <img :src="'upload/'+barang.foto" alt="..." id="image-preview" class="img-thumbnail">
                                    </div>
                                    <div v-else>
                                        <img src="upload/image.png" alt="..." id="image-preview" class="img-thumbnail">
                                    </div>
                                    <small class="text-danger">Foto Barang</small>
                                </div>
                                <div class="modal-footer col-12  py-1">
                                    <input type="hidden" name="input[]" value="<?php echo $Request->idruangan; ?>">
                                    <input type="hidden" name="tb[]" value="idruangan">
                                    <input type="hidden" name="table" value="<?php echo $data['table']; ?>">
                                    <button type="submit" name="aksi" value="insert" class="btn btn-sm btn-primary">Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $primary = 'idalokasi';?>
    <div class="col-12 col-lg-9 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Data Inventaris<strong><small>
                        <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->ruangan; ?></small></strong></h6>
            <h6 class="text-muted ml-2 mt-0 pt-0"><small>Penanggung Jawab : <strong>
                        <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->nama; ?></small></strong></h6>
            <table width="100%" class="text-nowrap mb-0 tb table table-bordered table-striped table-hover ">
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
                        <th>Sumber Dana</th>
                        <th data-priority="1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data[$data['table']]->values() as $v => $e): ?>
                    <tr>
                        <td>
                            <?php echo $v + 1; ?>
                        </td>
                        <?php foreach ($data[$data['table'] . '.form'] as $e1): ?>
                        <?php if ($e1['tb']): ?>
                        <td class="text-wrap">
                            <?php $b = $e1['name'];?>
                            <?php if ($b == 'nama_barang'): ?>
                            <?php echo $e->$b; ?> [
                            <?php echo $e->idbarang; ?>]
                            <?php elseif ($b == 'jumlah'): ?>
                            Jumlah Awal:
                            <?php echo $e->$b; ?>
                            <?php if ($e->rusak->isNotEmpty()): ?>
                            <div>Rusak:</div>
                            <ul>
                                <?php foreach ($e->rusak as $k): ?>
                                <li>
                                    <?php echo $k->tgl_rusak; ?> [
                                    <?php echo $k->jum; ?> ]
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <div>Sisa:
                                <?php echo $e->$b - $e->rusak->sum('jum'); ?>
                            </div>
                            <?php endif;?>
                            <?php else: ?>
                            <?php echo $e->$b; ?>
                            <?php endif;?>
                        </td>
                        <?php endif;?>
                        <?php endforeach;?>
                        <td class="text-wrap">
                            <?php echo $e->sumber_dana; ?>
                        </td>
                        <td class="text-right ">
                            <?php if (isset($e->bukti)): ?>
                            <a class="btn-sm btn btn-warning" target="_blank" href="upload/<?php echo $e->bukti; ?>">Bukti</a>
                            <?php endif;?>
                            <span style="display: none" id="data-<?php echo $e->$primary; ?>">
                                <?php echo json_encode($e); ?></span>
                            <a class="mr-1 text-info" onclick="app.kd=JSON.parse($('#data-<?php echo $e->$primary; ?>').html())" data-toggle="modal" data-target="#modal-edit" href="javascript:void(0)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class=" text-danger" onclick="return confirm('Apakah anda yakin ingin hapus data ini?');" href="Action.php?aksi=delete&table=<?php echo $data['table']; ?>&primary=<?php echo $primary; ?>&key=<?php echo $e->$primary; ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a class="mr-1 btn btn-sm btn-primary" onclick="app.kd=JSON.parse($('#data-<?php echo $e->$primary; ?>').html())" data-toggle="modal" data-target="#modal-det" href="javascript:void(0)">
                                Detail
                            </a>
                            <a class="btn btn-warning btn-sm" href="?idalokasi=<?php echo $e->idalokasi; ?>&hal=Rusak">Rusak</a>
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
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Barang</label>
                                <input maxlength="30" readonly="" :value="kd.nama_barang" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                <label class="form-control-label">ID Barang</label>
                                <input maxlength="30" readonly="" :value="kd.idbarang" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                <label class="form-control-label">Merk</label>
                                <input maxlength="30" readonly :value="kd.merk" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                <label class="form-control-label">Bahan</label>
                                <input maxlength="30" readonly :value="kd.bahan" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                <label class="form-control-label">No. Pabrik</label>
                                <input maxlength="30" readonly :value="kd.nopabrik" class="form-control" type="text" autocomplete=off>
                            </div>
                               <div class="form-grup col-12 mb-2 input-group-sm" v-if="barang!=null">
                                    <label class="form-control-label">Ukuran</label>
                                    <input maxlength="30" readonly  :value="kd.ukuran" class="form-control" type="text" autocomplete=off>
                                </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Kondisi Barang</label>
                                <select class="form-control " required name="input[]">
                                    <option value="Baik">Baik</option>
                                    <option value="Kurang Baik">Kurang Baik</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                <input type="hidden" name="tb[]" value="kondisi">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Jumlah</label>
                                <input :value="kd.jumlah" :min="kd.jumrusak" name="input[]" required="" onkeypress="return onlyNumberKey(event)" class="form-control" type="number">
                                <input type="hidden" name="tb[]" value="jumlah">
                            </div>

                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Sumber Dana</label>
                                <input type="text" :value="kd.sumber_dana" name="input[]" class="form-control">
                                <input type="hidden" name="tb[]" value="sumber_dana">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Foto</label>
                                <img :src="'upload/'+kd.foto" alt="..." id="image-preview2" class="img-thumbnail">
                                <small class="text-danger">Foto Barang</small>
                            </div>
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
<div class="modal fade " id="modal-det" tabindex="-1" role="dialog">
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
                                <input :value="kd.nama_barang" maxlength="30" readonly="" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">ID Barang</label>
                                <input :value="kd.idbarang" maxlength="30" readonly="" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">No. Pabrik</label>
                                <input :value="kd.nopabrik" maxlength="30" readonly class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Kondisi Barang</label>
                                <input :value="kd.kondisi" maxlength="30" readonly="" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Merk</label>
                                <input :value="kd.merk" maxlength="30" readonly="" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Bahan</label>
                                <input :value="kd.bahan" maxlength="30" readonly="" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Jumlah</label>
                                <input :value="kd.jumlah" name="input[]" readonly required="" class="form-control" type="number">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Ukuran</label>
                                <input :value="kd.ukuran" name="input[]" readonly="" maxlength="30" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Sumber Dana</label>
                                <input :value="kd.sumber_dana" maxlength="30" readonly="" class="form-control" type="text" autocomplete=off>
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Foto</label>
                                <img :src="'upload/'+kd.foto" alt="..." id="image-preview2" class="img-thumbnail">
                                <small class="text-danger">Foto Barang</small>
                            </div>
                            <div class="modal-footer col-12  py-1">
                                <input type="hidden" name="table" value="alokasi">
                                <input type="hidden" name="primary" value="idalokasi">
                                <input type="hidden" name="key" :value="kd.idalokasi">
                                <button type="button" class="btn shadow-sm btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif;?>