<?= $this->extend('admin/layout'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Products</h2>
        <a href="/admin/produk/tambah" style="
            background:#ffdf3c;
            padding:12px 20px;
            border-radius:8px;
            font-weight:600;
            color:#000;
            text-decoration:none;
            transition:0.2s;">
            + Add New Product
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
    <div style="background:#4caf50; color:#fff; padding:12px; border-radius:8px; margin-bottom:15px;">
        <?= session()->getFlashdata('success'); ?>
    </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
    <div style="background:#f44336; color:#fff; padding:12px; border-radius:8px; margin-bottom:15px;">
        <?= session()->getFlashdata('error'); ?>
    </div>
    <?php endif; ?>

    <?php if(empty($products)): ?>
    <div style="text-align:center; padding:40px; color:#999;">
        <p>Belum ada produk. <a href="/admin/produk/tambah" style="color:#ffdf3c;">Tambah produk sekarang</a></p>
    </div>
    <?php else: ?>
    <div style="overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background:#1f2732; border-bottom:2px solid rgba(255,255,255,0.1);">
                    <th style="padding:15px; text-align:left; width:60px;">Gambar</th>
                    <th style="padding:15px; text-align:left;">Nama</th>
                    <th style="padding:15px; text-align:left;">Kategori</th>
                    <th style="padding:15px; text-align:left;">Deskripsi</th>
                    <th style="padding:15px; text-align:right;">Harga</th>
                    <th style="padding:15px; text-align:center;">Stok</th>
                    <th style="padding:15px; text-align:center;">Rating</th>
                    <th style="padding:15px; text-align:center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $p): ?>
                <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
                    <td style="padding:15px;">
                        <?php if($p['image']): ?>
                        <img src="/uploads/produk/<?= htmlspecialchars($p['image']); ?>"
                            alt="<?= htmlspecialchars($p['nama']); ?>"
                            style="width:50px; height:50px; object-fit:cover; border-radius:6px;">
                        <?php else: ?>
                        <div
                            style="width:50px; height:50px; background:#3a444e; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#999; font-size:10px;">
                            No Image
                        </div>
                        <?php endif; ?>
                    </td>
                    <td style="padding:15px;">
                        <strong><?= htmlspecialchars($p['nama']); ?></strong>
                        <br>
                        <small style="color:#999;">SKU: <?= htmlspecialchars($p['slug']); ?></small>
                    </td>
                    <td style="padding:15px;">
                        <span style="background:#3a444e; padding:6px 12px; border-radius:6px; font-size:12px;">
                            <?= htmlspecialchars($p['kategori']); ?>
                        </span>
                    </td>
                    <td style="padding:15px; max-width:250px;">
                        <small
                            style="color:#ccc; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            <?= htmlspecialchars($p['deskripsi'] ?? '-'); ?>
                        </small>
                    </td>
                    <td style="padding:15px; text-align:right;">
                        <strong style="font-size:16px;">Rp <?= number_format($p['harga']); ?></strong>
                    </td>
                    <td style="padding:15px; text-align:center;">
                        <?php if($p['stok'] > 0): ?>
                        <span style="color:#9eff9e; font-weight:600;"><?= $p['stok']; ?></span>
                        <?php else: ?>
                        <span style="color:#ff8282; font-weight:600;">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:15px; text-align:center;">
                        <?php if($p['rating']): ?>
                        <span style="color:#ffdf3c;">★ <?= number_format($p['rating'], 1); ?></span>
                        <?php else: ?>
                        <span style="color:#999;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:15px; text-align:center;">
                        <a href="/admin/produk/ubah/<?= $p['produk_id']; ?>"
                            style="color:#ffdf3c; text-decoration:none; margin-right:8px; font-weight:500;">
                            ✎ Edit
                        </a>

                        <a href="/admin/produk/delete/<?= $p['produk_id']; ?>"
                            onclick="return confirm('Yakin hapus produk ini?')"
                            style="color:#ff6b6b; text-decoration:none; font-weight:500;">
                            ✕ Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<style>
.card {
    background: #3a444e;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    color: #fff;
}

.card h2 {
    font-size: 24px;
    font-weight: 600;
    margin: 0;
}

table {
    font-size: 13px;
}

table thead th {
    font-weight: 600;
    color: #ffdf3c;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

table tbody tr {
    transition: 0.2s background;
}

table tbody tr:hover {
    background: #2a3340;
}

@media(max-width: 1200px) {
    table {
        font-size: 12px;
    }

    table th,
    table td {
        padding: 12px !important;
    }
}

@media(max-width: 768px) {
    table {
        font-size: 11px;
    }

    table thead {
        display: none;
    }

    table tbody tr {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 12px;
        background: #2a3340;
    }

    table tbody tr:hover {
        background: #333d48;
    }

    table tbody td {
        display: grid;
        grid-template-columns: 100px 1fr;
        gap: 10px;
        align-items: start;
        padding: 0 !important;
    }

    table tbody td::before {
        font-weight: 600;
        color: #ffdf3c;
        word-break: break-word;
    }

    table tbody td:nth-child(1) {
        grid-column: span 2;
    }

    table tbody td:nth-child(1)::before {
        content: "Gambar";
    }

    table tbody td:nth-child(2)::before {
        content: "Nama";
    }

    table tbody td:nth-child(3)::before {
        content: "Kategori";
    }

    table tbody td:nth-child(4)::before {
        content: "Deskripsi";
    }

    table tbody td:nth-child(5)::before {
        content: "Harga";
    }

    table tbody td:nth-child(6)::before {
        content: "Stok";
    }

    table tbody td:nth-child(7)::before {
        content: "Rating";
    }

    table tbody td:nth-child(8) {
        grid-column: span 2;
        grid-template-columns: 1fr;
    }

    table tbody td:nth-child(8)::before {
        content: "Aksi";
    }

    table tbody td:nth-child(8) {
        display: flex;
        gap: 10px;
    }
}
</style>

<?= $this->endSection(); ?>