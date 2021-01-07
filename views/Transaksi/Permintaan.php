<div class="row ">
    <div class="col mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <div class="d-flex justify-content-between">
                <h6 class="text-dark ml-2 mt-1 pt-1">Data </h6>
                <span class="m-3">
                    <?php if ($Session['admin']->level == 'guru'): ?>
                    <a href="?hal=AddPermintaan" class="btn btn-sm btn-primary <?php if ($data['transaksi_keluar']->where('status', 'Menunggu')->isNotEmpty()): ?> disabled <?php endif;?>">Ajukan Permintaan</a>
                    <?php endif;?>
                </span>
            </div>
            <table width="100%" class="text-wrap mb-0 tb table table-bordered table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">No</th>
                        <?php if ($Session['admin']->level != 'guru'): ?>
                        <th>Oleh</th>
                        <?php endif;?>
                        <th>ID Transaksi</th>
                        <th>Tanggal Permintaan</th>
                        <th>Detail Barang</th>
                        <th>Status</th>
                        <th data-priority="1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;foreach ($data['transaksi_keluar'] as $k): ?>
                    <tr>
                        <td>
                            <?php echo $no++; ?>
                        </td>
                        <?php if ($Session['admin']->level != 'guru'): ?>
                        <td>
                            <?php echo $k->nama; ?>
                            <div>NIP:
                                <?php echo $k->nip; ?>
                            </div>
                        </td>
                        <?php endif;?>
                        <td>
                            <?php echo "TK" . sprintf("%'03d", $k->idtransaksi); ?>
                        </td>
                        <td>
                            <?php echo $k->tgl; ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" data-target='#det-<?php echo $k->idtransaksi; ?>' data-toggle="collapse">Detail</button>
                            <div class="list-group collapse" id="det-<?php echo $k->idtransaksi; ?>">
                                <?php foreach ($k->detail as $k2): ?>
                                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span>
                                        <div>
                                            <?php echo $k2->nama_barang; ?>
                                        </div>
                                        <?php if (array_key_exists($k2->idbarang, $data['barang2'])): ?>

                                        <div>Stok saat ini: <?php echo $data['barang2'][$k2->idbarang][0]->stok; ?></div>
                                        <?php endif;?>


                                    </span>
                                    <span>
                                        <span class="badge badge-info" style="zoom:130%">
                                            <?php echo $k2->qty; ?> <?php echo $k2->satuan; ?></span>
                                    </span>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </td>
                        <td>
                            <?php echo $k->status; ?>
                        </td>
                        <td class="text-right ">
                            <?php if ($Session['admin']->level == 'guru'): ?>
                            <?php if (!in_array($k->status, ['Dibatalkan', 'ACC', 'Ditolak'])): ?>
                            <a class="btn-sm btn-danger btn" href="Action.php?aksi=update&table=transaksi_keluar&primary=idtransaksi&key=<?php echo $k->idtransaksi; ?>&input[]=Dibatalkan&tb[]=status">Batalkan</a>
                            <?php endif;?>
                            <?php else: ?>
                            <?php if (!in_array($k->status, ['Dibatalkan'])): ?>
                            <a class="btn-sm btn-success btn" href="Action.php?aksi=update&table=transaksi_keluar&primary=idtransaksi&key=<?php echo $k->idtransaksi; ?>&input[]=ACC&tb[]=status">ACC</a>
                            <a class="btn-sm btn-warning btn" href="Action.php?aksi=update&table=transaksi_keluar&primary=idtransaksi&key=<?php echo $k->idtransaksi; ?>&input[]=Ditolak&tb[]=status">Tolak</a>
                            <?php endif;?>
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>