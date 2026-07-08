<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>

<!-- Table with stripped rows -->
<div class="row">
    <?php foreach ($products as $key => $item) : ?>
        <div class="col-lg-6">
            <?= form_open('keranjang') ?>
            <?php
            echo form_hidden('id', (string) $item['id']);
            echo form_hidden('nama', (string) $item['nama']);
            echo form_hidden('harga', (string) $item['harga_diskon']);
            echo form_hidden('harga_asli', (string) $item['harga_asli']);
            echo form_hidden('diskon', (string) $nominalDiscount);
            echo form_hidden('foto', (string) $item['foto']);
            ?>

            <div class="card">
                <div class="card-body">
                    <img src="<?= base_url() . "img/" . $item['foto'] ?>" alt="..." width="50%">

                    <h5 class="card-title"><?= $item['nama'] ?></h5>

                    <?php if (!empty($nominalDiscount) && $item['harga_diskon'] < $item['harga_asli']) : ?>
                        <span class="text-danger" style="text-decoration: line-through;">
                            <?= number_to_currency($item['harga_asli'], 'IDR') ?>
                        </span>
                        <span class="fw-bold">
                            <?= number_to_currency($item['harga_diskon'], 'IDR') ?>
                        </span>
                    <?php else : ?>
                        <span class="fw-bold">
                            <?= number_to_currency($item['harga_asli'], 'IDR') ?>
                        </span>
                    <?php endif; ?>

                    <br>

                    <button type="submit" class="btn btn-info rounded-pill mt-2">Beli</button>
                </div>
            </div>

            <?= form_close() ?>
        </div>
    <?php endforeach ?>
</div>
<!-- End Table with stripped rows -->
<?= $this->endSection() ?>