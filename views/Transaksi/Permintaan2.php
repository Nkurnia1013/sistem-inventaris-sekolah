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
    <?php $data['table'] = 'permintaan_btp';?>

    <?php $data['primary'] = 'idpermintaan';?>
    <?php if ($Session['admin']->level == 'guru'): ?>

    <div class="col-12 col-lg-3 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Form Input</h6>
            <div class=" card-body ">
                <form action="Action.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Barang</label>
                            <select class="form-control " required name="input[]">
                                <?php foreach ($data['barang'] as $k => $e): ?>
                                <option value="<?php echo $e->idbarang; ?>">
                                    <?php echo $e->nama_barang; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="idbarang">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Merk</label>
                            <select class="form-control " required name="input[]">
                                <?php foreach ($data['merk'] as $k => $e): ?>
                                <option value="<?php echo $e->idmerk; ?>">
                                    <?php echo $e->merk; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="idmerk">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Bahan</label>
                            <select class="form-control " required name="input[]">
                                <?php foreach ($data['bahan'] as $k => $e): ?>
                                <option value="<?php echo $e->idbahan; ?>">
                                    <?php echo $e->bahan; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name="tb[]" value="idbahan">
                        </div>

                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Jumlah</label>
                            <input name="input[]" class="form-control" autocomplete=off maxlength="9" type="text" autocomplete=off  >
                            <input type="hidden" name="tb[]" value="jum">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Ukuran</label>
                            <input name="input[]" maxlength="30" class="form-control" type="text" autocomplete=off >
                            <input type="hidden" name="tb[]" value="ukuran">
                        </div>
                        <div class="form-grup col-12 mb-2 input-group-sm">
                            <label class="form-control-label">Alasan</label>
                            <textarea name="input[]" maxlength="100" class="form-control"></textarea>
                            <input type="hidden" name="tb[]" value="alasan">
                        </div>
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
    <?php endif;?>

    <?php $primary = 'idalokasi';?>
    <div class="col mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h6 class="text-dark ml-2 mt-1 pt-1">Data Permintaan Inventaris<strong><small>
                        <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->ruangan; ?></small></strong></h6>
                             <h6 class="text-muted ml-2 mt-0 pt-0"><small>Penanggung Jawab : <strong> <?php echo $data['ruangan']->where('idruangan', $Request->idruangan)->first()->namapj; ?></small></strong></h6>
            <table width="100%" class="text-wrap mb-0 tb table table-bordered table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">No</th>
                        <th>Barang</th>
                        <th>Ukuran</th>
                        <th>Jumlah</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th data-priority="1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data[$data['table']]->values() as $v => $e): ?>
                    <tr>
                        <td>
                            <?php echo $v + 1; ?>
                        </td>
                          <td class="text-wrap">
                            <?php echo $e->nama_barang; ?>
                            <div class="text-muted">
                            <div>Merk: <?php echo $e->merk; ?></div>
                            <div>Bahan: <?php echo $e->bahan; ?></div>
                            </div>
                        </td>
                         <td class="text-wrap">
                            <?php echo $e->ukuran; ?>
                        </td>
                         <td class="text-wrap">
                            <?php echo $e->jum; ?>
                        </td>
                        <td class="text-wrap">
                            <?php echo $e->alasan; ?>
                        </td>
                        <td class="text-wrap">
                            <?php echo $e->status; ?>
                        </td>
                        <td class="text-right ">
                            <?php if ($Session['admin']->level == 'guru'): ?>
                            <?php if (!in_array($e->status, ['Dibatalkan', 'ACC', 'Ditolak'])): ?>
                            <a class="btn-sm btn-danger btn" href="Action.php?aksi=update&table=permintaan_btp&primary=idpermintaan&key=<?php echo $e->idpermintaan; ?>&input[]=Dibatalkan&tb[]=status">Batalkan</a>
                            <?php endif;?>
                            <?php else: ?>
                            <?php if (!in_array($e->status, ['Dibatalkan'])): ?>
                            <a class="btn-sm btn-success btn" href="Action.php?aksi=update&table=permintaan_btp&primary=idpermintaan&key=<?php echo $e->idpermintaan; ?>&input[]=ACC&tb[]=status">ACC</a>
                            <a class="btn-sm btn-warning btn" href="Action.php?aksi=update&table=permintaan_btp&primary=idpermintaan&key=<?php echo $e->idpermintaan; ?>&input[]=Ditolak&tb[]=status">Tolak</a>
                            <?php endif;?>
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif;?>
</div>