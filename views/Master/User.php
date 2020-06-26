<div class="row ">
    <div class="col-12 col-lg-3 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Form Input</h6>
            <div class=" card-body ">
                <form action="Action.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <?php foreach ($data['user.form'] as $isi): ?>
                        <?php if ($isi['name'] == 'level'): ?>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Level</label>
                            <select name="input[]" class="form-control ">
                                <option value="Admin">Admin</option>
                                <option value="Kepala Sekolah">Kepala Sekolah</option>
                            </select>
                            <input type="hidden" name="tb[]" value="level">
                        </div>
                        <?php else: ?>
                        <?php include $komponen . '/Input.php';?>
                        <?php endif;?>
                        <?php endforeach;?>
                        <div class="modal-footer col-12  py-1">
                            <input type="hidden" name="table" value="user">
                            <button type="submit" value="insert" name="aksi" class="btn btn-sm btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-9 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Data</h6>
            <table width="100%" class="text-wrap mb-0 tb table table-borderless table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">#</th>
                        <?php foreach ($data['user.form'] as $e): ?>
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
                    <?php foreach ($data['user'] as $v => $e): ?>
                    <tr>
                        <td>
                            <?php echo $v + 1; ?>
                        </td>
                        <?php foreach ($data['user.form'] as $e1): ?>
                        <?php if ($e1['tb']): ?>
                        <td class="text-wrap">
                            <?php $b = $e1['name'];?>
                            <?php echo $e->$b; ?>
                        </td>
                        <?php endif;?>
                        <?php endforeach;?>
                        <td class="text-right ">
                            <span style="display: none" id="data-<?php echo $e->user; ?>">
                                <?php echo json_encode($e); ?></span>
                            <a class="mr-1 text-info" onclick="app.kd=JSON.parse($('#data-<?php echo $e->user; ?>').html())" data-toggle="modal" data-target="#modal-edit" href="javascript:void(0)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class=" text-danger" onclick="return confirm('Apakah anda yakin ingin hapus data ini?');" href="Action.php?aksi=delete&table=user&primary=user&key=<?php echo $e->user; ?>">
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
                            <?php foreach ($data['user.form'] as $isi): ?>
                            <?php if ($isi['name'] == 'level'): ?>
                            <div class="form-grup col-12 mb-2 input-group-sm">
                                <label class="form-control-label">Level</label>
                                <select v-model="kd.level" name="input[]" class="form-control ">
                                    <option value="Admin">Admin</option>
                                    <option value="Kepala Sekolah">Kepala Sekolah</option>
                                </select>
                                <input type="hidden" name="tb[]" value="level">
                            </div>
                            <?php else: ?>
                            <?php include $komponen . '/Up.php';?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <div class="modal-footer col-12  py-1">
                                <input type="hidden" name="table" value="user">
                                <input type="hidden" name="primary" value="user">
                                <input type="hidden" name="key" :value="kd.user">
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
