<?= $this->extend('admin/layout'); ?>
<?= $this->section('content'); ?>

<div class="product-card">
    <div class="card-header">
        <h2>Add New Product</h2>
    </div>

    <form action="/admin/produk/simpan" method="post" class="form-grid" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" required class="input" value="<?= old('nama'); ?>">
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" required class="input" value="<?= old('kategori'); ?>">
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" required class="input" step="0.01" value="<?= old('harga'); ?>">
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" required class="input" value="<?= old('stok'); ?>">
        </div>

        <div class="form-group">
            <label for="inputImage">Gambar Produk</label>

            <div class="file-group">
                <input type="text" id="file-text" class="form-control file-text" placeholder="Pilih file..." readonly>
                <label for="inputImage" class="file-btn">Pilih File</label>

                <input type="file" name="image" id="inputImage"
                    class="file-hidden <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>" accept="image/*"
                    onchange="showFileName()" required>
            </div>

            <div class="invalid-feedback">
                <?= $validation->getError('image'); ?>
            </div>
        </div>

        <div class="form-group-full">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="input"><?= old('deskripsi'); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Simpan Produk</button>
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

    label {
        font-size: 14px;
        color: #ffdf3c;
        font-weight: 500;
    }

    .form-actions {
        grid-column: span 2;
        text-align: right;
    }

    .btn-save {
        background: #ffdf3c;
        color: #000;
        padding: 14px 26px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-save:hover {
        background: #ffc107;
    }

    .file-group {
        display: flex;
        align-items: center;
        gap: 10px;
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

    .invalid-feedback {
        color: #ff6b6b;
        font-size: 12px;
        margin-top: 5px;
    }

    @media(max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group-full,
        .form-actions {
            grid-column: span 1;
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