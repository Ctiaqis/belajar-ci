<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashData('failed')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<p>History Transaksi Pembelian</p>
<hr>

<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID Pembelian</th>
            <th scope="col">Pembeli</th>
            <th scope="col">Waktu Pembelian</th>
            <th scope="col">Total Bayar</th>
            <th scope="col">Alamat</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($transactions)) : ?>
            <?php foreach ($transactions as $index => $transaction) : ?>
                <tr>
                    <th scope="row"><?= $index + 1 ?></th>
                    <td><?= $transaction['id'] ?></td>
                    <td><?= $transaction['username'] ?></td>
                    <td><?= $transaction['created_at'] ?></td>
                    <td><?= number_to_currency($transaction['total_harga'], 'IDR') ?></td>
                    <td><?= $transaction['alamat'] ?></td>
                    <td>
                        <?php if ($transaction['status'] == 0) : ?>
                            <span class="badge bg-warning text-dark">Belum Selesai</span>
                        <?php else : ?>
                            <span class="badge bg-primary">Sudah Selesai</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $transaction['id'] ?>">
                            Detail
                        </button>

                        <a href="<?= base_url('pembelian/status/' . $transaction['id']) ?>"
                            class="btn btn-info btn-sm"
                            onclick="return confirm('Yakin ingin mengubah status pesanan ini?')">
                            Ubah Status
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php if (!empty($transactions)) : ?>
    <?php foreach ($transactions as $transaction) : ?>
        <div class="modal fade" id="detailModal-<?= $transaction['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Detail Transaksi #<?= $transaction['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <?php if (!empty($products[$transaction['id']])) : ?>
                            <?php foreach ($products[$transaction['id']] as $index => $product) : ?>
                                <div class="mb-3">
                                    <p><?= $index + 1 ?>)</p>

                                    <img src="<?= base_url() . 'img/' . $product['foto'] ?>" width="80px" class="mb-2">

                                    <p class="mb-1">
                                        <strong><?= $product['nama'] ?></strong>
                                        <?= number_to_currency($product['harga'], 'IDR') ?>
                                    </p>

                                    <p class="mb-1">
                                        (<?= $product['jumlah'] ?> pcs)
                                    </p>

                                    <p class="mb-1">
                                        Diskon <?= number_to_currency($product['diskon'], 'IDR') ?>
                                    </p>

                                    <p class="mb-1">
                                        <?= number_to_currency($product['subtotal_harga'], 'IDR') ?>
                                    </p>
                                </div>

                                <hr>
                            <?php endforeach; ?>

                            <p class="mb-0">
                                Ongkir <?= number_to_currency($transaction['ongkir'], 'IDR') ?>
                            </p>
                        <?php else : ?>
                            <p class="text-muted">Tidak ada detail produk.</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>