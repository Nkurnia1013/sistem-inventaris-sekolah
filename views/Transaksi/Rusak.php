<div class="row ">
    <?php $data['table'] = 'rusak';?>
    <?php $data['primary'] = 'idrusak';?>
    <?php if (isset($Request->idalokasi)): ?>
    <div class="col-12  mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Form Input</h6>
            <div class=" card-body ">
                <form action="Action.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Ruangan</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->ruangan; ?>">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Penanggung Jawab</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->namapj; ?>">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Barang</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->nama_barang; ?>">
                                </div>
                                 <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">ID Barang</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->idbarang; ?>">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">No. Pabrik</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->nopabrik; ?>">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Merk</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->merk; ?>">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Bahan</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->bahan; ?>">
                                </div>
                                <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Ukuran</label>
                                    <input type="text" autocomplete=off  class="form-control" readonly="" value="<?php echo $data['alokasi.id']->ukuran; ?>">
                                </div>
                                  <div class="form-grup col-12 mb-2 input-group-sm">
                                    <label class="form-control-label">Foto</label>
                                    <img src="upload/<?php echo $data['alokasi.id']->foto; ?>" alt="..." id="image-preview" class="img-thumbnail">
                                    <small class="text-danger">Foto Barang</small>
                                </div>
                                <div class="modal-footer col-12  py-1">
                                    <input type="hidden" name="link" value="index.php?hal=Rusak">
                                    <input type="hidden" name="input[]" value="<?php echo $data['alokasi.id']->idalokasi; ?>">
                                    <input type="hidden" name="tb[]" value="idalokasi">
                                    <input type="hidden" name="table" value="rusak">
                                    <button type="submit" name="aksi" value="insert" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Tanggal</label>
                                <input type="date" value="<?php echo date('Y-m-d'); ?>" name="input[]" class="form-control">
                                <input type="hidden" name="tb[]" value="tgl_rusak">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">jumlah</label>
                                <input  type="number" autocomplete=off   max="<?php echo $data['alokasi.id']->jumlah - $data['rusak']->where('idalokasi', $Request->idalokasi)->sum('jum'); ?>" value="<?php echo $data['alokasi.id']->jumlah - $data['rusak']->where('idalokasi', $Request->idalokasi)->sum('jum'); ?>" name="input[]" class="form-control">
                                <input type="hidden" name="tb[]" value="jum">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Kondisi Barang</label>
                                <select class="form-control " required name="input[]">
                                    <option value="Kurang Baik">Kurang Baik</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                <input type="hidden" name="tb[]" value="kondisi">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Keterangan</label>
                                <textarea name="input[]" class="form-control"></textarea>
                                <input type="hidden" name="tb[]" value="keterangan">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Bukti</label>
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
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php $primary = 'idrusak';?>
    <div class="col-12 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Data Barang Rusak</h6>
            <table width="100%" class="text-wrap mb-0 tb table table-bordered table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">No</th>
                        <th>Ruangan</th>
                        <?php foreach ($data[$data['table'] . '.form'] as $e): ?>
                        <?php if ($e['tb']): ?>
                        <th class="">
                            <?php echo $e['label']; ?>
                        </th>
                        <?php endif;?>
                        <?php endforeach;?>
                        <th>Keterangan</th>
                        <th data-priority="1">Aksi</th>
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
                            <div>Penanggung Jawab: <strong>
                                    <?php echo $e->namapj; ?></strong></div>
                        </td>
                        <?php foreach ($data[$data['table'] . '.form'] as $e1): ?>
                        <?php if ($e1['tb']): ?>
                        <td class="text-wrap">
                            <?php $b = $e1['name'];?>
                            <?php if ($b == 'nama_barang'): ?>
                            <?php echo $e->$b; ?> [
                            <?php echo $e->idbarang; ?>]
                            <?php elseif ($b == 'jumlah'): ?>
                            <?php echo $e->$b; ?>
                            <?php echo $e->satuan; ?>
                            <?php else: ?>
                            <?php echo $e->$b; ?>
                            <?php endif;?>
                        </td>
                        <?php endif;?>
                        <?php endforeach;?>
                        <td class="text-wrap">
                            <?php echo $e->keterangan; ?>
                        </td>
                        <td class="text-right ">
                            <?php if (isset($e->bukti_rusak)): ?>
                            <a class="btn-sm btn btn-warning" target="_blank" href="upload/<?php echo $e->bukti_rusak; ?>">Bukti</a>
                            <?php endif;?>
                            <span style="display: none" id="data-<?php echo $e->$primary; ?>">
                                <?php echo json_encode($e); ?></span>
                                  <a class="mr-1 text-info" onclick="app.kd=JSON.parse($('#data-<?php echo $e->$primary; ?>').html())" data-toggle="modal" data-target="#modal-edit" href="javascript:void(0)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class=" text-danger" onclick="return confirm('Apakah anda yakin ingin hapus data ini?');" href="Action.php?aksi=delete&table=rusak&primary=<?php echo $primary; ?>&key=<?php echo $e->$primary; ?>">
                                <i class="fa fa-trash"></i>
                            </a>
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
                                <label class="form-control-label">Tanggal</label>
                                <input type="date" :value="kd.tgl_rusak" name="input[]" class="form-control">
                                <input type="hidden" name="tb[]" value="tgl_rusak">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">jumlah</label>
                                <input  type="number" autocomplete=off  :value="kd.jum" :max="parseInt(kd.sisa)+parseInt(kd.jum)" name="input[]" class="form-control">
                                <input type="hidden" name="tb[]" value="jum">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Kondisi Barang</label>
                                <select :value="kd.kondisi" class="form-control " required name="input[]">
                                    <option value="Kurang Baik">Kurang Baik</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                <input type="hidden" name="tb[]" value="kondisi">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Keterangan</label>
                                <textarea name="input[]" class="form-control">{{kd.keterangan}}</textarea>
                                <input type="hidden" name="tb[]" value="keterangan">
                            </div>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Bukti</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="input[]" id="image-source" onchange="previewImage()" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                                <div v-if="kd.bukti_rusak!=null">
                                <img :src="'upload/'+kd.bukti_rusak" alt="..." id="image-preview" class="img-thumbnail">
                                </div>
                                 <div else>
                                <img src="upload/image.png" alt="..." id="image-preview" class="img-thumbnail">
                                </div>
                            </div>
                            <div class="modal-footer col-12  py-1">
                                <input type="hidden" name="table" value="rusak">
                                <input type="hidden" name="primary" value="idrusak">
                                <input type="hidden" name="key" :value="kd.idrusak">
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