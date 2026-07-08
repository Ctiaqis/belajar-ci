<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
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

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Data
</button>

<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($discounts as $index => $discount) : ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $discount['tanggal'] ?></td>
                <td><?= number_to_currency($discount['nominal'], 'IDR') ?></td>
                <td><?= $discount['created_at'] ?></td>
                <td><?= $discount['updated_at'] ?></td>
                <td>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $discount['id'] ?>">
                        Ubah
                    </button>

                    <a href="<?= base_url('diskon/delete/' . $discount['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini ?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->include('diskon/modal_add') ?>
<?= $this->include('diskon/modal_edit') ?>

<?= $this->endSection() ?>