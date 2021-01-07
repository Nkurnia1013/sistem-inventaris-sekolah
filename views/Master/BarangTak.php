<div class="row ">
    <div class="col-12 col-lg-3 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Form Input</h6>
            <div class=" card-body ">
                <form action="Action.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Jenis Barang</label>
                            <select id="jenis" onclick="barang('jenis','idbarang')" class="form-control" name="input[]">
                                <?php foreach ($data['jenis'] as $k): ?>
                                <option data-kode="<?php echo $k->id; ?>" value="<?php echo $k->name; ?>">
                                    <?php echo $k->name; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="jenis">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">ID Barang</label>
                            <input type="text" autocomplete=off  readonly="" value="<?php echo $data['jenis']->first()->id; ?>" id="idbarang" name="input[]" class="form-control">
                            <input type="hidden" name="tb[]" value="idbarang">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Nama Barang</label>
                            <input type="text" autocomplete=off  name="input[]" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="nama_barang">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Merk</label>
                            <input type="text" autocomplete=off  name="input[]" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="merk">
                        </div>
                         <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label"> Bahan</label>
                            <input type="text" autocomplete=off  name="input[]" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="bahan">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">No. Pabrik</label>
                            <input type="text" autocomplete=off  name="input[]" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="nopabrik">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Ukuran</label>
                            <input type="text" autocomplete=off  name="input[]" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="ukuran">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Foto</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="input[]" id="image-source" onchange="previewImage()" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                            <img src="upload/image.png" alt="..." id="image-preview" class="img-thumbnail">
                            <small class="text-danger">Foto Barang</small>
                        </div>
                        <div class="modal-footer col-12  py-1">
                            <input type="hidden" name="table" value="barang">
                            <input type="hidden" name="input[]" value="Tidak">
                            <input type="hidden" name="tb[]" value="habisPakai">
                            <button type="submit" name="aksi" value="insert" class="btn btn-sm btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-9 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Data</h6>
            <table width="100%" class="text-wrap mb-0 tb table table-bordered table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">No</th>
                        <?php foreach ($data['barang.form'] as $e): ?>
                        <?php if ($e['tb']): ?>
                        <th class="">
                            <?php echo $e['label']; ?>
                        </th>
                        <?php endif;?>
                        <?php endforeach;?>
                        <th data-priority="1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['barang']->values() as $v => $e): ?>
                    <tr>
                        <td>
                            <?php echo $v + 1; ?>
                        </td>
                        <?php foreach ($data['barang.form'] as $e1): ?>
                        <?php if ($e1['tb']): ?>
                        <?php if ($e1['name'] == 'jatah'): ?>
                        <?php elseif ($e1['name'] == 'foto'): ?>
                        <td>
                            <img width="200" src="upload/<?php echo $e->foto; ?>" alt="..." class="img-thumbnail">
                        </td>
                        <?php else: ?>
                        <td class="text-wrap">
                            <?php $b = $e1['name'];?>
                            <?php echo $e->$b; ?>
                        </td>
                        <?php endif;?>
                        <?php endif;?>
                        <?php endforeach;?>
                        <td class="text-right ">
                            <span style="display: none" id="data-<?php echo $e->idbarang; ?>">
                                <?php echo json_encode($e); ?></span>
                            <div class="d-flex">
                                <a class="mr-1 text-info" onclick="app.kd=JSON.parse($('#data-<?php echo $e->idbarang; ?>').html())" data-toggle="modal" data-target="#modal-edit" href="javascript:void(0)">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class=" text-danger" onclick="return confirm('Apakah anda yakin ingin hapus data ini?');" href="Action.php?aksi=delete&table=barang&primary=idbarang&key=<?php echo $e->idbarang; ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
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
                                <label class="form-control-label">Jenis Barang</label>
                                <select id="jenis2" onclick="barang('jenis2','idbarang2')" class="form-control" name="input[]">
                                    <?php foreach ($data['jenis'] as $k): ?>
                                    <option data-kode="<?php echo $k->id; ?>" value="<?php echo $k->name; ?>">
                                        <?php echo $k->name; ?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                                <input type="hidden" name="tb[]" value="jenis">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">ID Barang</label>
                                <input type="text" autocomplete=off  readonly="" id="idbarang2" :value="kd.idbarang" name="input[]" class="form-control">
                                <input type="hidden" name="tb[]" value="idbarang">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Nama Barang</label>
                                <input type="text" autocomplete=off  name="input[]" :value="kd.nama_barang" maxlength="30" class="form-control">
                                <input type="hidden" name="tb[]" value="nama_barang">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">No. Pabrik</label>
                                <input type="text" autocomplete=off  name="input[]" :value="kd.nopabrik" maxlength="30" class="form-control">
                                <input type="hidden" name="tb[]" value="nopabrik">
                            </div>
                             <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Merk</label>
                            <input type="text" autocomplete=off  name="input[]" :value="kd.merk" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="merk">
                        </div>
                         <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label"> Bahan</label>
                            <input type="text" autocomplete=off  name="input[]" :value="kd.bahan" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="bahan">
                        </div>
                         <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Ukuran</label>
                            <input type="text" autocomplete=off  name="input[]" :value="kd.ukuran" maxlength="30" class="form-control">
                            <input type="hidden" name="tb[]" value="ukuran">
                        </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Foto</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="input[]" id="image-source2" onchange="previewImage2()" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                                <img :src="'upload/'+kd.foto" alt="..." id="image-preview2" class="img-thumbnail">
                                <small class="text-danger">Foto Barang</small>
                            </div>
                            <div class="modal-footer col-12  py-1">
                                <input type="hidden" name="table" value="barang">
                                <input type="hidden" name="primary" value="idbarang">
                                <input type="hidden" name="key" :value="kd.idbarang">
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