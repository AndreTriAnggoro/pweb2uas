<?= $this->extend('admin/layout'); ?>
<?= $this->section('content'); ?>

<div class="product-card">
    <div class="card-header">
        <h2>Edit Produk</h2>
    </div>

    <form action="/admin/produk/update/<?= $produk['produk_id']; ?>" method="post" class="form-grid"
        enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" required class="input" value="<?= old('nama', $produk['nama']); ?>">
            <?php if($validation->hasError('nama')): ?>
            <small style="color:#ff6b6b;"><?= $validation->getError('nama'); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" required class="input"
                value="<?= old('kategori', $produk['kategori']); ?>">
            <?php if($validation->hasError('kategori')): ?>
            <small style="color:#ff6b6b;"><?= $validation->getError('kategori'); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" required class="input" step="0.01"
                value="<?= old('harga', $produk['harga']); ?>">
            <?php if($validation->hasError('harga')): ?>
            <small style="color:#ff6b6b;"><?= $validation->getError('harga'); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" required class="input" value="<?= old('stok', $produk['stok']); ?>">
            <?php if($validation->hasError('stok')): ?>
            <small style="color:#ff6b6b;"><?= $validation->getError('stok'); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Rating (Optional)</label>
            <input type="number" name="rating" class="input" step="0.01" min="0" max="5"
                value="<?= old('rating', $produk['rating'] ?? ''); ?>">
            <?php if($validation->hasError('rating')): ?>
            <small style="color:#ff6b6b;"><?= $validation->getError('rating'); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="inputImage">Gambar Produk (Optional)</label>

            <div class="file-group">
                <input type="text" id="file-text" class="file-text" placeholder="Pilih file baru..." readonly>

                <label for="inputImage" class="file-btn">Pilih File</label>

                <input type="file" name="image" id="inputImage"
                    class="file-hidden <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>" accept="image/*"
                    onchange="showFileName()">
            </div>

            <?php if($produk['image']): ?>
            <div style="margin-top:10px;">
                <small style="color:#999;">Gambar saat ini:</small>
                <div style="margin-top:8px;">
                    <img src="/uploads/produk/<?= htmlspecialchars($produk['image']); ?>"
                        alt="<?= htmlspecialchars($produk['nama']); ?>"
                        style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                </div>
            </div>
            <?php else: ?>
            <small style="color:#999; display:block; margin-top:5px;">Belum ada gambar</small>
            <?php endif; ?>

            <?php if($validation->hasError('image')): ?>
            <small style="color:#ff6b6b; display:block; margin-top:5px;">
                <?= $validation->getError('image'); ?>
            </small>
            <?php endif; ?>
        </div>

        <div class="form-group-full">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4"
                class="input"><?= old('deskripsi', $produk['deskripsi'] ?? ''); ?></textarea>
            <?php if($validation->hasError('deskripsi')): ?>
            <small style="color:#ff6b6b;"><?= $validation->getError('deskripsi'); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <a href="/admin/produk" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Update Produk</button>
        </div>

    </form>
</div>

<style>
.product-card {
    background: #3a444e;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.card-header h2 {
    margin: 0 0 20px 0;
    font-weight: 600;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group-full {
    grid-column: span 2;
    display: flex;
    flex-direction: column;
}

.input,
.select {
    width: 90%;
    padding: 14px;
    margin-top: 5px;
    background: #2c3440;
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 8px;
    color: #fff;
    transition: 0.2s;
}

.input:focus,
.select:focus {
    outline: none;
    border-color: #ffdf3c;
    box-shadow: 0 0 0 3px rgba(255, 223, 60, 0.1);
}

label {
    font-size: 14px;
    color: #ffdf3c;
    font-weight: 500;
}

small {
    font-size: 12px;
    margin-top: 5px;
}

.form-actions {
    grid-column: span 2;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-save,
.btn-cancel {
    padding: 14px 26px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-save {
    background: #ffdf3c;
    color: #000;
}

.btn-save:hover {
    background: #ffc107;
}

.btn-cancel {
    background: #666;
    color: #fff;
}

.btn-cancel:hover {
    background: #777;
}

.file-group {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 5px;
}

.file-text {
    flex: 1;
    background: #2d3541;
    border: 1px solid #3a424d;
    color: #dce7eb;
    padding: 15px;
    border-radius: 6px;
}

.file-btn {
    padding: 12px 16px;
    background: #ffc107;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    color: #333;
    white-space: nowrap;
}

.file-hidden {
    display: none;
}

.is-invalid {
    border-color: #ff6b6b !important;
}

@media(max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-group-full,
    .form-actions {
        grid-column: span 1;
    }

    .input {
        width: 100%;
    }
}
</style>

<script>
function showFileName() {
    const input = document.getElementById('inputImage');
    const textInput = document.getElementById('file-text');

    if (input.files.length > 0) {
        textInput.value = input.files[0].name;
    } else {
        textInput.value = "";
    }
}
</script>

<?= $this->endSection(); ?>